const mix = require('laravel-mix');
const path = require('path');
const dir = path.resolve(__dirname)
const resourcesPathDist = dir + '/src/resources/assets/dist/';
const resourcesPathPlugins = dir + '/src/resources/assets/plugins/';
const resourcesPathCss = dir + '/src/resources/assets/css/';
const resourcesPathJs = dir + '/src/resources/assets/js/';
const publicPath = 'public/core/';

mix
  .js(resourcesPathJs + 'validate.js', publicPath + 'js/validate.mix.js').version()
  .js(resourcesPathJs + 'login.js', publicPath + 'js/login.mix.js').version()
  .js(resourcesPathJs + 'plugin.js', publicPath + 'js/plugin.mix.js').version()
  .js(resourcesPathJs + 'media.js', publicPath + 'js/media.mix.js').version()
  .js(resourcesPathJs + 'user.js', publicPath + 'js/user.mix.js').version()
  .js(resourcesPathJs + 'system-settings.js', publicPath + 'js/system-settings.mix.js').version()
  .js(resourcesPathJs + 'jquery.nestable.js', publicPath + 'js/jquery.nestable.mix.js').version()
  .js(resourcesPathJs + 'menu.js', publicPath + 'js/menu.mix.js').version()
  .js(resourcesPathJs + 'common.js', publicPath + 'js/common.mix.js').version()
  .css(resourcesPathCss + 'plugin.css', publicPath + 'css/plugin.mix.css').version()
  .css(resourcesPathCss + 'media.css', publicPath + 'css/media.mix.css').version()
  .css(resourcesPathCss + 'nestable.css', publicPath + 'css/nestable.mix.css').version()
  .css(resourcesPathCss + 'custom.css', publicPath + 'css/custom.mix.css').version()
  .copy(dir + '/src/resources/assets/images', publicPath + '/images')
  .copy(resourcesPathPlugins, publicPath + '/plugins')
  .copy(resourcesPathDist, publicPath + '/dist');
