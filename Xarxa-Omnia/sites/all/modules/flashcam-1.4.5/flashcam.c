///////////////////////////////////////////////////////////
//
// From the original capture.c found at sexbytes.org
// where all V4L2 starts
// http://v4l2spec.bytesex.org/
//
// Changes under MIT License
//
// Copyright 2008-2010 - Flashcam project (Olivier Debon)
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
// 
// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.
// 
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
// THE SOFTWARE.
// AUTHOR(S):
//            Olivier Debon olivier@debon.net
//
// MODS:
//            John Loza jgloza@users.sourceforge.net
//              * Buffer overflows in strings management
//	      Kai Meyer (@SF)
//		* GBRG format support
//
///////////////////////////////////////////////////////////
/*
   What is the purpose of this utility?
   It aims at allowing V4L2 webcam to be supported by
   Flash Plugin (from Macromedia/Adobe). How? It relies
   on a modifided version of vloopback driver, once
   instanciated, this driver creates 2 ends, one for
   reading one for writing and both are V4L1 compatible.
   This program opens a V4L2 device (such as UVC web
   cam driver provides) and forward frames to the loopback.
   The other end is used by Flash that exclusively use
   read method on V4L1 devices and in YUV420P format
   only.

   This utility can of course be really improved to support
   to forward V4L1 devices content and other circumtances
   where Flash just ignores other sources.
 */

/*
 *  V4L2 video capture example
 *
 *  This program can be used and distributed without restrictions.
 */

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <assert.h>

#include <getopt.h>             /* getopt_long() */

#include <fcntl.h>              /* low-level i/o */
#include <unistd.h>
#include <signal.h>
#include <errno.h>
#include <malloc.h>
#include <sys/stat.h>
#include <sys/types.h>
#include <sys/time.h>
#include <sys/mman.h>
#include <sys/ioctl.h>
#include <linux/videodev.h>
#include <linux/videodev2.h>

#define CLEAR(x) memset (&(x), 0, sizeof (x))

typedef enum {
	IO_METHOD_READ,
	IO_METHOD_MMAP,
	IO_METHOD_USERPTR,
} io_method;

struct buffer {
        void *                  start;
        size_t                  length;
};

static char *           dev_name        = NULL;
static io_method	io		= IO_METHOD_MMAP;
static int              fd              = -1;
struct buffer *         buffers         = NULL;
static unsigned int     n_buffers       = 0;
static int 		width		= 160;	// Default for Flash
static int 		height		= 120;	// Default for Flash
static unsigned long	pixfmt		= 0;
static char *           loop_name       = NULL;
static int		loop		= -1;
static char *		yuv420p		= NULL;
static int		loadDriver	= 0;
static char *		loadcmd		= "modprobe";	// Default command to load a module
static int		verbose		= 1;
static int		detach		= 0;

static void
errno_exit(const char *s)
{
    fprintf (stderr, "%s error %d, %s\n", s, errno, strerror (errno));
    exit (EXIT_FAILURE);
}

static int
xioctl(int fd, int request, void *arg)
{
        int r;

        do r = ioctl (fd, request, arg);
        while (r == -1 && EINTR == errno);

        return r;
}

/* Send frame in V4L1 language */
static void
send_image(const char *p, int length)
{	
    int x,y;
    char *Y,*U,*V;

    Y = yuv420p;
    U = Y + width*height;
    V = U + width*height/4;

    //printf("Got frame\n");

    switch(pixfmt) {
    case V4L2_PIX_FMT_YUYV:
	// Convert from YUV422 to YUV420P
        for(y=0;y<height;y++) {
	    for(x=0;x<width;x+=2) {
		Y[y*width + x] = p[y*width*2 + x*2];
		Y[y*width + x + 1] = p[y*width*2 + x*2 + 2];
		U[(y/2)*(width/2) + x/2] = p[y*width*2 + x*2 + 1];
		V[(y/2)*(width/2) + x/2] = p[y*width*2 + x*2 + 3];
	    }
	}
	break;
    case V4L2_PIX_FMT_SBGGR8:	// SN9C102
	{
	    long R,G,B;
	    long u16,v16;

#define CLIPY(y) ((y)<0?-(y):(y)>=height?(2*height-(y)):(y))
#define CLIPX(x) ((x)<0?-(x):(x)>=width?(2*width-(x)):(x))
#define PIX(x,y) (unsigned char)(p[(CLIPY(y))*width + (CLIPX(x))])
	    u16 = v16 = 0;  // Reset u and v
	    for(y=0;y<height;y++) {
		for(x=0;x<width;x++) {
		    switch (((y&1)<<1) | (x&1)) {
		    case 0:
			R = (PIX(x+1,y+1) + PIX(x-1,y-1) + PIX(x-1,y+1) + PIX(x+1,y-1))/4;
			G = (PIX(x-1,y) + PIX(x+1,y) + PIX(x,y-1) + PIX(x,y+1))/4;
			B = PIX(x,y);
			u16 = v16 = 0;  // Reset u and v
			break;
		    case 1:
			R = (PIX(x,y-1) + PIX(x,y+1))/2;
			G = PIX(x,y);
			B = (PIX(x-1,y) + PIX(x+1,y))/2;
			break;
		    case 2:
			R = (PIX(x-1,y) + PIX(x+1,y))/2;
			G = PIX(x,y);
			B = (PIX(x,y-1) + PIX(x,y+1))/2;
			break;
		    case 3:
			R = PIX(x,y);
			G = (PIX(x-1,y) + PIX(x+1,y) + PIX(x,y-1) + PIX(x,y+1))/4;
			B = (PIX(x+1,y+1) + PIX(x-1,y-1) + PIX(x-1,y+1) + PIX(x+1,y-1))/4;
			break;
		    }
		    Y[y*width + x] = (unsigned char)((19595 * R + 38470 * G + 7471 * B)>>16);
		    u16 += -11059 * R - 21709 * G + 32768 * B;
		    v16 +=  32768 * R - 27439 * G -  5329 * B;
		    if ((y&1)==0 && (x&1)) {
			U[(y/2)*(width/2) + x/2] = (unsigned char)((u16>>17) + 128);
			V[(y/2)*(width/2) + x/2] = (unsigned char)((v16>>17) + 128);
		    }
		}
	    }
	}
	break;
    case V4L2_PIX_FMT_SGBRG8: // Dumb GBRG format
	{
	    long R,G,B;
	    long u16,v16;
	    
#define CLIPY(y) ((y)<0?-(y):(y)>=height?(2*height-(y)):(y))
#define CLIPX(x) ((x)<0?-(x):(x)>=width?(2*width-(x)):(x))
#define PIX(x,y) (unsigned char)(p[(CLIPY(y))*width + (CLIPX(x))])
	    u16 = v16 = 0; // Reset u and v
	    for(y=0;y<height;y++) {
		for(x=0;x<width;x++) {
		    switch (((y&1)<<1) | (x&1)) {
		    case 1:
			R = (PIX(x+1,y+1) + PIX(x-1,y-1) + PIX(x-1,y+1) + PIX(x+1,y-1))/4;
			G = (PIX(x-1,y) + PIX(x+1,y) + PIX(x,y-1) + PIX(x,y+1))/4;
			B = PIX(x,y);
			break;
		    case 0:
			R = (PIX(x,y-1) + PIX(x,y+1))/2;
			G = PIX(x,y);
			B = (PIX(x-1,y) + PIX(x+1,y))/2;
			u16 = v16 = 0; // Reset u and v
			break;
		    case 3:
			R = (PIX(x-1,y) + PIX(x+1,y))/2;
			G = PIX(x,y);
			B = (PIX(x,y-1) + PIX(x,y+1))/2;
			break;
		    case 2:
			R = PIX(x,y);
			G = (PIX(x-1,y) + PIX(x+1,y) + PIX(x,y-1) + PIX(x,y+1))/4;
			B = (PIX(x+1,y+1) + PIX(x-1,y-1) + PIX(x-1,y+1) + PIX(x+1,y-1))/4;
			break;
		    }
		    Y[y*width + x] = (unsigned char)((19595 * R + 38470 * G + 7471 * B)>>16);
		    u16 += -11059 * R - 21709 * G + 32768 * B;
		    v16 += 32768 * R - 27439 * G - 5329 * B;
		    if ((y&1)==0 && (x&1)) {
			U[(y/2)*(width/2) + x/2] = (unsigned char)((u16>>17) + 128);
			V[(y/2)*(width/2) + x/2] = (unsigned char)((v16>>17) + 128);
		    }
		}
	    }
	}
	break;
    default:
	printf("Unsupported format.\n");
	exit(EXIT_FAILURE);
    }

    if (loop == -1) {	// When testing w/o loop
	return;
    }

    /* Vloopback has been modified to block on write when no ones
     * read from the other end of the pipe (e.g Flash plugin)
     */
    int l;

    l = width*height + width*height/2;
    if (write(loop, yuv420p, l)!=l) {
	printf("Error writing image to pipe!\nError[%s]\n",strerror(errno));
	exit(1);
    }
}

/* Read frame in V4L2 language */
static int
read_frame()
{
    struct v4l2_buffer buf;
    unsigned int i;

    switch (io) {
    case IO_METHOD_READ:
	if (read (fd, buffers[0].start, buffers[0].length) < 0) {
		switch (errno) {
		case EAGAIN:
			return 0;

		case EIO:
			/* Could ignore EIO, see spec. */

			/* fall through */

		default:
			errno_exit ("read");
		}
	}

	send_image (buffers[0].start, buffers[0].length);
	break;
    case IO_METHOD_MMAP:
	CLEAR (buf);

	buf.type = V4L2_BUF_TYPE_VIDEO_CAPTURE;
	buf.memory = V4L2_MEMORY_MMAP;

	if (xioctl(fd, VIDIOC_DQBUF, &buf) < 0) {
		switch (errno) {
		case EAGAIN:
			return 0;
		case EIO:
			/* Could ignore EIO, see spec. */
		default:
			errno_exit ("VIDIOC_DQBUF");
		}
	}

	assert (buf.index < n_buffers);

	send_image (buffers[buf.index].start, buf.length);

	if (xioctl (fd, VIDIOC_QBUF, &buf) < 0) {
	    errno_exit ("VIDIOC_QBUF");
	}
	break;
    case IO_METHOD_USERPTR:
	CLEAR (buf);

	buf.type = V4L2_BUF_TYPE_VIDEO_CAPTURE;
	buf.memory = V4L2_MEMORY_USERPTR;

	if (xioctl(fd, VIDIOC_DQBUF, &buf) < 0) {
		switch (errno) {
		case EAGAIN:
			return 0;

		case EIO:
			/* Could ignore EIO, see spec. */
			/* fall through */
		default:
			errno_exit ("VIDIOC_DQBUF");
		}
	}

	for (i = 0; i < n_buffers; ++i) {
	    if (buf.m.userptr == (unsigned long) buffers[i].start
	     && buf.length == buffers[i].length) break;
	}

	assert (i < n_buffers);

	send_image((const char *) buf.m.userptr, buf.length);

	if (xioctl (fd, VIDIOC_QBUF, &buf) < 0) {
		errno_exit ("VIDIOC_QBUF");
	}
	break;
    }

    return 1;
}

static void
mainloop()
{
    while (1) {
	fd_set fds;
	struct timeval tv;
	int r;

	FD_ZERO (&fds);
	FD_SET (fd, &fds);

	r = select(fd + 1, &fds, NULL, NULL, NULL);

	if (r < 0) {
	    if (EINTR == errno) {
		continue;
	    }

	    errno_exit ("select");
	}

	read_frame();
    }
}

static void
stop_capturing                  (void)
{
    enum v4l2_buf_type type;

    switch (io) {
    case IO_METHOD_READ:
	/* Nothing to do. */
	break;
    case IO_METHOD_MMAP:
    case IO_METHOD_USERPTR:
	type = V4L2_BUF_TYPE_VIDEO_CAPTURE;

	if (xioctl (fd, VIDIOC_STREAMOFF, &type) < 0) {
	    errno_exit ("VIDIOC_STREAMOFF");
	}

	break;
    }
}

static void
start_capturing()
{
    unsigned int i;
    enum v4l2_buf_type type;

    switch (io) {
    case IO_METHOD_READ:
	/* Nothing to do. */
	break;

    case IO_METHOD_MMAP:
	for (i = 0; i < n_buffers; ++i) {
	    struct v4l2_buffer buf;

	    CLEAR (buf);

	    buf.type        = V4L2_BUF_TYPE_VIDEO_CAPTURE;
	    buf.memory      = V4L2_MEMORY_MMAP;
	    buf.index       = i;

	    if (xioctl(fd, VIDIOC_QBUF, &buf) < 0) {
		errno_exit ("VIDIOC_QBUF");
	    }
	}
	
	type = V4L2_BUF_TYPE_VIDEO_CAPTURE;

	if (xioctl (fd, VIDIOC_STREAMON, &type) < 0) {
	    errno_exit ("VIDIOC_STREAMON");
	}
	break;

    case IO_METHOD_USERPTR:
	for (i = 0; i < n_buffers; ++i) {
	    struct v4l2_buffer buf;

	    CLEAR (buf);

	    buf.type        = V4L2_BUF_TYPE_VIDEO_CAPTURE;
	    buf.memory      = V4L2_MEMORY_USERPTR;
	    buf.index       = i;
	    buf.m.userptr   = (unsigned long) buffers[i].start;
	    buf.length      = buffers[i].length;

	    if (xioctl (fd, VIDIOC_QBUF, &buf) < 0) {
		errno_exit ("VIDIOC_QBUF");
	    }
	}

	type = V4L2_BUF_TYPE_VIDEO_CAPTURE;

	if (xioctl (fd, VIDIOC_STREAMON, &type) < 0) {
	    errno_exit ("VIDIOC_STREAMON");
	}

	break;
    }
}

static void
uninit_device()
{
    unsigned int i;

    switch (io) {
    case IO_METHOD_READ:
	free (buffers[0].start);
	break;

    case IO_METHOD_MMAP:
	for (i = 0; i < n_buffers; ++i)
	    if (-1 == munmap (buffers[i].start, buffers[i].length))
		errno_exit ("munmap");
	break;

    case IO_METHOD_USERPTR:
	for (i = 0; i < n_buffers; ++i) free (buffers[i].start);
	break;
    }

    free (buffers);
}

static void
init_read(unsigned int buffer_size)
{
    buffers = calloc (1, sizeof (*buffers));

    if (!buffers) {
	fprintf (stderr, "Out of memory\n");
	exit (EXIT_FAILURE);
    }

    buffers[0].length = buffer_size;
    buffers[0].start = malloc (buffer_size);

    if (!buffers[0].start) {
	fprintf (stderr, "Out of memory\n");
	exit (EXIT_FAILURE);
    }
}

static void
init_mmap()
{
    struct v4l2_requestbuffers req;

    CLEAR (req);

    req.count               = 4;
    req.type                = V4L2_BUF_TYPE_VIDEO_CAPTURE;
    req.memory              = V4L2_MEMORY_MMAP;

    if (xioctl(fd, VIDIOC_REQBUFS, &req) < 0) {
	if (errno == EINVAL) {
	    fprintf (stderr, "%s does not support "
		     "memory mapping\n", dev_name);
	    exit (EXIT_FAILURE);
	} else {
	    errno_exit ("VIDIOC_REQBUFS");
	}
    }

    if (req.count < 2) {
	fprintf (stderr, "Insufficient buffer memory on %s\n", dev_name);
	exit (EXIT_FAILURE);
    }

    buffers = calloc (req.count, sizeof (*buffers));

    if (!buffers) {
	fprintf (stderr, "Out of memory\n");
	exit (EXIT_FAILURE);
    }

    for (n_buffers = 0; n_buffers < req.count; ++n_buffers) {
	struct v4l2_buffer buf;

	CLEAR (buf);

	buf.type        = V4L2_BUF_TYPE_VIDEO_CAPTURE;
	buf.memory      = V4L2_MEMORY_MMAP;
	buf.index       = n_buffers;

	if (xioctl(fd, VIDIOC_QUERYBUF, &buf) < 0)
	    errno_exit ("VIDIOC_QUERYBUF");

	buffers[n_buffers].length = buf.length;
	buffers[n_buffers].start = mmap (NULL /* start anywhere */,
		                         buf.length,
		                         PROT_READ | PROT_WRITE /* required */,
		                         MAP_SHARED /* recommended */,
		                         fd, buf.m.offset);

	if (MAP_FAILED == buffers[n_buffers].start) errno_exit ("mmap");
    }
}

static void
init_userp(unsigned int buffer_size)
{
    struct v4l2_requestbuffers req;
    unsigned int page_size;

    page_size = getpagesize();
    buffer_size = (buffer_size + page_size - 1) & ~(page_size - 1);

    CLEAR (req);

    req.count  = 4;
    req.type   = V4L2_BUF_TYPE_VIDEO_CAPTURE;
    req.memory = V4L2_MEMORY_USERPTR;

    if (xioctl(fd, VIDIOC_REQBUFS, &req) < 0) {
	if (EINVAL == errno) {
	    fprintf (stderr, "%s does not support user pointer i/o\n", dev_name);
	    exit (EXIT_FAILURE);
	} else {
	    errno_exit ("VIDIOC_REQBUFS");
	}
    }

    buffers = calloc (4, sizeof (*buffers));

    if (buffers == NULL) {
	fprintf (stderr, "Out of memory\n");
	exit (EXIT_FAILURE);
    }

    for (n_buffers = 0; n_buffers < 4; ++n_buffers) {
	buffers[n_buffers].length = buffer_size;
	buffers[n_buffers].start = memalign(/* boundary */ page_size, buffer_size);

	if (buffers[n_buffers].start == NULL) {
	    fprintf (stderr, "Out of memory\n");
	    exit (EXIT_FAILURE);
	}
    }
}

static void
init_device                     (void)
{
    struct v4l2_capability cap;
    struct v4l2_cropcap cropcap;
    struct v4l2_crop crop;
    struct v4l2_format fmt;
    unsigned int min;

    if (xioctl (fd, VIDIOC_QUERYCAP, &cap) < 0) {
	if (EINVAL == errno) {
	    fprintf (stderr, "%s is no V4L2 device\n", dev_name);
	    exit (EXIT_FAILURE);
	} else {
	    errno_exit ("VIDIOC_QUERYCAP");
	}
    }

    if (!(cap.capabilities & V4L2_CAP_VIDEO_CAPTURE)) {
	fprintf (stderr, "%s is no video capture device\n", dev_name);
	exit (EXIT_FAILURE);
    }

    switch (io) {
    case IO_METHOD_READ:
	if (!(cap.capabilities & V4L2_CAP_READWRITE)) {
	    fprintf (stderr, "%s does not support read i/o\n", dev_name);
	    exit (EXIT_FAILURE);
	}
	break;

    case IO_METHOD_MMAP:
    case IO_METHOD_USERPTR:
	if (!(cap.capabilities & V4L2_CAP_STREAMING)) {
	    fprintf (stderr, "%s does not support streaming i/o\n", dev_name);
	    exit (EXIT_FAILURE);
	}
	break;
    }


    /* Select video input, video standard and tune here. */
    CLEAR (cropcap);

    cropcap.type = V4L2_BUF_TYPE_VIDEO_CAPTURE;

    if (xioctl (fd, VIDIOC_CROPCAP, &cropcap) == 0) {
	crop.type = V4L2_BUF_TYPE_VIDEO_CAPTURE;
	crop.c = cropcap.defrect; /* reset to default */

	xioctl(fd, VIDIOC_S_CROP, &crop);
    }


    CLEAR (fmt);

    fmt.type                = V4L2_BUF_TYPE_VIDEO_CAPTURE;
    fmt.fmt.pix.width       = width; 
    fmt.fmt.pix.height      = height;
    fmt.fmt.pix.pixelformat = V4L2_PIX_FMT_YUYV;
    fmt.fmt.pix.field       = V4L2_FIELD_ANY;

    if (xioctl (fd, VIDIOC_S_FMT, &fmt) < 0)
	    errno_exit ("VIDIOC_S_FMT");

    /* Note VIDIOC_S_FMT may change width and height. */

    if (xioctl (fd, VIDIOC_G_FMT, &fmt) < 0)
	    errno_exit ("VIDIOC_S_FMT");

    width = fmt.fmt.pix.width; 
    height = fmt.fmt.pix.height;
    pixfmt = fmt.fmt.pix.pixelformat;

    if (verbose) {
	printf("Size = %d x %d\n", width, height);
	printf("Pixel format = %c%c%c%c\n",
		    fmt.fmt.pix.pixelformat & 0xff,
		    (fmt.fmt.pix.pixelformat >> 8) & 0xff,
		    (fmt.fmt.pix.pixelformat >> 16) & 0xff,
		    (fmt.fmt.pix.pixelformat >> 24) & 0xff
		    );
	printf("Bpl = %d\n", fmt.fmt.pix.bytesperline);
    }

    /* Buggy driver paranoia. */
    min = fmt.fmt.pix.width * 2;
    if (fmt.fmt.pix.bytesperline < min) fmt.fmt.pix.bytesperline = min;
    min = fmt.fmt.pix.bytesperline * fmt.fmt.pix.height;
    if (fmt.fmt.pix.sizeimage < min) fmt.fmt.pix.sizeimage = min;

    switch (io) {
    case IO_METHOD_READ:
	    init_read (fmt.fmt.pix.sizeimage);
	    break;
    case IO_METHOD_MMAP:
	    init_mmap ();
	    break;
    case IO_METHOD_USERPTR:
	    init_userp (fmt.fmt.pix.sizeimage);
	    break;
    }
}

static void
close_device()
{
    if (close (fd) < 0) {
	errno_exit ("close");
    }
}

static void
open_loop()
{
    loop = open(loop_name, O_WRONLY);
    if (loop == -1) {
	printf("Failed to open loop device. (%s)\n", strerror(errno));
	exit (EXIT_FAILURE);
    }

    struct video_window vid_win;
    struct video_picture vid_pic;

    vid_pic.palette = VIDEO_PALETTE_YUV420P;
    if (ioctl (loop, VIDIOCSPICT, &vid_pic)== -1) {
	printf ("ioctl VIDIOCSPICT\nError[%s]\n",strerror(errno));
	exit (EXIT_FAILURE);
    }
    if (ioctl (loop, VIDIOCGWIN, &vid_win)== -1) {
	printf ("ioctl VIDIOCGWIN");
	exit (EXIT_FAILURE);
    }
    vid_win.width=width;
    vid_win.height=height;
    if (ioctl (loop, VIDIOCSWIN, &vid_win)== -1) {
	printf ("ioctl VIDIOCSWIN");
	exit (EXIT_FAILURE);
    }
    yuv420p = (char *)malloc(width*height + width*height/2);
    if (yuv420p == NULL) {
	fprintf (stderr, "Out of memory\n");
	exit(EXIT_FAILURE);
    }
}

static void
open_device()
{
    struct stat st; 

    if (stat (dev_name, &st) < 0) {
	fprintf (stderr, "Cannot identify '%s': %d, %s\n", dev_name, errno, strerror (errno));
	exit (EXIT_FAILURE);
    }

    if (!S_ISCHR (st.st_mode)) {
	fprintf (stderr, "%s is no device\n", dev_name);
	exit (EXIT_FAILURE);
    }

    fd = open(dev_name, O_RDWR /* required */ | O_NONBLOCK, 0);

    if (fd < 0) {
	fprintf (stderr, "Cannot open '%s': %d, %s\n", dev_name, errno, strerror (errno));
	exit (EXIT_FAILURE);
    }

    if (verbose) {
	printf("Input device: %s\n", dev_name);
    }
}

static void
usage(FILE *fp, int argc, char **argv)
{
    fprintf (fp,
	     "Usage: %s [options]\n\n"
	     "Options:\n"
	     "-S, --scan	    Scan all devices, report and quit\n"
	     "-L, --loaddriver	    Scan all devices, load vloopback driver and quit (requires to be root)\n"
	     "    --loadcmd command Command to load a module. Default: modprobe\n"
	     "-D, --daemon	    Detach from tty, run as daemon\n"
	     "-l, --loop name	    Loop device name\n"
	     "-d, --device name	    Video device name [/dev/video]\n"
	     "-m, --mmap	    Use memory mapped buffers\n"
	     "-r, --read	    Use read() calls\n"
	     "-u, --userp	    Use application allocated buffers\n"
	     "-s, --size WxH	    Set frame size\n"
	     "-q, --quiet	    Run silently\n"
	     "-h, --help	    Print this message\n"
	     "",
	     argv[0]);
}

static const char short_options [] = "d:l:hmruqs:SLD";

static const struct option long_options [] = {
    { "device",     required_argument, NULL, 'd' },
    { "loop",       required_argument, NULL, 'l' },
    { "size",       required_argument, NULL, 's' },
    { "help",       no_argument,       NULL, 'h' },
    { "mmap",       no_argument,       NULL, 'm' },
    { "read",       no_argument,       NULL, 'r' },
    { "userp",      no_argument,       NULL, 'u' },
    { "scan",       no_argument,       NULL, 'S' },
    { "quiet",      no_argument,       NULL, 'q' },
    { "loaddriver", no_argument,       NULL, 'L' },
    { "loadcmd",    required_argument, NULL, 'c' },
    { "daemon",     no_argument,       NULL, 'D' },
    { 0, 0, 0, 0 }
};

enum vtype {
    TYPE_V4L2_CAPTURE,
    TYPE_V4L1_LOOPBACK
};

// UNIMP
static struct v4l2_capability dummyV4l2_capability;

#define DEVNAMESIZ (sizeof(dummyV4l2_capability.card))
#define DEVPATHSIZ 20

struct deventry {
    char name[DEVNAMESIZ];  // Device name reported by driver
    char dev[DEVPATHSIZ];   // /dev/videoN
    enum vtype type;	    // TYPE_V4L2 capture OR V4L1 Loop input
};

static int nbDevices = 0;
static struct deventry *devices = NULL;
static int nbLoops = 0;
static int nbCaptures = 0;

static int
scanDevices()
{
    int num;
    char dev[DEVPATHSIZ];
    struct video_capability v4l1cap;
    struct v4l2_capability  v4l2cap;

    if (verbose) {
	printf("Scanning devices\n");
	printf("------\n");
    }
    for(num=0;;num++) {
	snprintf(dev, DEVPATHSIZ, "/dev/video%d", num);

	fd = open(dev, O_RDWR|O_NONBLOCK);
	if (fd < 0) {
	    if (errno == ENOENT) break;
	    //fprintf(stderr, "Error while opening '%s': %s (%d)\n", dev, strerror(errno), errno);
	    continue;
	}
	if (ioctl(fd, VIDIOC_QUERYCAP, &v4l2cap) == 0) {
	    // V4L2
	    if (v4l2cap.capabilities & V4L2_CAP_VIDEO_CAPTURE) {
		if (verbose) {
		    struct v4l2_format fmt;
		    fmt.type = V4L2_BUF_TYPE_VIDEO_CAPTURE;
		    ioctl (fd, VIDIOC_G_FMT, &fmt);
		    printf("Found V4L2 Capture device: %s. %s/%s. Current Size: ", dev, v4l2cap.driver, v4l2cap.card);
		    printf(" %dx%d Format: %c%c%c%c\n", fmt.fmt.pix.width, fmt.fmt.pix.height,
						    fmt.fmt.pix.pixelformat & 0xff,
						    (fmt.fmt.pix.pixelformat >> 8) & 0xff,
						    (fmt.fmt.pix.pixelformat >> 16) & 0xff,
						    (fmt.fmt.pix.pixelformat >> 24) & 0xff);
		}
		devices = (struct deventry *)realloc(devices, (nbDevices+1) * sizeof(struct deventry));
		strncpy(devices[nbDevices].dev, dev, DEVPATHSIZ);
		strncpy(devices[nbDevices].name, (char *)&v4l2cap.card, DEVNAMESIZ);
		devices[nbDevices].type = TYPE_V4L2_CAPTURE;
		nbCaptures++;
		nbDevices++;
	    }
	} else
	if (ioctl(fd, VIDIOCGCAP, &v4l1cap) == 0) {
	    // V4L1
	    if (!strncmp(v4l1cap.name, "Video loopback", 14) && v4l1cap.type == 0) {
		if (verbose) {
		    printf("Found V4L Video loopback input: %s\n", dev);
		}
		devices = (struct deventry *)realloc(devices, (nbDevices+1) * sizeof(struct deventry));
		strncpy(devices[nbDevices].dev, dev, DEVPATHSIZ);
		strncpy(devices[nbDevices].name, v4l1cap.name, DEVNAMESIZ);
		devices[nbDevices].type = TYPE_V4L1_LOOPBACK;
		nbLoops++;
		nbDevices++;
	    }
	}
	close(fd);
    }
    if (verbose) {
	printf("------\n");
    }
    
    int ok = 1;
    if (nbCaptures) {
	if (loadDriver) {
	    if (nbLoops) {
		printf("Error: Vloopback module already loaded.\n");
		exit(EXIT_FAILURE);
	    }
	    if (getuid() == 0) {
		char pipes[20];
		sprintf(pipes, "pipes=%d", nbCaptures);

		if (verbose) {
		    printf("Executing: '%s vloopback pipes=%d'\n", loadcmd, nbCaptures);
		}
		execlp(loadcmd, loadcmd, "vloopback", pipes, NULL);
		if (errno == ENOENT) {
		    printf("%s: command not found.\n", loadcmd);
		} else {
		    printf("Failed: %s (%d)\n", strerror(errno), errno);
		}
		exit(EXIT_FAILURE);
	    } else {
		printf("Error: You must be root to perform driver load.\n");
		exit(EXIT_FAILURE);
	    }
	} else {
	    if (nbLoops == 0) {
		printf("No video loopback devices found.\n");
		printf("As root, start video loopback driver with:\n");
		printf("# %s vloopback pipes=%d\n", loadcmd, nbCaptures);
		ok = 0;
	    } else
	    if (nbLoops < nbCaptures) {
		printf("Warning: not enough loopback devices.\n");
		printf("As root, you might try to start video loopback driver with:\n");
		printf("# %s vloopback pipes=%d\n", loadcmd, nbCaptures);
	    }
	}
    } else {
	printf("No V4L2 capture devices found.\n");
	ok = 0;
    }

    return ok;
}

int
main(int argc, char **argv)
{
    int nbChildren = 0;

    for (;;) {
	int index;
	int c;
	
	c = getopt_long (argc, argv, short_options, long_options, &index);

	if (-1 == c)
		break;

	switch (c) {
	case 0: /* getopt_long() flag */
		break;

	case 'd':
		dev_name = optarg;
		break;

	case 'l':
		loop_name = optarg;
		break;

	case 'h':
		usage (stdout, argc, argv);
		exit (EXIT_SUCCESS);

	case 'm':
		io = IO_METHOD_MMAP;
		break;

	case 'r':
		io = IO_METHOD_READ;
		break;

	case 'u':
		io = IO_METHOD_USERPTR;
		break;

	case 's':
		sscanf(optarg, "%dx%d", &width, &height);
		printf("Size set to %d x %d\n", width, height);
		break;

	case 'c':
		loadcmd = optarg;
		break;

	case 'q':
		verbose = 0;
		break;

	case 'D':
		detach = 1;
		break;

	case 'L':
		loadDriver = 1;
	case 'S':
		exit(scanDevices()?EXIT_SUCCESS:EXIT_FAILURE);

	default:
		usage (stderr, argc, argv);
		exit (EXIT_FAILURE);
	}
    }

    if (loop_name == NULL && dev_name == NULL) {
	pid_t pid;

	// Let's start party on our own!
	if (!scanDevices()) {
	    // Damn it, not even enough good stuff to start with
	    printf("Nothing to do, exiting.\n");
	    exit(EXIT_FAILURE);
	}
	// Detach if daemon
	if (detach) {
	    signal(SIGHUP, SIG_IGN);
	    signal(SIGINT, SIG_IGN);
	    signal(SIGQUIT, SIG_IGN);
	}
	// Let's pair up capture/loopback devices
	int curLoop = 0;
	int curCapture = 0;
	int startForwarder;

	while(curCapture < nbDevices) {
	    startForwarder = 0;
	    if (devices[curCapture].type == TYPE_V4L2_CAPTURE) {
		// Let's find a loopback for this one
		while(curLoop < nbDevices) {
		    if (devices[curLoop].type == TYPE_V4L1_LOOPBACK) {
			startForwarder = 1;
			break;
		    }
		    curLoop++;
		}
		if (startForwarder) {
		    loop_name = devices[curLoop].dev;
		    dev_name = devices[curCapture].dev;
		    curLoop++;
		    pid = fork();
		    if (pid == 0) {
			// Child
			printf("Forwarding frames from %s to %s\n", dev_name, loop_name);
			break;
		    } else
		    if (pid == -1) {
			printf("Error: fork failed (%d): %s\n", errno, strerror(errno));
			startForwarder = 0;
		    } else {
			// Parent
			startForwarder = 0;
			nbChildren++;
		    }
		} else {
		    break;  // No more loopback devices
		}
	    }
	    if (startForwarder) {
		// We have forked, proceed
		break;
	    }
	    curCapture++;
	}
	if (!startForwarder) {
	    // Parent, wait for children
	    // or quit if run as daemon
	    if (detach) {
		exit(EXIT_SUCCESS);
	    }
	    while(nbChildren>0) {
		int status;
		pid = wait(&status);
		nbChildren--;
	    }
	    exit(EXIT_SUCCESS);
	}
    }

    if (dev_name == NULL) {
	printf("No input device specified.\n");
	exit(1);
    }
    if (loop_name == NULL) {
	printf("No loop device specified.\n");
	exit(1);
    }

    open_loop();
    open_device();
    init_device();
    start_capturing();
    mainloop();
    stop_capturing();
    uninit_device();
    close_device();

    exit (EXIT_SUCCESS);

    return 0;
}
