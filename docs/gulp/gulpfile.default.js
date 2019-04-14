const folder = {
    src: 'resources/',
    tmp: '.tmp/',
    dist: 'public/',
    dist_assets: 'public/assets/',
}

const {src, dest, series, parallel} = require('gulp');
const del = require('del');
const browserSync = require('browser-sync').create();
const htmlmin = require('gulp-htmlmin'); // 压缩html
const useref = require('gulp-useref');
const plumber = require('gulp-plumber');
const rename = require("gulp-rename"); // 重命名
const gulpif = require('gulp-if'); // 判断
const sass = require('gulp-sass'); // 解析sass
const cssnano = require('cssnano'); // 压缩css
const concat = require('gulp-concat'); // 合并文件
const uglify = require('gulp-uglify'); // 压缩js

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
    return src(folder.src + 'assets/styles/**/*.{scss,sass}')
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
    return src(folder.src + 'assets/scripts/**/*.js', {sourcemaps: true})
        .pipe(plumber())
        //.pipe($.babel())
        //.pipe(concat('app.min.js'))
        //.pipe(gulpif(/\.js$/, uglify({compress: {drop_console: true}})))
        .pipe(concat("main.js"))
        .pipe(dest(folder.dist + 'assets/js', {sourcemaps: true}))
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

    browserSync.watch([
        folder.src + 'views/**/*.phtml',
        folder.src + 'assets/images/**/*',
        folder.src + 'assets/fonts/**/*'
    ]).on('change', browserSync.reload);
    browserSync.watch(folder.src + 'assets/styles/**/*.{scss,sass}', css).on('change', browserSync.reload);
    browserSync.watch(folder.src + 'assets/scripts/**/*.js', js).on('change', browserSync.reload);
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
exports.css = css;
exports.html = html;
exports.build = build;
exports.default = develop;
