Dingbat.ListController = Ember.ObjectController.extend({

    isEditMode: false,

    actions: {

        delete: function() {
            var model = this.get('model');
            model.deleteRecord();
            model.save();
        },

        disableEditMode: function() {
            this.set('isEditMode', false);
        },

        enableEditMode: function() {
            this.set('isEditMode', true);
        },

        showTasks: function() {
            alert('show');
        },

        update: function() {
            var model = this.get('model');

            if (!this.get('title').trim())
            {
                return;
            }

            model.save();
            this.send('disableEditMode');
        }

    },

    remaining: function () {
        return this.get('tasks').filterBy('isCompleted', false).get('length');
    }.property('@each.isCompleted')


});