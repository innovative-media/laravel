var gulp 		= require('gulp'),
	config 		= require('./serum'),
	serum 		= require('Serum'),
	runSequence = require('run-sequence'),
	p 			= require('./package.json'),
	plugins 	= require('gulp-load-plugins')({ camelize: true });

gulp.task('scss', function(){
	serum.doScss(config.www.scss.app.src, config.www.scss.app.paths, config.www.scss.app.dest)
});

gulp.task('js', function(){
	serum.doJs(config.libraries.js.legacy.src, config.libraries.js.legacy.name, config.libraries.js.legacy.dest);
	serum.doJs(config.libraries.js.modernizr.src, config.libraries.js.modernizr.name, config.libraries.js.modernizr.dest);
	serum.doJs(config.libraries.js.jquery.src, config.libraries.js.jquery.name, config.libraries.js.jquery.dest);
	serum.doJs(config.libraries.js.jqueryLegacy.src, config.libraries.js.jqueryLegacy.name, config.libraries.js.jqueryLegacy.dest);
	serum.doJs(config.www.js.app.src, config.www.js.app.name, config.www.js.app.dest);
});

gulp.task('images', function(){
	serum.doImages(config.www.images.app.src, config.www.images.app.dest, config.www.images.app.options);
});

gulp.task('watch', function(){
	gulp.watch(config.www.scss.app.src, ['scss']);

	var wwwJs = gulp.watch(config.www.js.app.watchGlob);
		wwwJs.on('change', function(){
			serum.doJs(config.www.js.app.src, config.www.js.app.name, config.www.js.app.dest);
		});

	gulp.watch(config.www.images.app.src, ['images']);

	var wwwPixrem = gulp.watch(config.www.scss.app.dest + '**/*[^-ie8].css');
		wwwPixrem.on('change', function(){
			serum.doPixrem(config.www.scss.app.dest + '**/*[^-ie8].css', config.www.scss.app.dest)
		});
});

gulp.task('run', ['scss','js','images']);
gulp.task('default', ['watch', 'run']);