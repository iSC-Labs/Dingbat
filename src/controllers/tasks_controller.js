Dingbat.TasksController = Ember.ArrayController.extend({

    remaining: function () {
        return this.filterBy('isCompleted', false).get('length');
    }.property('@each.isCompleted')

});