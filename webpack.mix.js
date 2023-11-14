const mix = require('laravel-mix');
const path = require('path');
const dir = path.resolve(__dirname)
const resourcesPathDist = dir + '/src/resources/assets/dist/';
const resourcesPathPlugins = dir + '/src/resources/assets/plugins/';
const resourcesPathCss = dir + '/src/resources/assets/css/';
const resourcesPathJs = dir + '/src/resources/assets/js/';
const publicPath = 'public/core/';

mix
  .js(resourcesPathJs + 'validate.js', publicPath + 'js').version()
  .js(resourcesPathJs + 'login.js', publicPath + 'js').version()
  .js(resourcesPathJs + 'plugin.js', publicPath + 'js').version()
  .js(resourcesPathJs + 'media.js', publicPath + 'js').version()
  .js(resourcesPathJs + 'user.js', publicPath + 'js').version()
  .js(resourcesPathJs + 'system-settings.js', publicPath + 'js').version()
  .js(resourcesPathJs + 'common.js', publicPath + 'js').version()
  .css(resourcesPathCss + 'plugin.css', publicPath + 'css').version()
  .css(resourcesPathCss + 'media.css', publicPath + 'css').version()
  .css(resourcesPathCss + 'custom.css', publicPath + 'css').version()
  .copy(dir + '/src/resources/assets/images', publicPath + '/images')
  .copy(resourcesPathPlugins, publicPath + '/plugins')
  .copy(resourcesPathDist, publicPath + '/dist');
