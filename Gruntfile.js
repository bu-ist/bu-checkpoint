module.exports = function( grunt ) {
	'use strict';
	// Require external packages.
	const autoprefixer = require( 'autoprefixer' );
	const sass = require( 'node-sass' );

	// Project configuration
	grunt.initConfig( {

		pkg: grunt.file.readJSON( 'package.json' ),

		addtextdomain: {
			options: {
				textdomain: 'bu-checkpoint',
			},
			update_all_domains: {
				options: {
					updateDomains: true,
				},
				src: [ '*.php', '**/*.php', '!\.git/**/*', '!bin/**/*', '!node_modules/**/*', '!tests/**/*' ],
			},
		},
		watch: {
			grunt: {
				files: [ 'Gruntfile.js' ],
				options: {
					reload: true,
				},
			},
			scripts: {
				files: [
					'js-dev/**/*.js',
				],
				tasks: [ 'scripts' ],
				options: {
					spawn: false,
				},
			},
			styles: {
				files: [
					'node_modules/responsive-foundation/css-dev/**/*.scss',
					'css-dev/**/*.scss',
				],
				tasks: [ 'styles' ],
				options: {
					spawn: false,
				},
			},
		},
		browserify: {
			options: {
				watch: true,
				browserifyOptions: {
					debug: false,
					transform: [ [ 'babelify', { presets: [ '@babel/env', '@babel/react' ], plugins: [ '@babel/plugin-proposal-class-properties' ] } ] ],
				},
			},
			dist: {
				files: [
					{
						expand: true, // Enable dynamic expansion.
						cwd: 'js-dev/', // Src matches are relative to this path.
						src: [ '*.js' ], // Actual pattern(s) to match. Targets root JS files.
						dest: 'js/', // Destination path prefix.
					},
				],
			},
		},
		uglify: {
			scripts: {
				options: {
					sourceMap: true,
				},
				expand: true,
				cwd: 'js/',
				src: [ '*.js' ],
				dest: 'js/',
			},
			vendor: {
				options: {
					sourceMap: true,
				},
				expand: true,
				cwd: 'js/vendor',
				src: [ '*.js', '!*.min.js' ],
				dest: 'js/vendor',
			},
		},
		sass: {
			options: {
				outputStyle: 'compressed',
				implementation: sass,
				sourceMap: true,
				indentType: 'space',
				indentWidth: 2,
				precision: '5',
				includePaths: [
					'node_modules/normalize-scss/sass',
					'node_modules/mathsass/dist/',
				],
				bundleExec: true,
			},
			devl: {
				options: {
					outputStyle: 'expanded',
				},
				files: {
					'style.css': 'css-dev/style.scss',
					'ie.css': 'css-dev/ie.scss',
				},
			},
			prod: {
				files: {
					'style.min.css': 'css-dev/style.scss',
					'ie.min.css': 'css-dev/ie.scss',
				},
			},
		},
		postcss: {
			defaults: {
				options: {
					map: {
						inline: false, // Save all sourcemaps as separate files.
					},
					processors: [
						autoprefixer, // add vendor prefixes.
					],
				},
				src: [ 'style.css', 'style.min.css' ],
			},
		},

		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt',
				},
			},
		},

		makepot: {
			target: {
				options: {
					domainPath: '/languages',
					exclude: [ '\.git/*', 'bin/*', 'node_modules/*', 'tests/*' ],
					mainFile: 'bu-checkpoint.php',
					potFilename: 'bu-checkpoint.pot',
					potHeaders: {
						poedit: true,
						'x-poedit-keywordslist': true,
					},
					type: 'wp-plugin',
					updateTimestamp: true,
				},
			},
		},
		clean: {
			languages: [ 'languages/*' ],
			js: [ 'js/**/*.js', 'js/**/*.map' ],
		},
		sasslint: {
			target: 'css-dev/**/*.scss',
			// see .sasslintrc for options.
		},
	} );

	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );
	grunt.loadNpmTasks( 'grunt-browserify' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-postcss' );
	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-notify' );
	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-sass-lint' );

	grunt.util.linefeed = '\n';

	grunt.registerTask( 'i18n', [ 'addtextdomain', 'makepot' ] );
	grunt.registerTask( 'readme', [ 'wp_readme_to_markdown' ] );
	grunt.registerTask( 'styles', [ 'sass', 'postcss' ] );
	grunt.registerTask( 'scripts', [
		'clean:js',
		'browserify',
		'uglify',
	] );
	grunt.registerTask( 'build', [ 'styles', 'scripts', 'i18n' ] );
	grunt.registerTask( 'default', [ 'watch' ] );
};
