
Dingbat.Task = DS.Model.extend({
    title: DS.attr('string'),
    isCompleted: DS.attr('boolean'),
    priority: DS.attr('string')
});

Dingbat.Task.FIXTURES = [
    {
        id: 1,
        title: 'kiss a chicken',
        priority: 'high',
        isCompleted: true
    },
    {
        id: 2,
        title: 'save whale',
        priority: 'high',
        isCompleted: false
    },
    {
        id: 3,
        title: 'do something',
        priority: 'normal',
        isCompleted: false
    }
];