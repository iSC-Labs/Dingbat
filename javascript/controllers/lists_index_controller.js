Dingbat.ListsIndexController = Ember.ArrayController.extend({

    isCreateMode: false,

    itemController: 'list',

    actions: {

        createList: function () {
            var title = this.get('title');

            // title is required
            if (!title.trim()) {
                return;
            }

            // create list
            var model = this.store.createRecord('list', {
                title: title
            });

            // clear the text field
            this.set('title', '');

            // save the new model
            model.save();

            // disable create mode
            this.send('disableCreateMode');
        },

        disableCreateMode: function() {
            this.set('isCreateMode', false);
        },

        enableCreateMode: function() {
            this.set('isCreateMode', true);
        }

    }

});