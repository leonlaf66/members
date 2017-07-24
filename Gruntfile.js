// http://www.cnblogs.com/wymbk/p/5766064.html
module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      output: {
        options: {
          style: 'expanded'
        },
        files: {
          './web/css/style.css': 'resources/sass/style.scss'
        }
      }
    },
    copy: {
      main: {
        expand: true,
        cwd: 'resources/js/',
        src: ['**'],
        dest: 'web/js/',
      },
    },
    jshint: {
      all: ['resources/js/*']
    },
    watch: {
      sass: {
        files: [
          './resources/sass/**/*.scss',
          './resources/sass/**/**/*.scss',
          './resources/sass/**/**/**/*.scss'
        ],
        tasks: ['sass']
      },
      js: {
        files: [
          'resources/js/*.js',
          'resources/js/**/*.js',
          'resources/js/**/**/*.js',
        ],
        tasks: ['jshint', 'copy']
      }
    },
  });

  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['sass', 'jshint', 'copy', 'watch']);
};