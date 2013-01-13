window.addEvent('domready', function() {
    var prev_el = document.id('article_prev');
    var next_el = document.id('box_next');

    if (prev_el!=null) {
        var prev_fx = new Fx.Morph(prev_el, {duration:700, link:'cancel'});

        prev_el.addEvent('mouseenter',function() {
            prev_fx.start({ 'margin-left': 0 });
        });

        prev_el.addEvent('mouseleave',function() {
            prev_fx.start({ 'margin-left': -183 });
        });
    }

    if (next_el!=null) {
        var next_fx = new Fx.Morph(next_el, {duration:700, link:'cancel'});

        next_el.addEvent('mouseenter',function() {
            next_fx.start({ 'width': 200 });
        });

        next_el.addEvent('mouseleave',function() {
            next_fx.start({ 'width': 20 });
        });
    }
});
