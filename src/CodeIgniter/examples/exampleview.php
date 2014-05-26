<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Example PHP to JavaScript for CodeIgniter</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">

    <header col-md-12>
        <h1>Example PHP to JavaScript</h1>
    </header>

    <div class="col-md-12">

        <div class="col-md-12">
        <h3>Overview</h3>
        <p>This is a CodeIgniter implementation for <a href="https://github.com/JeffreyWay/PHP-Vars-To-Js-Transformer">Jeffery Way's PHP-Vars-To-Js-Transformer</a>  for those of us who still have clients using CodeIgniter or maintain CodeIgniter websites. An example controller and view are included.</p>
        </div>

    </div>

    <div class="col-md-12">
        <div class="col-md-12">
        <h3>Installation</h3>
        </div>
        <div class="col-md-12">
        <p>Create a <strong>composer.json</strong> file in your application/third_party directory and install with composer. The require statement needed to autoload Laracasts\Utilities is already in the <strong>PHPToJavaScript.php</strong> library.</p>
        <pre class="prettyprint">
{
"require": {
"laracasts/utilities": "1.0.1"
    }
}
        </pre>
        <p>Copy <strong>$config['javaScriptNameSpace'] = 'window';</strong> setting to your config.php file. Set the namespace to what ever you like. </p>
        <p>Copy the <strong>MY_Loader.php</strong> file to the application/core directory.</p>
        <p>Copy the <strong>PHPToJavaScript.php</strong> file to the application/libraries directory.</p>
        </div>
    </div>

    <div class="col-md-12">

        <div class="col-md-12">
            <h3>Usage</h3>
        </div>

        <div class="col-md-12">

            <h4>Overview</h4>
            <div>
            <p>The MY_Loader overrides CI_Loader to catch the variables passed in the controller when loading the view.<p>
            </div>
            <div>
            <p>To pass the data to be converted to JavaScript. There needs to be a key with the name <strong>phpToJavaScript</strong> in the array passed when loading the view.<p>
            </div>
                <pre class="prettyprint">
$data = array(
    'phpToJavaScript' => array(
        'php' => array(
            'foo' => 'bar'
        )
     )
);
$this->load->view( 'exampleview' , $data );
                </pre>
         </div>
        <div class="col-md-12">
            <p>Place the following php code snippet above your scripts.</p>
        </div>

        <div class="col-md-12">
        <pre class="prettyprint">
if(isset($phpToJavaScript)){
    echo $phpToJavaScript;
}
// javascript libraries go below
        </pre>
        </div>
        <div class="col-md-12">
            <p>The new JavaScript data will be available as window.window.php for the example above.<p>
        </div>

    </div>
</div>
<?php
    if(isset($phpToJavaScript)){
        echo $phpToJavaScript;
    }
?>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
<style>
    body {
        font-weight:400;
    }
    pre.prettyprint {
        border: 1px solid #ccc;
        margin-bottom: 0;
        padding: 20px 10px 10px;
    }
</style>
</body>
</html>