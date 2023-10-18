const mix = require('laravel-mix')
const path = require('path')
let dir = path.resolve(__dirname)
let source = dir + '/resources/assets'
const dist = 'public'

mix
  // js
  .js(source + '/js/dashboard.js', dist + '/core/js').version()
  .js(source + '/js/hoverable-collapse.js', dist + '/core/js').version()
  .js(source + '/js/misc.js', dist + '/core/js').version()
  .js(source + '/js/off-canvas.js', dist + '/core/js').version()
  .js(source + '/js/settings.js', dist + '/core/js').version()
  .js(source + '/js/todolist.js', dist + '/core/js').version()
  .js(source + '/css/style.css', dist + '/core/css').version()
  .js(source + '/vendors/js/vendor.bundle.base.js', dist + '/core/vendors/js').version()
  .js(dir + '/resources/js/common.js', dist + '/core/js').version()
  .js(dir + '/resources/js/validate.js', dist + '/core/js').version()
  .js(dir + '/resources/js/login.js', dist + '/core/js').version()
  .js(dir + '/resources/js/user.js', dist + '/core/js').version()
  .js(dir + '/resources/js/plugin.js', dist + '/core/js').version()
  .copy(source + '/vendors/js/jquery-3.7.1.min.js', dist + '/core/vendors/js')
  .copy(source + '/vendors/toastr/toastr.min.js', dist + '/core/vendors/js')
  .copy(source + '/vendors/select2/select2.min.js', dist + '/core/vendors/js')
  .copy(source + '/vendors/sweet-alert/sweetalert2.all.min.js', dist + '/core/vendors/js')

  // css
  .css(source + '/vendors/css/vendor.bundle.base.css', dist + '/core/vendors/css').version()
  .css(source + '/vendors/mdi/css/materialdesignicons.min.css', dist + '/core/vendors/css').version()
  .css(dir + '/resources/css/plugin.css', dist + '/core/css').version()
  .css(dir + '/resources/css/user.css', dist + '/core/css').version()
  .copy(source + '/css/style.css', dist + '/core/css').version()
  .copy(source + '/vendors/toastr/toastr.min.css', dist + '/core/vendors/css').version()
  .copy(source + '/vendors/select2/select2.min.css', dist + '/core/vendors/css').version()
  .copy(source + '/vendors/sweet-alert/sweetalert2.min.css', dist + '/core/vendors/css').version()

  // fonts
  .copy(source + '/fonts', dist + '/core/fonts')
  .copy(source + '/vendors/mdi/fonts', dist + '/core/vendors/fonts')

  // images
  .copy(source + '/images', dist + '/core/images')
