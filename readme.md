# Breadcrumb

## Install

First, install the package via composer:

```
composer require kkiernan/breadcrumb
```

Then add the service provider to `config/app.php`.

```php
'providers' => [
    Kiernan\Breadcrumbs\ServiceProvider::class,
]
```

## Usage

In your controller, add breadcrumbs as needed before rendering the view.

```php
public function create()
{
    Breadcrumbs::add('Posts', action('PostsController@index'));
    Breadcrumbs::add('New Post');

    return view('posts.create');
}
```

You can also add many breadcrumbs at one time if you prefer:

```php
Breadcrumbs::addMany([
    ['Posts', action('PostsController@index')],
    ['New Post']
]);
```

The package contains a default Bootstrap view that you can use to display your breadcrumbs. Simply add the following to your layout:

```
@include(kkiernan::breadcrumbs);
```

Publish this view to `resources/views/vendor/kkiernan` by running the artisan command below. You can then edit the view as desired.

```
php artisan vendor:publish --provider=Kiernan\Breadcrumbs\ServiceProvider.php
```

## Dynamic Crumbs

You may also render breadcrumbs dynamically. This is helpful when there are multiple ways to arrive at a view. For example, imagine that both a list of posts and a dashboard link to a post detail view.

```php
// In your DashboardController@index method...
Breadcrumbs::put('posts', 'Dashboard', action('DashboardController@index'));
```

```php
// In your PostsController@index method...
Breadcrumbs::put('posts', 'Dashboard', action('DashboardController@index'));
```

```php
// In your PostsController@show method...
Breadcrumbs::addDynamic('posts');
Breadcrumbs::add($post->title);
```

The breadcrumbs will now display as either "Dashboard / The Post Title" or "Posts / The Post Title". This functionality is also available as `Breadcrumbs::addIf('posts')` for situations where it reads more fluently (usually when the dynamic crumb is not in the first position).

If you need to unset a dynamic crumb and prevent it from rendering, simply call the forget method:

```php
Breadcrumbs::forget('posts');
```
