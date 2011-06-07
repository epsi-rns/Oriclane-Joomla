window.addEvent('domready', function() {
	if (!Browser.Engine.trident4) {	
		var scroll = new Fx.Scroll('lens-container', {
			offset:{'x':0, 'y':0}, 
			transition: Fx.Transitions.Elastic.easeOut
		});
			
		$$('.lens-icon img').each(function(item){ 
			item.addEvent('mouseover', function(event) {
				var fx2 = new Fx.Morph(item, {duration: 200, transition: Fx.Transitions.linear});
				//var fx2 = item.effects({duration: 200, transition: Fx.Transitions.linear});
				fx2.start({
					'width': 90,
					'height':90,
					'margin-top': '-2',
					'margin-left': '-5'
				});
			});
			item.addEvent('mouseleave', function(event) {
				var fx2 = new Fx.Morph(item, {duration: 200, transition: Fx.Transitions.linear});
				//var fx2 = item.effects({duration: 200, transition: Fx.Transitions.linear});
				fx2.start({
					'width': 50,
					'height':50,
					'margin-top': '0',
					'margin-left': '0'
				});
			});
		});		
		
		scroll.toLeft();	
	}	
});
