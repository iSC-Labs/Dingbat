Dingbat.CreateListInputView = Ember.TextField.extend({

    didInsertElement: function () {
        this.$().focus();
    }

});

Ember.Handlebars.helper('create-list-input', Dingbat.CreateListInputView);