Dingbat.TasksController = Ember.ArrayController.extend({

    actions: {

        createTask: function () {
            // Get the todo title set by the "New Todo" text field
            var title = this.get('title');
            if (!title.trim()) { return; }

            // Create the new Todo model
            var todo = this.store.createRecord('task', {
                title: title,
                isCompleted: false
            });

            // Clear the "New Todo" text field
            this.set('title', '');

            // Save the new model
            todo.save();
        }

    },

    remaining: function () {
        return this.filterBy('isCompleted', false).get('length');
    }.property('@each.isCompleted')

});