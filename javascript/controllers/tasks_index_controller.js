Dingbat.TasksIndexController = Ember.ArrayController.extend({

    itemController: 'task',

    setupController: function(controller, model) {
        this.set('model', model);
    },

    high: function() {
        return this
            .filterBy('priority', 'high')
            .filterBy('isCompleted', false)
        ;
    }.property('@each.priority'),

    normal: function() {
        return this
            .filterBy('priority', 'normal')
            .filterBy('isCompleted', false)
        ;
    }.property('@each.priority'),

    low: function() {
        return this
            .filterBy('priority', 'low')
            .filterBy('isCompleted', false)
        ;
    }.property('@each.priority'),

    completed: function() {
        return this.filterBy('isCompleted', true);
    }.property('@each.isCompleted')

});