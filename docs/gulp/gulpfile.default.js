const folder = {
    src: 'var/assets/',
    tmp: '.tmp/',
    dist: 'public/',
    dist_assets: 'public/assets/',
}

const {src, dest, watch, series, parallel} = require('gulp');
const del = require('del');
const browserSync = require('browser-sync').create();
const htmlmin = require('gulp-htmlmin'); // 压缩html
const useref = require('gulp-useref');
const plumber = require('gulp-plumber');
const rename = require("gulp-rename"); // 重命名
const gulpif = require('gulp-if'); // 判断
const sass = require('gulp-sass'); // 解析sass
const cssnano = require('cssnano'); // 压缩css
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const concat = require('gulp-concat'); // 合并文件
const uglify = require('gulp-uglify'); // 压缩js
const sourceMap = require('gulp-sourcemaps');
const browserify = require('browserify');

// 以下两个一起使用，自动处理浏览器兼容问题
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');

// 暂未使用
function html() {
    return src(folder.src + 'views/**/*.phtml')
    //.pipe(useref({searchPath: [folder.tmp, '.']}))
    //.pipe(gulpif(/\.js$/, uglify({compress: {drop_console: true}})))
    //.pipe(gulpif(/\.css$/, postcss([cssnano({safe: true, autoprefixer: false})])))
        .pipe(gulpif(/\.phtml$/, htmlmin({
            collapseWhitespace: true,
            minifyCSS: true,
            minifyJS: {compress: {drop_console: true}},
            processConditionalComments: true,
            removeComments: true,
            removeEmptyAttributes: true,
            removeScriptTypeAttributes: true,
            removeStyleLinkTypeAttributes: true
        })))
        .pipe(dest(folder.dist + 'templates'));
}

// 编译css
function css() {
    return src(folder.src + 'assets/css/**/*.{scss,sass}')
        .pipe(plumber())
        .pipe(sass.sync({
            outputStyle: 'expanded',
            precision: 10,
            includePaths: ['.']
        }).on('error', sass.logError))
        .pipe(postcss([
            autoprefixer()
        ]))
        .pipe(concat("main.css"))
        //.pipe(postcss([cssnano({safe: true, autoprefixer: false})]))
        .pipe(dest(folder.dist + 'assets/css'))
}

// 编译js
function js() {
    return src(folder.src + 'assets/js/**/*.js', {sourcemaps: true})
        .pipe(plumber())
        //.pipe($.babel())
        //.pipe(concat('app.min.js'))
        //.pipe(gulpif(/\.js$/, uglify({compress: {drop_console: true}})))
        .pipe(concat("main.js"))
        .pipe(dest(folder.dist + 'assets/js', {sourcemaps: true}))
}

// ES6
function script() {
    var b = browserify({
        transform: ['babelify'],
        entries: folder.src + "assets/js/main.js",
        debug: true
    });

    return b.bundle()
        .pipe(source('main.js'))
        .pipe(buffer())
        .pipe(sourceMap.init({loadMaps: true}))
        .pipe(plumber())
        .pipe(dest(folder.dist_assets + 'js'))
        .pipe(rename({suffix: ".min"}))
        .pipe(uglify())
        .pipe(sourceMap.write('.'))
        .pipe(dest(folder.dist_assets + 'js'));
}

// 压缩输出静态文件
function assetsCompress() {
    src(folder.dist + 'assets/css/main.css')
        .pipe(plumber())
        .pipe(gulpif(/\.css$/, postcss([cssnano({safe: true, autoprefixer: false})])))
        //.pipe(rename({suffix: ".min"}))
        .pipe(dest(folder.dist + 'assets/css'))

    return src(folder.dist + 'assets/js/main.js')
        .pipe(plumber())
        .pipe(gulpif(/\.js$/, uglify({compress: {drop_console: true}})))
        //.pipe(rename({suffix: ".min"}))
        .pipe(dest(folder.dist + 'assets/js'))
}

// 清理
function clean() {
    return del([folder.dist_assets, folder.tmp])
}

function startAppServer() {
    browserSync.init({
        notify: false,
        port: 3000,
        proxy: "phalcon:8080"
        /*server: {
            baseDir: [folder.tmp, folder.src],
            routes: {
                '/node_modules': 'node_modules'
            }
        }*/
    });

    watch([
        folder.src + 'views/**/*.phtml',
        folder.src + 'assets/images/**/*',
        folder.src + 'assets/fonts/**/*'
    ]).on('change', browserSync.reload);
    watch(folder.src + 'assets/css/**/*.{scss,sass}', css).on('change', browserSync.reload);
    watch(folder.src + 'assets/js/**/*.js', js).on('change', browserSync.reload);
}

// 构建
const build = series(
    clean,
    parallel(
        series(parallel(css, js), assetsCompress)
        //images,
        //fonts,
        //extras
    )
);

// 开发服务器
const develop = series(
    clean,
    startAppServer
);

exports.js = js;
exports.script = script;
exports.css = css;
exports.html = html;
exports.build = build;
exports.default = develop;
