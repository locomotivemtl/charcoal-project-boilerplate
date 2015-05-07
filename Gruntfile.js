/**
* Gruntfile.js
* Charcoal-Core configuration for grunt. (The JavaScript Task Runner)
*/

module.exports = function(grunt) {
	"use strict";

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		"yaml-validate": {
			options: {
				glob: ".travis.yml"
			}
		},

		jsonlint:{
			meta:{
				src:['*.json']
			},
			config:{
				src:['config/**/*.json']
			},
			metadata:{
				src:['metadata/**/*.json']
			}
		},

		phplint:{
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

		phpunit:{

			src: {
				dir: 'tests/'
			},

			options: {
				colors: true,
				coverageHtml:'tests/tmp/report/',
				//coverageText:'tests/tmp/report/',
				testdoxHtml:'tests/tmp/testdox.html',
				testdoxText:'tests/tmp/testdox.text',
				verbose:true,
				debug:false,
				bootstrap:'tests/bootstrap.php'
			}
		},

		phpcs: {
			src:{
				src:['src/**/*.php']
			},
			tests: {
				src:['tests/**/*.php']
			},
			options: {
				standard: 'phpcs.xml',
				extensions: 'php',
				showSniffCodes: true
			}
		},

		phpcbf: {
			src:{
				src:['src/**/*.php']
			},
			tests: {
				src:['tests/**/*.php']
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
			php: {
				files: [
					'src/**/*.php',
					'tests/**/*.php',
				],
				tasks: ['phplint']
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

	// Load plugin(s)
	grunt.loadNpmTasks('grunt-yaml-validate');
	grunt.loadNpmTasks('grunt-jsonlint');
	grunt.loadNpmTasks("grunt-phplint");
	grunt.loadNpmTasks('grunt-phpunit');
	grunt.loadNpmTasks('grunt-phpcs');
	grunt.loadNpmTasks('grunt-phpcbf');
	grunt.loadNpmTasks('grunt-phpdocumentor');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-githooks');
	grunt.loadNpmTasks('grunt-composer');	

	// Register Task(s)
	grunt.registerTask('default', [
		'phpunit',
		//'phplint' // To slow for default
	]);
	grunt.registerTask('tests', [
		'phpunit',
		'phplint'
	]);
	
};
