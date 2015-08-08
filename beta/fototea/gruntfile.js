module.exports = function(grunt) {

    //Initializing the configuration object
    grunt.initConfig({
        less: {
            development: {
                options: {
                    compress: false,  //minifying the result
                    sourceMap: true,
                    sourceMapFilename: "dist/css/style.css.map",
                    sourceMapBasepath: "dist/css/"
                },
                files: {
                    //compiling frontend.less into frontend.css
                    "./dist/css/style.css":"./less/style.less"
                }
            }
        },
        watch: {
            less: {
                files: ['./less/*.less'],  //watched files
                tasks: ['less'],                          //tasks to run
                //tasks: ['less', 'concat:css','cssmin'],                          //tasks to run
                options: {
                    livereload: true                        //reloads the browser
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Task definition
    grunt.registerTask('default', ['watch']);

};