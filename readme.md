# Easy Breadcrumb Generation

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Install](#install)
- [Usage](#usage)
- [Dynamic Crumbs](#dynamic-crumbs)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Install

First, install the package via composer:

```
composer require kkiernan/breadcrumbs
```

If using Laravel, add the service provider and alias to `config/app.php`.

```php
'providers' => [
    Kiernan\Breadcrumbs\ServiceProvider::class,
],

'aliases' => [
    'Breadcrumbs' => \Kiernan\Breadcrumbs\Facade::class,
]
```

## Usage

Add breadcrumbs as needed before rendering your view:

```php
Breadcrumbs::add('Posts', action('PostsController@index'));
Breadcrumbs::add('New Post');
```

Add many breadcrumbs at once if you prefer:

```php
Breadcrumbs::addMany([
    ['Posts', action('PostsController@index')],
    ['New Post']
]);
```

A Bootstrap partial is included to display your breadcrumbs. If using Laravel Blade, you can include the partial in your template:

```
@include('kkiernan::breadcrumbs');
```

If you'd like to edit the partial, publish it to `resources/views/vendor/kkiernan`:

```
php artisan vendor:publish --tag=kkiernan
```

## Dynamic Crumbs

Breadcrumbs can be added dynamically, which is helpful when multiple pages link to a particular page. For example, imagine that both a dashboard and a list of posts link to a post detail view. Consider the following Laravel-centric example in which the first breadcrumb will render as either "Dashboard" or "Posts" depending on the referring page.

```php
// DashboardController@index...
Breadcrumbs::put('posts', 'Dashboard', action('DashboardController@index'));
```

```php
// PostsController@index...
Breadcrumbs::put('posts', 'Posts', action('DashboardController@index'));
```

```php
// PostsController@show...
Breadcrumbs::addDynamic('posts');
Breadcrumbs::add($post->title);
```

If you need to unset a dynamic crumb and prevent it from rendering, simply call the forget method:

```php
Breadcrumbs::forget('posts');
```
