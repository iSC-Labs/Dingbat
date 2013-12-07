
Dingbat.Task = DS.Model.extend({

    title: DS.attr('string'),

    isCompleted: DS.attr('boolean'),

    priority: DS.attr('string'),

    tags: DS.attr('string'),

    list: DS.belongsTo('list'),

    parsePriority: function() {
        var title    = this.get('title');
        var priority = this.get('priority');
        var high     = /@high/;
        var normal   = /@normal/;
        var low      = /@low/;

        // default priority
        if (priority === null) {
            priority = 'normal';
        }

        // parse priority
        if (title.search(low) != -1) {
            priority = 'low';
            title = title.replace(low, '');
        }
        if (title.search(normal) != -1) {
            priority = 'normal';
            title = title.replace(normal, '');
        }
        if (title.search(high) != -1) {
            priority = 'high';
            title = title.replace(high, '');
        }

        this.set('title', title.trim());
        this.set('priority', priority);
    }.on('didCreate', 'didUpdate'),

    parseIsCompleted: function(a, b, c) {
        var title  = this.get('title');
        var done   = /@done/;
        var undone = /@undone/;

        // parse status
        if (title.search(done) != -1) {
            title = title.replace(done, '');

            this.set('isCompleted', true);
            this.set('title', title);
        }
        if (title.search(undone) != -1) {
            title = title.replace(undone, '');

            this.set('isCompleted', false);
            this.set('title', title);
        }
    }.on('didUpdate'),

    parseTags: function() {
        var title   = this.get('title');
        var pattern = /#\S+/g;
        var tags    = '';

        if (title.search(pattern) != -1) {

            title.match(pattern).forEach(function(hit) {
                // remove tag from title
                title = title.replace(hit, '');

                var tag = hit.replace('#', '');
                tags   += tag + ', ';
            });

            // trim tags
            tags = tags.substr(0, (tags.length - 2));

            // set tags and title
            this.set('tags', tags);
            this.set('title', title);
        }
    }.on('didCreate', 'didUpdate')

});

Dingbat.Task.FIXTURES = [
    {
        id: 1,
        title: 'kiss a chicken',
        priority: 'high',
        isCompleted: true,
        tags: 'bug, setup, ui',
        list: 1
    },
    {
        id: 2,
        title: 'save whale',
        priority: 'high',
        isCompleted: false,
        tags: 'feature, ui',
        list: 1
    },
    {
        id: 3,
        title: 'do something',
        priority: 'normal',
        isCompleted: false,
        tags: 'bug, setup',
        list: 1
    }
];
