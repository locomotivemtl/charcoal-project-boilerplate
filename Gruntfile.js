/**
* @file Charcoal Task Runner for Grunt
*/

module.exports = function(grunt) {
    'use strict';

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        'yaml-validate': {
            options: {
                glob: '.travis.yml'
            }
        },

        copy: {
            // Assets from charcoal-admin module
            admin: {
                expand: true,
                cwd: 'vendor/locomotivemtl/charcoal-admin/assets/dist/',
                src: ['**', '*'],
                dest: 'www/assets/admin/'
            }
        },

        jsonlint: {
            meta: {
                src: ['*.json']
            },
            config: {
                src: ['config/**/*.json']
            },
            metadata: {
                src: ['metadata/**/*.json']
            }
        },

        phplint: {
            options: {
                swapPath: '/tmp',
                phpArgs : {
                    // add -f for fatal errors
                    '-lf': null
                }
            },
            src: [
                'src/**/*.php'
            ],
            tests: [
                'tests/**/*.php'
            ]
        },

        phpunit: {
            src: {
                dir: 'tests/'
            },
            options: {
                colors: true,
                coverageHtml: 'tests/tmp/report/',
                //coverageText: 'tests/tmp/report/',
                testdoxHtml: 'tests/tmp/testdox.html',
                testdoxText: 'tests/tmp/testdox.text',
                verbose: true,
                debug: false,
                bootstrap: 'tests/bootstrap.php'
            }
        },

        phpcs: {
            src: {
                src: ['src/**/*.php']
            },
            tests: {
                src: ['tests/**/*.php']
            },
            options: {
                standard: 'phpcs.xml',
                extensions: 'php',
                showSniffCodes: true
            }
        },

        phpcbf: {
            src: {
                src: ['src/**/*.php']
            },
            tests: {
                src: ['tests/**/*.php']
            },
            options: {
                standard: 'phpcs.xml',
                noPatch: true
            }
        },

        phpdocumentor: {
            dist: {
                options: {
                    config: 'phpdoc.dist.xml',
                    directory : ['src/', 'tests/'],
                    target : 'phpdoc/'
                }
            }
        },

        watch: {
            admin: {
                files: [
                    'vendor/locomotivemtl/charcoal-admin/assets/dist/**'
                ],
                tasks: ['copy']
            },
            php: {
                files: [
                    'src/**/*.php',
                    'tests/**/*.php',
                ],
                tasks: ['phplint', 'phpcs', 'phpunit']
            },
            json: {
                files: [
                    '*.json',
                    'metadata/**/*.json'
                ],
                tasks: ['jsonlint']
            }
        },

        githooks: {
            all: {
                'pre-commit': 'jsonlint phplint phpunit phpcs',
            }
        }

    });

    // Load tasks
    require('load-grunt-tasks')(grunt);

    grunt.registerTask('default', [
        'phpunit',
        // 'phplint' /** To slow for 'default' task */
    ]);

    grunt.registerTask('tests', [
        'phplint',
        'phpunit'
    ]);

    grunt.registerTask('build', [
        'copy'
    ]);

};
