
((function(){
    if (typeof this.RokSprocket == 'undefined') this.RokSprocket = {};
    else Object.merge(this.RokSprocket, {Showcase: null});

    var Showcase = new Class({

        Extends: this.RokSprocket.Features,

        options: {
            curve: 'cubic-bezier(0.37,0.61,0.59,0.87)',
            duration: '400ms',
            data: 'showcase',
            settings: {
                animation: 'crossfade',
                autoplay: false,
                delay: 5
            }
        },

        initialize: function(options){
            this.parent(options);

            Object.merge(this.animations.crossfade, {top: 0, left: 0});
        },

        toPosition: function(container, position){
            container = this.getContainer(container);
            if (!container.retrieve('roksprocket:' + this.data + ':attached')) return;

            this.stopTimer(container);

            var features = container.getElements('[data-' + this.data + '-pagination]'),
                current = container.getElement('[data-' + this.data + '-pagination][class=active]');

            if (!features.length) return;

            if (features[position] && features[position].hasClass('active')) return;

            if (position > features.length - 1) position = 0;
            if (position < 0) position = features.length - 1;

            if (features.length){
                features.removeClass('active');
                features[position].addClass('active');
                features.forEach(function(f, i){
                    f.getParent('#rt-showcase').removeClass('showcase-panel-' + (i + 1));
                });
                features[position].getParent('#rt-showcase').addClass('showcase-panel-' + (position + 1));
            }

            this.animate(container, current.get('data-' + this.data + '-pagination') - 1, position);
        },

        animate: function(container, from, to){
            var panes = container.getElements('[data-' + this.data + '-pane]'),
                settings = this.getSettings(container),
                animation = this.animations[settings.animation] || this.animations.crossfade,
                current = panes[from],
                next = panes[to];

            if (Browser.ie && Browser.version < 8){
                contents.setStyle('zoom', 1);
                images.setStyle('zoom', 1);
            }

            var transition = settings.animation == 'random' ? this.getRandom() : animation,
                initialStyles = {display: 'block', 'z-index': 2, 'position': 'absolute', 'opacity': 0};

            ['top', 'right', 'bottom', 'left'].each(function(dir){
                next.style[dir] = '';
            }, this);

            panes.styles(Object.merge({}, transition.from, {position: 'absolute'}));
            current.styles(Object.merge({}, transition.to, {'z-index': 1, position: 'relative'}));
            next.styles(Object.merge({}, transition.from, initialStyles));

            if (Browser.ie && Browser.version < 9){
                next.set('morph', {
                    link: 'cancel',
                    duration: this.options.duration.toInt(),
                    transition: 'quad:in:out',
                    onComplete: function(){
                        next.styles(Object.merge({}, transition.to, {position: 'relative'}));
                        current.styles(Object.merge({}, transition.from, {position: 'absolute', display: 'none'}));
                        next.get('morph').removeEvents('onComplete');

                        if (settings.autoplay && settings.autoplay.toInt()) this.startTimer(container);
                    }.bind(this)
                }).morph(transition.to);

                current.set('morph', {
                    link: 'cancel',
                    duration: this.options.duration.toInt(),
                    transition: 'quad:in:out'
                }).morph(transition.from);
            } else {
                next.moofx(transition.to, {
                    duration: this.options.duration,
                    equation: this.options.curve,
                    callback: function(){
                        next.styles(Object.merge({}, transition.to, {position: 'relative'}));
                        current.styles(Object.merge({}, transition.from, {position: 'absolute'}));

                        if (settings.autoplay && settings.autoplay.toInt()) this.startTimer(container);
                    }.bind(this)
                });

                current.moofx(transition.from, {
                    duration: this.options.duration,
                    equation: this.options.curve
                });
            }

        }

    });

    this.RokSprocket.Showcase = Showcase;
})());
