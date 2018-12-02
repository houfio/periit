const Encore = require('@symfony/webpack-encore');

module.exports = Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .addEntry('app', './assets/js/app.js')
  .addEntry('login', './assets/js/login.js')
  .addEntry('admin', './assets/js/admin.js')
  .enableSingleRuntimeChunk()
  .cleanupOutputBeforeBuild()
  .enableSourceMaps(!Encore.isProduction())
  .enableVersioning(Encore.isProduction())
  .enableSassLoader()
  .disableImagesLoader()
  .disableFontsLoader()
  .copyFiles({ from: './assets/img' })
  .getWebpackConfig();
