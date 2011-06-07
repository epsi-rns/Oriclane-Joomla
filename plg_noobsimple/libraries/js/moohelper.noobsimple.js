function mooNoobSimpleHelper(size, items, path, box) {
	path = (typeof path)=='undefined'? '' : path;
	noob_simple_box = document.id(box);
	
	items.each(function(item, index){
    	var span = new Element('span');
    	span.inject(noob_simple_box);
    	var	img = new Element('img', 
			{ 'src' : path+item, 'alt' : 'Photo'});
		img.inject(span);	
	});				
		
	var items2 = [];
	var count = Math.floor(items.length-2);
	for ( i=0; i < count; i++ )	items2[i] = i;
		
	new noobSlide({
		box: noob_simple_box,
		items: items2,
		size: size,
		autoPlay: true,
		interval: 5000,	// do not waste browser CPU !!!
		fxOptions: {
			duration: 1000,
			transition: Fx.Transitions.Bounce.easeOut,
			wait: false
		}			
	});
	
	// hack for fix
	noob_simple_box.setStyle('width',size*items.length+'px');
}		
