// https://github.com/alextheme/gulp_for_wp/tree/main

import gulp from 'gulp';
import yargs from 'yargs';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import postcss from 'gulp-postcss';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import cleanCss from 'gulp-clean-css';
import gulpif from 'gulp-if';
import imagemin from 'gulp-imagemin';
import { deleteAsync } from 'del';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import browserSync from "browser-sync";
import zip from "gulp-zip";
import info from "./package.json" assert { type: "json" };
import replace from "gulp-replace";
import wpPot from "gulp-wp-pot";
// import $ from 'jquery';
const { src, dest, watch, series, parallel } = gulp;
const sass = gulpSass(dartSass);

import svgsprite from "gulp-svg-sprite";
import svgmin from "gulp-svgmin";
import svgstore from "gulp-svgstore";
import cheerio from "gulp-cheerio";
import rename from "gulp-rename";
import svgfallback from "gulp-svgfallback";
import path from "path";

const PRODUCTION = yargs(process.argv).parse().hasOwnProperty('prod');

const root = '';
const projectSettings = {
    dest: root + 'assets',
    http: 'http://localhost/pegasus/'
}


export const styles = () => {
    return src(['src/scss/bundle.scss', 'src/scss/admin.scss'])
        .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulpif(PRODUCTION, postcss([ autoprefixer ])))
        .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
        .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
        .pipe(dest(`${projectSettings.dest}/css`))
        .pipe(server.stream());
}

export const images = () => {
    return src(['src/images/**/*.{jpg,jpeg,png,svg,gif}', '!src/images/icons/sprite/*.svg'])
        .pipe(gulpif(PRODUCTION, imagemin()))
        .pipe(dest(`${projectSettings.dest}/images`));
}

export const sprite = () => {
    return src('src/images/icons/sprite/*.svg')
        .pipe(svgmin({ js2svg: { pretty: true } }))
        .pipe(cheerio({
            run: function ($) {
                $('[fill]').removeAttr('fill');
                $('[stroke]').removeAttr('stroke');
                $('[style]').removeAttr('style');
            },
            parserOptions: { xmlMode: true }
        }))
        .pipe(replace('&gt;', '>'))
        .pipe(svgstore())
        .pipe(dest(`${projectSettings.dest}/images/icons`));
}

export const sprite2 = () => {
    return src('src/images/icons/sprite/*.svg')
        .pipe(svgmin({ js2svg: { pretty: true } }))
        .pipe(cheerio({
            run: function ($) {
                $('[fill]').removeAttr('fill');
                $('[stroke]').removeAttr('stroke');
                $('[style]').removeAttr('style');
            },
            parserOptions: {xmlMode: true}
        }))
        .pipe(replace('&gt;', '>'))
        .pipe(svgsprite({
            mode: {
                symbol: true,
            }
        }))
        .pipe(dest(`${projectSettings.dest}/images/icons`));
}



export const copy = () => {
    return src(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'])
        .pipe(dest(projectSettings.dest));
}
export const clean = async (cb) => {
    await deleteAsync([`${projectSettings.dest}/**/*`]);
    cb();
}

export const scripts = () => {
    //return src('src/js/bundle.js')
    return src(['src/js/bundle.js','src/js/admin.js'])
        .pipe(named())
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            mode: PRODUCTION ? 'production' : 'development',
            devtool: !PRODUCTION ? 'eval-source-map' : false,
            output: {
                filename: '[name].js'
            },
            externals: {
                jquery: 'jQuery'
            },
        }))
        .pipe(dest(`${projectSettings.dest}/js`));
}


export const watchForChanges = () => {
    watch('src/scss/**/*.scss', styles);
    watch('src/images/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch(['src/**/*','!src/{images,js,scss}','!src/{images,js,scss}/**/*'], series(copy, reload));
    watch('src/js/**/*.js', series(scripts, reload));
    watch('src/images/icons/sprite', series(sprite, reload));
    watch("**/*.php", reload);
}


const server = browserSync.create();
export const serve = done => {
    server.init({
        proxy: projectSettings.http // put your local website link here
    });
    done();
};
export const reload = done => {
    server.reload();
    done();
};


export const compress = () => {
    return src([
        "**/*",
        "!node_modules{,/**}",
        "!bundled{,/**}",
        "!src{,/**}",
        "!.babelrc",
        "!.gitignore",
        "!gulpfile.babel.js",
        "!package.json",
        "!package-lock.json",
        "!__info.md",
        "!_info.md",
    ])
        // .pipe(replace("_themename", info.name))
        .pipe(
            gulpif(
                file => file.relative.split(".").pop() !== "zip",
                replace("_themename", info.name)
            )
        )
        .pipe(zip(`${info.name}.zip`))
        .pipe(dest('bundled'));
};
export const pot = () => {
    return src("**/*.php")
        .pipe(
            wpPot({
                domain: "_themename",
                package: info.name
            })
        )
        .pipe(dest(`languages/${info.name}.pot`));
};




export const dev = series(clean, parallel(styles, images, sprite, copy, scripts), serve, watchForChanges);
export const build = series(clean, parallel(styles, images, sprite, copy, scripts), pot, compress);


export const svg = series(clean, parallel(sprite));
// export const svg2 = series(clean, parallel(sprite2));

export default dev;

