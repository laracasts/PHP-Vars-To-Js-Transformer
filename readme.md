# Transform PHP Vars to JavaScript

[![Build Status](https://travis-ci.org/laracasts/PHP-Vars-To-Js-Transformer.png?branch=master)](https://travis-ci.org/laracasts/PHP-Vars-To-Js-Transformer)

Often, you'll find yourself in situations, where you want to pass some server-side string/array/collection/whatever
to your JavaScript. Traditionally, this can be a bit of a pain - especially as your app grows.

This package simplifies the process drastically.

## Installation

Begin by installing this package through Composer.

```js
{
    "require": {
		"laracasts/utilities": "~2.0"
	}
}
```

> If you use Laravel 4: instead install `~1.0` of this package (and use the documentation for that release). For Laravel 5 (or non-Laravel), `~2.0` will do the trick!

### Laravel Users

If you are a Laravel user, there is a service provider you can make use of to automatically prepare the bindings and such.

```php

// config/app.php

'providers' => [
    '...',
    'Laracasts\Utilities\JavaScript\JavaScriptServiceProvider'
];
```

When this provider is booted, you'll gain access to a helpful `JavaScript` facade, which you may use in your controllers.

```php
public function index()
{
    JavaScript::put([
        'foo' => 'bar',
        'user' => User::first(),
        'age' => 29
    ]);

    return View::make('hello');
}
```

> In Laravel 5, of course add `use JavaScript;` to the top of your controller.

Using the code above, you'll now be able to access `foo`, `user`, and `age` from your JavaScript.

```js
console.log(foo); // bar
console.log(user); // User Obj
console.log(age); // 29
```

This package, by default, binds your JavaScript variables to a "footer" view, which you will include. For example:

```
<body>
    <h1>My Page</h1>

    @include ('footer') // <-- Variables prepended to this view
</body>
```

Naturally, you can change this default to a different view. See below.

### Defaults

If using Laravel, there are only two configuration options that you'll need to worry about. First, publish the default configuration.

```bash
php artisan vendor:publish
```

This will add a new configuration file to: `config/javascript.php`.

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View to Bind JavaScript Vars To
    |--------------------------------------------------------------------------
    |
    | Set this value to the name of the view (or partial) that
    | you want to prepend all JavaScript variables to.
    |
    */
    'bind_js_vars_to_this_view' => 'footer',

    /*
    |--------------------------------------------------------------------------
    | JavaScript Namespace
    |--------------------------------------------------------------------------
    |
    | By default, we'll add variables to the global window object. However,
    | it's recommended that you change this to some namespace - anything.
    | That way, you can access vars, like "SomeNamespace.someVariable."
    |
    */
    'js_namespace' => 'window'

];
```

#### bind_js_vars_to_this_view

You need to update this file to specify which view you want your new JavaScript variables to be prepended to. Typically, your footer is a good place for this.

If you include something like a `layouts/partials/footer` partial, where you store your footer and script references, then make the `bind_js_vars_to_this_view` key equal to that path. Behind the scenes, the Laravel implementation of this package will listen for when that view is composed, and essentially paste the JS variables within it.

#### js_namespace

By default, all JavaScript vars will be nested under the global `window` object. You'll likely want to change this. Update the
`js_namespace` key with the name of your desired JavaScript namespace. It can be anything. Just remember: if you change this setting (which you should),
then you'll access all JavaScript variables, like so:

```js
MyNewNamespace.varName
```

### Symfony2
To use this component in Symfony2 applications you can try [this bundle](https://github.com/holyspecter/HospectPhpVarsToJsBundle), built on top of PHP-Vars-To-Js-Transformer.

### Without Laravel

If you're not using Laravel, then you'll need to hard-wire things yourself. (Or, feel free to submit a pull request with an implementation for your desired framework.)

First, create an implementation of the `Laracasts\Utilities\JavaScript\ViewBinder` interface. This class is in charge of inserting the given JavaScript into your view/page.

```php
<?php

class MyAppViewBinder implements Laracasts\Utilities\JavaScript\ViewBinder {

    // $js will contain your JS-formatted variable initializations
    public function bind($js)
    {
        // Do what you need to do to add this JavaScript to
        // the appropriate place in your app.
    }
}
```

Next, put it all together:

```php
$binder = new MyAppViewBinder;
$javascript = new PHPToJavaScriptTransformer($binder, 'window'); // change window to your desired namespace

$javascript->put(['foo' => 'bar']);
```

Now, you can access `window.foo` from your JavaScript.

Remember, though, this is only necessary if you aren't using Laravel. If you are, then just reference the service provider, as demonstrated above.

### Codeigniter

This is a CodeIgniter implementation for those of us who still have clients using CodeIgniter. An example controller and view are included.

### Installation

Create a **composer.json** file in your application/third\_party
directory and install with composer. The require statement needed to
autoload Laracasts\\Utilities is already in the **PHPToJavaScript.php**
library.

```json

{
    "require": {
        "laracasts/utilities": "1.0.1"
    }
}
        
```

Copy **$config['javaScriptNameSpace'] = 'window';** setting to your
config.php file. Set the namespace to what ever you like.

Copy the **MY\_Loader.php** file to the application/core directory.

Copy the **PHPToJavaScript.php** file to the application/libraries
directory.


### Usage

#### Overview

The MY\_Loader overrides CI\_Loader to catch the variables passed in the
controller when loading the view.

To pass the data to be converted to JavaScript. There needs to be a key
with the name **phpToJavaScript** in the array passed when loading the
view.

```php

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ExampleController extends CI_Controller {


    /**
     * Send the user the front screen.
     */

    public function index()
    {

        $data = array(
                'phpToJavaScript' => array(
                        'php' => array(
                            'foo' => 'bar'
                        )
                    )
                );

        $this->load->view( 'exampleview' , $data );

    }

}
                
```

Place the following php code snippet above your scripts.

```php

<?php 
if(isset($phpToJavaScript)){
    echo $phpToJavaScript;
}
?>

// javascript libraries
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

```  

The example above will produce the following. 

```html

<script>window.window = window.window || {};window.php = {"foo":"bar"};</script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

```

The new JavaScript data will be available as window.php . 

## License

[View the license](https://github.com/laracasts/PHP-Vars-To-Js-Transformer/blob/master/LICENSE) for this repo.
