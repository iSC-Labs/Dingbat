Dingbat.TasksIndexController = Ember.ArrayController.extend({

    itemController: 'task',

    high: function() {
        return this
            .filterBy('priority', 'high')
            .filterBy('isCompleted', false)
        ;
    }.property('@each.priority', '@each.isCompleted'),

    normal: function() {
        return this
            .filterBy('priority', 'normal')
            .filterBy('isCompleted', false)
        ;
    }.property('@each.priority', '@each.isCompleted'),

    low: function() {
        return this
            .filterBy('priority', 'low')
            .filterBy('isCompleted', false)
        ;
    }.property('@each.priority', '@each.isCompleted'),

    completed: function() {
        return this.filterBy('isCompleted', true);
    }.property('@each.isCompleted'),


    actions: {

        createTask: function () {
            var title = this.get('title');

            // title is required
            if (!title.trim()) {
                return;
            }

            // create task
            var task = this.store.createRecord('task', {
                title: title,
                isCompleted: false
            });

            // clear the text field
            this.set('title', '');

            // save the new model
            task.save();
        }

    }

});