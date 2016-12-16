module.exports = function(grunt) {
	grunt.initConfig({
		jshint: {
			files: ['Gruntfile.js', 'js/scripts.js'],
			options: {
				globals: {
					jQuery: true
				}
			}
		},		
		less: {
			development: {
				options: {
					paths: ['css']
				},
				files: {
					'css/styles.css': 'less/*.less'
				}
			}
		},		
		connect: {
    		server: {
      			options: {
					open: true
      			}
    		}
  		},
		watch: {
			css: {
				files: 'less/*.less',
				tasks: ['less'],
				options: {
					livereload: true,
				},
			},
			html: {
				files: 'index.html',
				options: {
					livereload: true
				},
			},
			js: {
				files: 'js/*.js',
				options: {
					livereload: true
				},
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-connect');
	grunt.registerTask('giver', ['less','connect','watch']);
};