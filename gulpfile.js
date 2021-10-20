// Gulp stuff
const {
	src,
	dest,
	task,
	watch,
	parallel,
} = require('gulp');

// CSS related plugins
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');


// JS related 
const uglify = require('gulp-uglify');
const babelify = require('babelify');
const browserify = require("browserify");
const source = require("vinyl-source-stream");
const buffer = require("vinyl-buffer");

// Utilities
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const chalk = require('chalk');
const tinify = require('tinify');
tinify.key = "YOUR_API_KEY";

//Node
const fs = require("fs");
const path = require('path'); 

function css(done) {
	src('./assets/scss/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}))
		.on('error', console.error.bind(console))
		.pipe(autoprefixer())
		.pipe(rename({
			basename: 'style',
			suffix: '.min'
		}))
		.pipe(sourcemaps.write('/'))
		.pipe(dest('./dist/css'))
	done();
}


function buildCss(done) {
	src('./assets/scss/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
			errLogToConsole: true,
			outputStyle: 'compressed'
		}))
		.on('error', console.error.bind(console))
		.pipe(autoprefixer())
		.pipe(rename({
			basename: 'style' + '_' + Math.random().toString(20).substr(2, 9),
			suffix: '.min'
		}))
		.pipe(sourcemaps.write('/'))
		.pipe(dest('./dist/css'))
	done();
};

function buildJs(done) {
	browserify({
			entries: ["./assets/js/main.js"]
		})
		.transform("babelify", {
			presets: [
				"@babel/preset-env"
			]
		})
		.bundle()
		.pipe(source('main' + '_' + Math.random().toString(20).substr(2, 9) + '.min.js'))
		.pipe(buffer())
		.pipe(sourcemaps.init())
		.pipe(uglify())
		.pipe(sourcemaps.write('/'))
		.pipe(dest("./dist/js/"))
	done();
}

function js(done) {
	browserify({
			entries: ["./assets/js/main.js"]
		})
		.transform("babelify", {
			presets: [
				"@babel/preset-env"
			]
		})
		.bundle()
		.pipe(source('main.min.js'))
		.pipe(buffer())
		.pipe(sourcemaps.init())
		.pipe(uglify())
		.pipe(sourcemaps.write('/'))
		.pipe(dest("./dist/js/"))
	done();
}

function fonts(done) {
	src('./assets/fonts/*.{eot,svg,ttf,woff,woff2}')
		.pipe(dest('./dist/fonts'))
	done();
};


function images() {
	fs.readdir('./assets/images', (err, files) => {
		if (err) throw err;

		files.forEach(file => {
			fileExt = path.extname(file);

			switch(fileExt){
				case '.jpg':
					tinifyImage(file);
					break;
				case '.jpeg':
					tinifyImage(file);
					break;
				case '.png':
					tinifyImage(file);
					break;
				default:
					dest('./dist/css');
					break;
			}
		});
	});
}

function tinifyImage(image){
	const source = tinify.fromUrl('./assets/images/' + image);
	source.toFile(image);
	dest('./dist/images');
	fs.rename('./assets/images', './dist/images', function (err) {
		if (err) throw err;
		console.log(chalk.bgGreen.black.bold('Successfully compressed ==>' + ' ' + image));
	});
}

function watchFiles() {
	watch('./assets/scss/**/*.scss', css);
	watch('./assets/js/**/*.js', js);
	console.log(chalk.bgGreen.black.bold('Watching files for changes...'));
}

task("watch", watchFiles);
task("build", parallel(
	buildCss,
	buildJs,
	//fonts,
	//images
));
task("default", parallel(
	css,
	js,
	fonts,
	images
));