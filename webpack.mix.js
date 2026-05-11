const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass("resources/sass/template/report.scss", "css");
mix.sass("resources/sass/template/report-ranking.scss", "css");
mix.copy("resources/img", "public/img");
mix.copy("resources/svg", "public/svg");
