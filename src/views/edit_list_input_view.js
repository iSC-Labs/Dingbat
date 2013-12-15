Dingbat.EditListInputView = Ember.TextField.extend({

    didInsertElement: function () {
        this.$().focus();
    }

});

Ember.Handlebars.helper('edit-list-input', Dingbat.EditListInputView);