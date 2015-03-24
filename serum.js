var	p = require('./package.json'),
	publicPath = p.publicPath;

module.exports = {
	www: {},
	libraries: {}
};

module.exports.www.scss = {
	app: {
		src: ['pre/scss/**/*.scss'],
		paths: [
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
		dest: publicPath + 'css/'
	}
}

module.exports.www.penthouse = {
	home: {
		url: [''],
		src: publicPath + 'css/app.css',
		dest: 'resources/views/www/_partials/critical.blade.php'
	}
}

module.exports.libraries.js = {
	legacy: {
		src: [
			'bower_components/html5shiv/dist/html5shiv.js'
			, 'bower_components/es5-shim/es5-shim.js'
			, 'js/ie8/nwmatcher-1.2.5-min.js'
			, 'bower_components/selectivizr/selectivizr.js'
			, 'bower_components/respond/dest/respond.min.js'
		],
		name: 'legacy',
		dest: publicPath + 'js/'
	},
	modernizr: {
		src: ['bower_components/modernizr/modernizr.js'],
		name: 'modernizr',
		dest: publicPath + 'js/'
	},
	jquery: {
		src: ['bower_components/jquery/dist/jquery.js'],
		name: 'jquery',
		dest: publicPath + 'js/'
	},
	jqueryLegacy: {
		src: ['bower_components/jquery-legacy/dist/jquery.js'],
		name: 'jquery-legacy',
		dest: publicPath + 'js/'
	},
	rem: {
		src: ['bower_components/rem-unit-polyfill/js/rem.min.js'],
		name: 'rem',
		dest: publicPath + 'js/'
	}
}

module.exports.www.js = {
	app: {
		watchGlob: 'pre/js/**/*.js',
		src: [
			'bower_components/modernizr/modernizr.js'
			, 'bower_components/respimage/respimage.min.js'
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
		],
		name: 'app',
		dest: publicPath + 'js/'
	}
}

module.exports.www.images = {
	app: {
		src: ['pre/images/**/*'],
		dest: publicPath + 'images/'
	}
}