# Attention!
This package was used on my past work projects as easy code generating tool: it has minimum possibilities, unfortunately no tests inside package (we experienced troubles to make laravel essentials like container or routes to work and have no idea about great tools like orchestral's [testbench](https://github.com/orchestral/testbench) yet) and some bugs. For now I have no interests to maintain this package, if you would like to continue work with that code = do yourself a favor, fork it and then use it. Thanks.

# Eloquent Resources

Common tools for quick resources creation including Repository with Interface, Validation and Controller with Interface.

# Installation
Package in deep development, for now only "dev-master" available.
```bash
composer require devjs/eloquent-resources:dev-master
```

If Laravel/lumen version lower 5.5, register package service provider manualy.
```bash
Devjs\EloquentResources\EloquentResourcesServiceProvider
```

# Usage
You can create bunch of useful things by typing
```bash
php artisan eloquent-resources:generate <entityName>
```
where entityName is Eloquent Model under App\Entity namespace. Make sure you're created bindings for interfaces (Http and Repository) and routes mapping (all, get, create, update, destroy).

For more info checkout command help.

```bash
php artisan help eloquent-resources:generate
```
