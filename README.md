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
glob.sync(path.resolve(__dirname) + '/vendor/iboot/**/**/webpack.mix.js').forEach(item => require(item))

```

## How to install?
`composer require iboot/core`

## Run migration && seeder

`php artisan migrate`

`php artisan db:seed --class="IBoot\Core\Database\Seeders\UserSeeder"`

`php artisan vendor:publish --force`

## File `package.json` and `npm run watch`

```

{
    "private": true,
    "scripts": {
        "dev": "npm run development",
        "development": "mix",
        "watch": "mix watch",
        "watch-poll": "mix watch -- --watch-options-poll=1000",
        "hot": "mix watch --hot",
        "prod": "npm run production",
        "production": "mix --production"
    },
    "devDependencies": {
        "axios": "^1.1.2",
        "laravel-mix": "^6.0.49",
        "laravel-vite-plugin": "^0.8.0",
        "popper.js": "^1.16.1",
        "vite": "^4.0.0"
    },
    "dependencies": {
        "autoprefixer": "10.4.5",
        "glob": "^10.3.10"
    }
}

```

