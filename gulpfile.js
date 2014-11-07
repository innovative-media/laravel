var gulp 		= require('gulp'),
	p 			= require('./package.json'),
	config 		= require('./serum'),
	serum 		= require('Serum'),
	jeditor 	= require('gulp-json-editor'),
	runSequence = require('run-sequence').use(gulp);
var plugins 	= require('gulp-load-plugins')();

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

	var wwwPixrem = gulp.watch(config.www.scss.app.dest + '**/*.css');
		wwwPixrem.on('change', function(){
			serum.doPixrem(config.www.scss.app.dest + '**/*.css', config.www.scss.app.dest)
		});
});

gulp.task('update-foundation', function(){
	gulp.src('bower_components/foundation/scss/foundation/_settings.scss')
		.pipe(gulp.dest('pre/scss'));
});

gulp.task('core.install', ['core-install'], function(){
	runSequence('update-foundation','run');
});

gulp.task('static.install', function(cb){
	gulp.src('', {read: false})
		.pipe(plugins.shell([
			'mv pre/.htaccess ./.htaccess',
			'mv pre/index.html.template ./index.html',
			'rm pre/*.php'
		]))

	runSequence('update-foundation','run');
	cb();
})

gulp.task('install', function(){
	return gulp.src('')
		.pipe(plugins.prompt.prompt({
			type: 'list',
			message: 'What type of project are you installing?',
			name: 'project_type',
			choices: ['Innovative Core','Static HTML']
		}, function(res){
			if (res.project_type === 'Innovative Core') {
				gulp.start(core.install)
			} else {
				gulp.start(static.install)
			}
		}))
})

gulp.task('run', ['scss', 'js', 'images']);
gulp.task('default', ['watch', 'run']);

// Clean install
gulp.task('revert', function(){
	return gulp.src('')
		.pipe(plugins.shell([
			'rm -Rf tmp app bootstrap public uploads vendor .gitattributes .gitignore artisan composer.lock composer.json phpunit.xml readme.md server.php'
		]));
});