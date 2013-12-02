Dingbat.EditTaskView = Ember.TextField.extend({

    didInsertElement: function () {
        this.$().focus();
    }

});

Ember.Handlebars.helper('edit-task', Dingbat.EditTaskView);