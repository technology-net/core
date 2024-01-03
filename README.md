## IBOOT - CORE PACKAGE


## Description.
This is a core package management

## Add config for Laravel 10

### File `package.json`

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
        "popper.js": "^1.16.1"
    },
    "dependencies": {
        "autoprefixer": "10.4.5",
        "glob": "^10.3.10"
    }
}

```

### Create new project and add file `webpack.mix.js`

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
glob.sync(path.resolve(__dirname) + '/vendor/iboot/**/webpack.mix.js').forEach(item => require(item))
glob.sync(path.resolve(__dirname) + '/packages/**/webpack.mix.js').forEach(item => require(item))
```

## How to install?
```angular2html
composer require iboot/core
```

## Run Environment

```angular2html
php artisan core:environment
```

- Change your config/auth.php file:
```angular2html
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => \IBoot\Core\App\Models\User::class,
    ],
];
```

- Install `node_modules`:
```angular2html
npm install
```

## Run demo
```angular2html
php artisan ser
npm run watch
```

http://localhost:8000/admin

```
Email: admin@icitech.net
Password: password
```
