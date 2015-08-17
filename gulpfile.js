var gulp 		= require('gulp'),
	penthouse 	= require('penthouse'),
	fs 			= require('fs'),
	p 	= require('gulp-load-plugins')({ camelize: true });

try {
	var v = require('./.vhost.json'),
		vhost 	= v.vHost;
}
catch(e) {
	console.log(e);
	console.log('Did you create .vhost.json ?');
	process.exit(1);
}

gulp.task('scss', function(){
	return gulp.src([
			'pre/scss/**/*.scss'
		])
		.pipe(p.sourcemaps.init())
			.pipe(p.sass({
				includePaths: [
					'pre/scss'
					, 'bower_components/foundation/scss'
					, 'bower_components/compass-mixins/lib'
					, 'bower_components/slick.js/slick'
					, 'bower_components/sweetalert/lib'
					, 'vendor/innovative/core/pre/scss/core_mixins'
					, 'vendor/innovative/core/pre/scss/shared_components'
					, 'vendor/innovative/core/pre/scss/libraries/chosen'
					, 'vendor/innovative/core/pre/scss/libraries/jquery.tagsinput'
					, 'vendor/innovative/core/pre/scss/libraries/jqueryui-timepicker-addon'
					, 'vendor/innovative/core/pre/scss/libraries/redactor'
					, 'vendor/innovative/core/pre/scss/libraries/slick'
				],
				outputStyle: 'compressed',
				errLogToConsole: true
			}))
		.pipe(p.sourcemaps.write('./maps'))
		.pipe(gulp.dest('public/css/'));
});

// Modernizr wil be included inline in the head
gulp.task('move-modernizr', function(){
	return gulp.src('bower_components/modernizr/modernizr.js')
		.pipe(p.rename({
			suffix: '.blade',
			extname: '.php'
		}))
		.pipe(p.uglify())
		.pipe(gulp.dest('resources/views/www/_partials/'))
});

// We attempt to load jQuery from CDN first, and fallback to our hosted jquery
gulp.task('move-jquery', function(){
	return gulp.src('bower_components/jquery/dist/jquery.js')
		.pipe(p.rename({
			suffix: '.min',
		}))
		.pipe(p.uglify())
		.pipe(gulp.dest('public/js/'))
});

gulp.task('js', function(){
	return gulp.src([
			'bower_components/respimage/respimage.min.js'
			, 'bower_components/jquery.lazyload/jquery.lazyload.js'
			, 'bower_components/jquery-placeholder/jquery.placeholder.js'
			, 'bower_components/fastclick/lib/fastclick.js'
			, 'bower_components/jquery.cookie/jquery.cookie.js'
			, 'bower_components/foundation/js/foundation.js'
			, 'bower_components/jquery-easing-original/jquery.easing.1.3.js'
			, 'bower_components/slick.js/slick/slick.min.js'
			, 'bower_components/jquery-ui/jquery-ui.min.js'
			, 'bower_components/jqueryui-timepicker-addon/src/jquery-ui-timepicker-addon.js'
			, 'pre/js/app.js'
		])
		.pipe(p.sourcemaps.init())
			.pipe(p.concat( 'app.js', {newLine: ';'}))
			.pipe(p.rename({ suffix: '.min'}))
			.pipe(p.uglify())
		.pipe(p.sourcemaps.write('./maps'))
		.pipe(gulp.dest('public/js/'));
});

gulp.task('images', function(){
	return gulp.src([
			'pre/images/**/*'
		])
		.pipe(p.newer('public/images/'))
		.pipe(p.imagemin({
			optimizationLevel: 5,
			progressive: true,
			interlaced: true
		}))
		.pipe(gulp.dest('public/images/'));;
});

gulp.task('penthouse', function(){
	penthouse({
		url: vhost,
		css: 'public/css/app.css',
		width: 2560,
		height: 1440
	}, function (err, critical) {
		if (typeof critical != 'undefined') {
			fs.writeFile('resources/views/www/_partials/critical.blade.php', critical);
		} else {
			console.error('Critical CSS Path failed. Did you create a loopback host record for your vhost on your web server?');
		}
	});
});

gulp.task('watch', function(){
	gulp.watch('pre/scss/**/*.scss', ['scss']);
	gulp.watch('pre/js/**/*.js', ['js']);
	gulp.watch('pre/images/**/*.*', ['images']);
	gulp.watch('public/css/app.css', ['penthouse']);
});

gulp.task('run', ['scss','js','images','move-modernizr','move-jquery']);
gulp.task('default', ['watch', 'run']);
