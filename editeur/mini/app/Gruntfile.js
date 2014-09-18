'use strict';

module.exports = function(grunt) {

  // Load grunt tasks automatically
  require('load-grunt-tasks')(grunt);

  // Define the configuration for all the tasks
  grunt.initConfig({

    bower: {
      install: {
        options: {
          targetDir: 'libs',
          cleanBowerDir: true
        }
      }
    },

    less: {
      development: {
        options: {
          compress: true
        },
        files: {
          'styles.css': 'styles.less'
        }
      }
    },

    watch: {
      styles: {
        files: ['**/*.less'],
        tasks: ['less'],
        options: {
          livereload: {
            port: 9001
          }
        }
      }
    },

    connect: {
      server: {
        options: {
          port: 1337,
          hostname: 'localhost',
          livereload: 9001,
          open: true,
          middleware: function(connect, options) {
            var proxy = require('grunt-connect-proxy/lib/utils').proxyRequest;
            return [
              function(req, res, next) {
                res.setHeader('Access-Control-Allow-Origin', '*');
                res.setHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
                res.setHeader('Access-Control-Allow-Headers', 'Content-Type');
                return next();
              },
              connect.static(options.base),
              connect.directory(options.base),
              proxy
            ];
          }
        },
        proxies: [{
          context: '/riskinsight/',
          host: 'birdsdessines.fr',
          port: 80,
          changeOrigin: true
        }]
      }
    }

  });

  grunt.registerTask('default', function() {
    grunt.task.run([

    ]);
  });

  grunt.registerTask('build', function() {
    grunt.task.run([
      'bower:install',
      'less'
    ]);
  });

  grunt.registerTask('serve', function() {
    grunt.task.run([
      'bower:install',
      'less',
      'configureProxies:server',
      'connect:server',
      'watch'
    ]);
  });

};
