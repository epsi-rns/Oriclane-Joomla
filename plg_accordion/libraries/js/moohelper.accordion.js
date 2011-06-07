// http://davidwalsh.name/simple-mootools-accordion
window.addEvent('domready', function() {
	var togglers	= $$('.acdn_toggler');
	var elements	= $$('.acdn_element');
	if (togglers.length!=0 && elements.length!=0)
		var accordion = new Fx.Accordion(togglers, elements, {
			opacity: 0,
			onActive: function(toggler) { 
				toggler.removeClass('section'); 
				toggler.addClass('activesection'); 
			},
			onBackground: function(toggler) { 
				toggler.removeClass('activesection'); 
				toggler.addClass('section'); 
			}
		});		
});	
