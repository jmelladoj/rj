const mix = require('laravel-mix');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery', 'jquery']
});

mix.options({
    purifyCss: true
});

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
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
  'public/pagina/css/bootstrap.min.css',
  'public/pagina/css/animations.css',
  'public/pagina/css/main.css'
], 'public/css/pagina.css').options({
      purifyCss: {
        purifyOptions: {
          verbose:true,
          minimize:true,
        }
      }
    })
    .scripts([
      'public/pagina/js/compressed.js',
      'public/pagina/js/main.js',
    ], 'public/js/pagina.js').version();

mix.styles(['public/pagina/css/fonts.css'], 'public/css/fonts.css');

mix.styles([
  'public/intranet/css/pages/login-register-lock.css',
  'public/intranet/css/style.min.css'
], 'public/css/css-login.css');

mix.styles([
  'public/intranet/node_modules/morrisjs/morris.css',
  'public/intranet/css/style.min.css',
  'public/intranet/css/pages/dashboard1.css',
  'public/intranet/css/pages/floating-label.css'
], 'public/css/css-admin.css')
.scripts([
  'public/intranet/node_modules/jquery/jquery-3.2.1.min.js',
  'public/intranet/node_modules/popper/popper.min.js',
  'public/intranet/js/perfect-scrollbar.jquery.min.js',
  'public/intranet/js/waves.js',
  'public/intranet/js/sidebarmenu.js',
  'public/intranet/js/custom.min.js',
  'public/intranet/node_modules/jquery-sparkline/jquery.sparkline.min.js',
  'public/intranet/node_modules/raphael/raphael-min.js',
  'public/intranet/node_modules/morrisjs/morris.min.js',
  'public/intranet/js/dashboard1.js',
  'public/intranet/js/sweetalerts2.all.js'
], 'public/js/js-admin.js').version();
     
