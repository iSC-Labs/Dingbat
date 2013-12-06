Dingbat.TasksController = Ember.ArrayController.extend({

    glog: 'asdas',

    remaining: function () {
        return this.filterBy('isCompleted', false).get('length');
    }.property('@each.isCompleted')

});