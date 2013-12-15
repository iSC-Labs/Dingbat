Dingbat.TaskController = Ember.ObjectController.extend({

    isEditing: false,

    actions: {

        editTask: function() {
            // add tags and priorities to title
            var title       = this.get('title');

            // prepare tags
            var tags       = this.get('tags');
            var hashedTags = '';

            if (tags == null) {
                tags = '';
            }

            tags.split(',').forEach(function(tag) {
                hashedTags += '#' + tag.trim() + ' ';
            });
            var tags = hashedTags.trim();

            if (tags.length != 0) {
                tags = ' ' + tags;
            }

            this.set('title', title + tags);
            this.set('isEditing', true);
        },

        acceptChanges: function () {
            this.set('isEditing', false);

            if (Ember.isEmpty(this.get('model.title'))) {
                this.send('removeTodo');
            } else {
                this.get('model').save();
            }
        },

        removeTodo: function () {
            var todo = this.get('model');
            todo.deleteRecord();
            todo.save();
        },

        markAsCompleted: function() {
            this.get('model').set('isCompleted', true);
            this.send('acceptChanges');
        }

    },


    isCompleted: function(key, value){
        var model = this.get('model');

        if (value === undefined) {
            // property being used as a getter
            return model.get('isCompleted');
        } else {
            // property being used as a setter
            model.set('isCompleted', value);
            model.save();
            return value;
        }
    }.property('model.isCompleted')

});