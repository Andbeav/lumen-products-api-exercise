# Lumen Products API exercise

A simple implementation of Lumen as a 'products' API.

## The Brief

Build a RESTful web application with the following API endpoints.
Data should persist to a sql database.

### API Endpoints

```json
POST /products
[
    {
        "sku":"abc",
        "attributes": {
            "size": "small",
            "grams":"100",
            "foo":"bar"
        }
    }
]

"attributes" can contain any key value. "sku" is unique.

GET /products
Returns a list of products
[
    {
        "sku":"abc",
        "attributes": {
            "size": "small",
            "grams":"100",
            "foo":"bar"
        }
    },
    ...
]
```

## The implementation details

* API structure implemented as outlined above.
* Data persists to a MySQL db while the db image is running.
* Database is seeded with the product/attributes per the example.
* No external libraries included outside of the base lumen setup.

### Performance and scaling considerations

While there's nothing too special, there are some items worth noting:

* I find the MVC approach to work exceptionally well in these data access layer type applications, as maintenance and extension is made easy with how each component is split into their own domains (routing, db access, formatting).
* Lumen was also a conscious choice over the typical Laravel setup as it is more lightweight and has faster response times.
* Database drivers are plug and play, with lumen supporting four out of the box (MySQL, PostgreSQL, SQLite, and SQL Server).
* As this is containerized we can build and deploy with ease on any host/cloud with a container runtime.

## Running the service

Build the `app` image.

```
$ docker-compose build app
```

Start up the `app` image.

```
$ docker-compose up app
```

To cleanly shutdown, run `docker-compose down` regardless of whether it was shut down with `^C`.

## Running the tests

Similar to how you run the service, build the `test` image.

```
$ docker-compose build test
```

Run the `test` image.

```
$ docker-compose run test
```

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
