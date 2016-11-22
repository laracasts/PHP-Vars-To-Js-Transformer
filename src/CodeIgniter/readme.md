PHP to JavaScript for CodeIgniter
=========================

### Overview

This is a CodeIgniter implementation for [Jeffery Way's
PHP-Vars-To-Js-Transformer](https://github.com/JeffreyWay/PHP-Vars-To-Js-Transformer)
for those of us who still have clients using CodeIgniter or maintain
CodeIgniter websites. An example controller and view are included.

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

The examples above will produce the following. 

```html

<script>window.window = window.window || {};window.php = {"foo":"bar"};</script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

```

The new JavaScript data will be available as window.window.php . 

