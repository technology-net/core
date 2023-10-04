## IBOOT - CORE PACKAGE


## Description.
This is a package user management

## Create new project and add file `webpack.mix.js`

## How to install?
`composer require iboot/core`

## Run migration && seeder

- Remove migration `...create_users_table` in your project.

`php artisan migrate && php artisan db:seed --class="IBoot\Core\Database\Seeders\UserSeeder"`
