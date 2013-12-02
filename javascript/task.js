
Dingbat.Task = DS.Model.extend({

    title: DS.attr('string'),

    isCompleted: DS.attr('boolean'),

    priority: DS.attr('string'),

    init: function() {
        this._super();

        //this.on('didCreate', this, function() { this.parsePriority(); });
        //this.on('didUpdate', this, function() { this.parsePriority(); });
    },

    parsePriority: function() {
        var title    = this.get('title');
        var priority = this.get('priority');

        if (priority === null) {
            priority = 'normal';
        }

        if (title.search(/@high/) != -1) {
            priority = 'high';
            title = title.replace(/@high/, '');
        }
        else if (title.search(/@normal/) != -1) {
            priority = 'normal';
            title = title.replace(/@normal/, '');
        }
        else if (title.search(/@low/) != -1) {
            priority = 'low';
            title = title.replace(/@low/, '');
        }

        this.set('title', title.trim());
        this.set('priority', priority);
    }.on('didCreate', 'didUpdate'),

    parseIsCompleted: function() {
        var title = this.get('title');

        if (title.search(/@done/) != -1) {
            title = title.replace(/@done/, '');

            this.set('isCompleted', true);
            this.set('title', title);
        }
    }.on('didUpdate')

});

Dingbat.Task.FIXTURES = [
    {
        id: 1,
        title: 'kiss a chicken',
        priority: 'high',
        isCompleted: true
    },
    {
        id: 2,
        title: 'save whale',
        priority: 'high',
        isCompleted: false
    },
    {
        id: 3,
        title: 'do something',
        priority: 'normal',
        isCompleted: false
    }
];