let mix = require('laravel-mix');

mix.options({
  postCss: [require('autoprefixer')]
});
mix.disableNotifications();
mix.js('src/js/PrivacyWire.js', 'js/PrivacyWire.js')
  .sass('src/scss/PrivacyWire.scss', 'css/PrivacyWire.css');

