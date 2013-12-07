
window.Dingbat = Ember.Application.create({
    LOG_TRANSITIONS: true,
    LOG_BINDINGS: true,
    LOG_VIEW_LOOKUPS: true,
    LOG_STACKTRACE_ON_DEPRECATION: true,
    LOG_VERSION: true,
    debugMode: true
});

Dingbat.ApplicationAdapter = DS.FixtureAdapter.extend();

/*
Dingbat.ApplicationAdapter = DS.LSAdapter.extend({
    namespace: 'dingbat-emberjs'
});
*/

