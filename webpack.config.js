const path = require('path')
var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
  Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')

  .addEntry('admin', './assets/js/admin/index.js')

  .addAliases({
    api: path.resolve(__dirname, 'assets/js/api'),
    utils: path.resolve(__dirname, 'assets/js/admin/utils'),
    ui: path.resolve(__dirname, 'assets/js/admin/ui'),
    mixins: path.resolve(__dirname, 'assets/js/admin/mixins'),
  })

  // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
  .splitEntryChunks()

  .disableSingleRuntimeChunk()

  /*
   * FEATURE CONFIG
   *
   * Enable & configure other features below. For a full
   * list of features, see:
   * https://symfony.com/doc/current/frontend.html#adding-more-features
   */
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  // enables hashed filenames (e.g. app.abc123.css)
  .enableVersioning(Encore.isProduction())

  // enables @babel/preset-env polyfills
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = 3;
  })

  .enableIntegrityHashes(Encore.isProduction())

  .enablePostCssLoader()

  .enableVueLoader()
;

module.exports = Encore.getWebpackConfig();
