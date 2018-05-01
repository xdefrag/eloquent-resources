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

# Todo
- controller event generation
- additional namespace for controller/validation/http interface
- package tests
