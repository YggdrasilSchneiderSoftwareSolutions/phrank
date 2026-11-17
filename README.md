# Phrank

Phrank is a lightweight PHP microframework for building REST APIs. It provides simple HTTP request routing, application configuration, and before/after middleware.

The framework supports the `GET`, `POST`, `PUT`, `PATCH`, `DELETE`, and `OPTIONS` HTTP methods.

## Routing example

The following snippet shows the basic routing API:

```php
get('/hello', function () {
	echo 'Hello, World!';
});

post('/hello', function () {
	http_response_code(201);
});

put('/hello', function () {
	http_response_code(204);
});

patch('/hello', function () {
	http_response_code(204);
});

delete('/hello', function () {
	http_response_code(204);
});

options('/hello', function () {
	header('Allow: GET, POST, PUT, PATCH, DELETE, OPTIONS');
	http_response_code(204);
});

run();
```

## Configuration and filters

Use `configure()` to set the base path, environment, and debug mode. The `before()` filter runs before route matching and the handler; `after()` runs after route dispatch, including when no route matches. They are useful for shared request setup and post-request tasks.

```php
configure(function ($config) {
	$config->setBasePath('/api');
	$config->setEnvironment('production');
	$config->setDebugMode(false);
});

before(function () {
	header('Content-Type: application/json');
});

after(function () {
	error_log('Request dispatched');
});
```

The project's `index.php` contains a complete usage example, including configuration, middleware, and route handlers.

## Apache

The included `.htaccess` forwards requests that do not match an existing file or directory to `index.php`. Apache's `mod_rewrite` module and `AllowOverride` must be enabled for the project directory.

## NGINX

NGINX does not read `.htaccess` files. Add a `try_files` rule to the site's `server` block to internally forward requests that do not match an existing file or directory to `index.php`, preserving query parameters:

```nginx
location / {
	try_files $uri $uri/ /index.php?$query_string;
}
```

Make sure the server is also configured to run `index.php` through PHP-FPM.