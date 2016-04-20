# Ex libris

## Description

A simple app following the MVC pattern.

Technologies used and attributions:

- **Backend**:
[PHP](http://php.net/),
[MySQL](http://www.mysql.com/),
[Twig](https://github.com/twigphp/Twig),
[Apache (mod_rewrite)](http://httpd.apache.org/docs/current/mod/mod_rewrite.html)

- **Frontend**:
[HTML](https://www.w3.org/TR/html5/),
[CSS](https://www.w3.org/Style/CSS/),
[Compass](https://github.com/Compass/compass) ([Sass](https://github.com/sass/sass)),
[HTML5 Boilerplate (partial)](https://github.com/h5bp)

## Demo

[Here](http://exlibris.byethost33.com/)

## Directory structure

|Directory                    |Description|
|-----------------------------|-----------|
|` App/ `                     | Main directory of the app |
|` App/Controllers/ `         | You guessed it! The controllers are located here |
|` App/Models/ `              | Same as above, but here you'll find the models |
|` App/Views/ `               | The views folder. In fact, here are just the template files that are to be rendered by the view located in ` Core/ ` folder. |
|` Core/Controller.php `      | Base Controller |
|` Core/Error.php `           | Error handling and reporting |
|` Core/Model.php `           | Base Model |
|` Core/Router.php `          | Routing and dispatching |
|` Core/View.php `            | The View |
|` logs/ `                    | Where 'the problems will be reported' |
|` public/ `                  | The public directory of the app. When opening the address of the app you'll be redirected to this directory. See the ` /.htaccess ` file to find out how this is achieved. |
|` public/sass `              | Sass stylesheets |
|` public/stylesheets `       | CSS stylesheets compiled from Sass |
|` vendor/Twig `              | Twig, the flexible, fast, and secure template language for PHP. See the contents for more information. |
|` .htaccess `                | Rewrite engine configuration. See details below. |
|` b33_17781728_exlibris.sql `| MySQL database dump |

## Configuration of ".htaccess" files

In order for the server to redirect users to the ` public ` folder, the
rewriting engine should be installed and configured. These configurations are
written in the ` /.htaccess ` file.

The same module is used to hide ` index.php ` and pass through the query string
when writing the address. This is done in the ` /public/.htaccess ` file.

## Installation notes

To use this application, you'll need to supply the database credentials in
` /App/Config.php ` as well as select the database itself. Also, don't forget to
change the rewriting rule in the ` /.htaccess ` file (the one in the root
directory).