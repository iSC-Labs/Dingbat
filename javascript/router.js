
Dingbat.Router.map(function() {
    this.resource('tasks', { path: '/' }, function() {
    });
});

Dingbat.TasksRoute = Ember.Route.extend({
    model: function() {
        return this.store.find('task');
    }
});


Dingbat.TasksIndexRoute = Ember.Route.extend({

    model: function () {
        return this.modelFor('tasks');
    }

});