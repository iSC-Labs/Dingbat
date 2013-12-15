module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            options: {
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
            },
            build: {
                src:  'src/**/*.js',
                dest: 'build/<%= pkg.name %>.min.js'
            },
            templates: {
                src:  'build/templates.js',
                dest: 'build/templates.min.js'
            }
        },
        cssmin: {
            minify: {
                src:  'css/*.css',
                dest: 'build/<%= pkg.name %>.min.css'
            }
        },
        concat: {
            options: {
                separator: ';'
            },
            js: {
                src: [
                    'bower_components/jquery/jquery.min.js',
                    'bower_components/semantic-ui/build/packaged/javascript/semantic.min.js',
                    'bower_components/handlebars/handlebars.js',
                    'bower_components/ember/ember.js',
                    'bower_components/ember-data/ember-data.js',
                    'bower_components/ember-localstorage-adapter/localstorage_adapter.js'
                ],
                dest: 'build/vendor.js'
            }
        },
        copy: {
            semantic: {
                files: [{
                    expand: true,
                    src: 'bower_components/semantic-ui/build/packaged/fonts/*',
                    dest: 'build/semantic-ui/fonts/',
                    filter: 'isFile',
                    flatten: true
                }, {
                    expand: true,
                    src: 'bower_components/semantic-ui/build/packaged/css/semantic.min.css',
                    dest: 'build/semantic-ui/css',
                    filter: 'isFile',
                    flatten: true
                }]
            }
        },
        emberTemplates: {
            compile: {
                options: {
                    templateBasePath: /templates\//
                },
                files: {
                    "build/templates.js": 'templates/**/*.hbs'
                }
            }
        },
        clean: {
            build: {
                src: 'build/templates.js'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-ember-templates');
    grunt.loadNpmTasks('grunt-contrib-clean');

    // Default task(s).
    grunt.registerTask('default', ['emberTemplates', 'copy', 'concat', 'uglify', 'cssmin', 'clean']);

};