
Dingbat.List = DS.Model.extend({

    title: DS.attr('string'),

    tasks: DS.hasMany('task', { async: true })

});

Dingbat.List.FIXTURES = [
    {
        id: 1,
        title: 'Project A',
        tasks: [1, 2, 3]
    },
    {
        id: 2,
        title: 'Project B',
        tasks: []
    },
    {
        id: 3,
        title: 'Project C',
        tasks: []
    }
];
