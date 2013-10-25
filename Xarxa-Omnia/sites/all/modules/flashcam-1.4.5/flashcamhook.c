///////////////////////////////////////////////////////////
// Copyright 2008 - Flashcam project (Olivier Debon)
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
//
// AUTHOR(S):
//            Olivier Debon olivier@debon.net
//
///////////////////////////////////////////////////////////
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/syscall.h>
#include <sys/ioctl.h>
#include <linux/videodev.h>
#include <errno.h>

#define OPEN(p,f) syscall(SYS_open, p, f)

static int vidmap = 0;
static int nbVideoDevices = 0;
static char **videoDevices = NULL;

static void
scanVloopDevices()
{
    int dev,num;
    char device[20];
    struct video_capability cap;

    printf("Scanning Vloopback devices\n");
    for(num=0;;num++) {
	sprintf(device, "/dev/video%d", num);

	dev = OPEN(device, 04002); // O_RDWR|O_NONBLOCK, this is meant to be hardcoded
	if (dev < 0)  {
	    if (errno == ENOENT) break;
	    continue;
	}
	if (ioctl(dev, VIDIOCGCAP, &cap) == 0) {
	    // Apparently V4L1 device, is it a Vloopback entry?
	    if (cap.type == VID_TYPE_CAPTURE
	     && !strncmp(cap.name, "Video loopback", 14)) {
		// Yes
		printf("Mapping /dev/video%d -> %s\n", nbVideoDevices, device);
		videoDevices = (char **)realloc(videoDevices, (nbVideoDevices+1)*sizeof(char *));
		videoDevices[nbVideoDevices] = strdup(device);
		nbVideoDevices++;
	    }
	}
	close(dev);
    }
}

static int
readConfig()
{
    FILE *map;
    char *home, *mappath;
    char devicedef[20];

#define FLASHCAMRC "/.flashcamrc"

    home = getenv("HOME");
    mappath = (char*)alloca(strlen(home)+strlen(FLASHCAMRC)+1);
    strcpy(mappath, home);
    strcat(mappath, FLASHCAMRC);

    printf("Reading device map from '%s'\n", mappath);
    map = fopen(mappath, "r");
    while(map) {
	if (fgets(devicedef, sizeof(devicedef), map) == NULL) break;
	if (devicedef[0] == '/') {
	    devicedef[strlen(devicedef) - 1] = 0;	// Remove trailing '\n'
	    printf("Mapping /dev/video%d -> %s\n", nbVideoDevices, devicedef);
	    videoDevices = (char **)realloc(videoDevices, (nbVideoDevices+1)*sizeof(char *));
	    videoDevices[nbVideoDevices] = strdup(devicedef);
	    nbVideoDevices++;
	}
    }
    if (map) {
	fclose(map);
    } else {
	printf("Warning: no flash video devices map file found.\n");
	return 0;
    }
    return 1;
}

int
open(const char *path, int flags)
{
    int n;
    char device[20];

    if (!strncmp(path, "/dev/video", 10)) {
	// Get devices mapping
	if (vidmap == 0) {
	    if (!readConfig()) {
		// No config file, let's detect Vloopback devices
		scanVloopDevices();
	    }
	    vidmap = 1;
	}
	for(n=0; n < nbVideoDevices; n++) {
	    sprintf(device, "/dev/video%d", n);
	    if (!strcmp(path, device)) {
		// Found the mapping, redirect the open operation
		return OPEN(videoDevices[n], flags);
	    }
	}
	// If not mapped, open should fail with proper errno value
	errno = ENOENT;
	return -1;
    }
    return OPEN(path, flags);
}
