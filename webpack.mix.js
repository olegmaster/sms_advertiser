const mix = require('laravel-mix');
var webpack = require('webpack');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


// Override mix internal webpack output configuration
mix.config.webpackConfig.output = {
    chunkFilename: 'js/[name].bundle.js',
    publicPath: '/',
};


mix.webpackConfig({
    plugins: [
        // To strip all locales except “en”
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
    ],
    // Other config goes here
    resolve: {
        alias: {
            "@": path.resolve(
                __dirname,
                "resources/js"
            )
        }
    }
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/js/assets/base.scss', 'public/css/app.css');