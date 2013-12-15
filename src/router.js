
Dingbat.Router.map(function() {
    this.resource('lists', { path: '/' }, function() {
    });
});

Dingbat.ListsRoute = Ember.Route.extend({
    model: function() {
        return this.store.find('list');
    }
});

Dingbat.ListsIndexRoute = Ember.Route.extend({
    model: function() {
        return this.modelFor('lists');
    }
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