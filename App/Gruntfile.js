module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		less: {
		  development: {
			options: {
				compress: false,
				yuicompress: true,
				optimization: 2
			},
			files: [
				{
					expand: true,
					cwd: "less",
					src: ["*.less"],
					dest: "css/src/",
					ext: ".css"
				}
			]
		  }
		},
		cssmin: {
			development: {
				options: {
					banner: '/* Css Mimificado */ \n' + '/* <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */'
				},
				files: {
				'css/style.css': ['css/src/**/*.css']
				}
			}
		},
		jshint: {
		  all: ['Gruntfile.js', 'js/src/**/*.js'],
		  options: {
			globals: {
			  jQuery: true,
			  console: true,
			  module: true,
			  document: true
			}
		  }
		},
		concat: {
			options: {
				stripBanners: true,
				banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */',
			},
			dist: {
				src: ['js/src/**/*.js'],
				dest: 'js/util.js',
			},
		},
		uglify: {
			options: {
				banner: '/*!Js Mimificado */\n' + '/* <%= pkg.name %> - v<%= pkg.version %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */\n',
				mangle: false
			},
			development: {
			  files: {
				'js/util.min.js': ['js/util.js']
			  }
			}
		},
		watch: {
			stylesheets: {
				files: ['less/**/*.less', 'css/dreamtech/**/*.css'],
                tasks: ['less', 'cssmin']
			},
			
			js: {
				files: ['js/dreamtech/**/*.js', 'js/**/*.js'],
				tasks: ['jshint', 'concat', 'uglify']
			}
		}
	  });
	
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['less', 'cssmin', 'jshint', 'concat', 'uglify']);
};