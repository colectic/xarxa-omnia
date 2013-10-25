function video(tipo, video, width, height) {
    	var objectvideo;
  	tipo = typeof(tipo) != 'undefined' ? tipo : 'imatge';
  	width = typeof(width) != 'undefined' ? width : 400;
  	height = typeof(height) != 'undefined' ? height : 300;
	switch(tipo)
	{
		case 'blip':
			objectvideo= "<div style='text-align:center;'><!--[if !IE]>--><object data='http://blip.tv/play/"+video+"' height='"+height+"' type='application/x-shockwave-flash' width='"+width+"'><!--<![endif]--><!--[if IE]>    <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='"+width+"' height='"+height+"' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'><param name='movie' value='http://blip.tv/play/"+video+"' /><!--><!--dgx--><param name='quality' value='high' /><param name='bgcolor' value='#FFFFFF' /> <param name='wmode' value='opaque' /><param name='allowfullscreen' value='true' />	<p><a href='http://blip.tv/play/"+video+"' lang='ca' title='vídeo'>Clica aqu&iacute; per veure el v&iacute;deo</a></p></object><![endif]--></div>";
		break;
		case 'youtube':
		    objectvideo= "<!--[if !IE]> --><object type='application/x-shockwave-flash' data='http://www.youtube.com/v/"+video+"' width='"+width+"' height='"+height+"'><!-- <![endif]--><!--[if IE]><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='"+width+"' height='"+height+"' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'><param name='movie' value='http://www.youtube.com/v/"+video+"' /><!--><!--dgx--><param name='quality' value='high' /><param name='bgcolor' value='#FFFFFF' /><param name='wmode' value='opaque' /><param name='allowfullscreen' value='true' /><p><a href='http://www.youtube.com/v/"+video+"' title='vídeo' lang='ca'>Clica aquí per veure el vídeo</a></p></object><!-- <![endif]-->";
		break;
		case 'slideshare':
		    objectvideo= "<!--[if !IE]> --><object type='application/x-shockwave-flash' data='"+video+"' width='"+width+"' height='"+height+"'><!-- <![endif]--><!--[if IE]><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='"+width+"' height='"+height+"' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'><param name='movie' value='"+video+"' /><!--><!--dgx--><param name='quality' value='high' /><param name='bgcolor' value='#FFFFFF' /><param name='wmode' value='opaque' /><param name='allowfullscreen' value='true' /></object><!-- <![endif]-->";
		break;
		case 'slideshare-v2':
		    objectvideo= "<iframe src='http://www.slideshare.net/slideshow/embed_code/"+video+"' width='"+width+"' height='"+height+"' frameborder='0' marginwidth='0' marginheight='0' scrolling='no' style='border:1px solid #CCC;border-width:1px 1px 0;margin-bottom:5px' allowfullscreen webkitallowfullscreen mozallowfullscreen> </iframe>";
		break;
		case 'imatge':
		    objectvideo= "<a href='"+video+"' lang='ca' title='vídeo'><img src='/sites/xarxa-omnia.org/themes/acquia_slate/images/video.png' alt='video' class='video-imatge' /></a>";
		break;
		case 'issuu':
		    objectvideo= "<object type='application/x-shockwave-flash' data='http://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf?mode=mini&amp;backgroundColor=%23222222&amp;documentId="+video+"' width='"+width+"' height='"+height+"'><!-- <![endif]--><!--[if IE]><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='"+width+"' height='"+height+"' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'><param name='movie' value='http://static.issuu.com/webembed/viewers/style1/v2/IssuuReader.swf?mode=mini&amp;backgroundColor=%23222222&amp;documentId="+video+"' /><!--><!--dgx--><param name='quality' value='high' /><param name='menu' value='false'/><param name='bgcolor' value='#FFFFFF' /><param name='wmode' value='transparent' /><param name='allowfullscreen' value='true' /></object><!-- <![endif]-->";
		break;
		case 'picasa2':
		  video=encodeURIComponent(video);
		  video=video.replace("base", "api");
		  objectvideo= "<div style='text-align:center;'><object type='application/x-shockwave-flash' data='http://picasaweb.google.com/s/c/bin/slideshow.swf' width='"+width+"' height='"+height+"'><param name='movie' value='http://picasaweb.google.com/s/c/bin/slideshow.swf' />  <param name='flashvars' value='host=picasaweb.google.com&amp;hl=ca&amp;feat=flashalbum&amp;RGB=0x000000&amp;feed="+video+"' /><param name='pluginspage' value='http://www.macromedia.com/go/getflashplayer' /><param name='pluginurl' value='http://www.adobe.com/go/getflashplayer' /><!--[if !IE]> <--><object data='http://picasaweb.google.com/s/c/bin/slideshow.swf' width='"+width+"' height='"+height+"' type='application/x-shockwave-flash'><param name='movie' value='http://picasaweb.google.com/s/c/bin/slideshow.swf' /><param name='flashvars' value='host=picasaweb.google.com&amp;hl=ca&amp;feat=flashalbum&amp;RGB=0x000000&amp;feed="+video+"' /><param name='pluginspage' value='http://www.macromedia.com/go/getflashplayer' /><param name='pluginurl' value='http://www.adobe.com/go/getflashplayer' /><p><a href='"+video+"' lang='ca' title='vídeo'>Clica aqu&iacute; per veure el v&iacute;deo</a></p></object><!--> <![endif]--></div>";
		break;
		case 'picasa':
		  video=encodeURIComponent(video);
		  video=video.replace("base", "api");
		  objectvideo= "<embed type='application/x-shockwave-flash' src='https://static.googleusercontent.com/external_content/picasaweb.googleusercontent.com/slideshow.swf' width='"+width+"' height='"+height+"' flashvars='host=picasaweb.google.com&hl=ca&feat=flashalbum&RGB=0x000000&feed="+video+"' pluginspage='http://www.macromedia.com/go/getflashplayer'></embed>";
		break;
		default:
		  objectvideo= "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0' width='"+width+"' height='"+height+"'><param name='movie' value='http://blip.tv/play/"+video+"' /><param name='quality' value='high' /><param name='bgcolor' value='#FFFFFF' /><param name='wmode' value='transparent' /><!--[if !IE]> <--><object data='http://blip.tv/play/"+video+"' width='"+width+"' height='"+height+"' type='application/x-shockwave-flash'><param name='quality' value='high' /><param name='bgcolor' value='#FFFFFF' /><param name='pluginurl' value='http://www.adobe.com/go/getflashplayer' /><p><a href='http://blip.tv/play/"+video+"' lang='ca' title='vídeo'>Clica aqu&iacute; per veure el v&iacute;deo</a></p></object><!--> <![endif]-->";
	}
    document.write(objectvideo);
};
