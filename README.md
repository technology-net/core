## IBOOT - CORE PACKAGE


## Description.
This is a package user management

## Create new project and add file `webpack.mix.js`
```
const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');

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

mix.options({
  processCssUrls: false,
  clearConsole: true,
  terser: {
    extractComments: false,
  }
})

// Run all webpack.mix.js in app
glob.sync(path.resolve(__dirname) + '/packages/**/**/webpack.mix.js').forEach(item => require(item))

```

## How to install?
`composer require iboot/core`

## Run migration && seeder

- Remove migration `...create_users_table` in your project.

`php artisan migrate && php artisan db:seed --class="IBoot\Core\Database\Seeders\UserSeeder"`
