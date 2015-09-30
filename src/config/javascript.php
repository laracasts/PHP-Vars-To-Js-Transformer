<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View to Bind JavaScript Vars To
    |--------------------------------------------------------------------------
    |
    | Set this value to the name of the view (or partial) that
    | you want to prepend all JavaScript variables to.
    | This can be a single view, or an array of views.
    | Example: 'footer' or ['footer', 'bottom']
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
    'js_namespace' => 'window',

    /*
    |--------------------------------------------------------------------------
    | Angular Module
    |--------------------------------------------------------------------------
    |
    | By default, we disable the Angular constants service. If you would like
    | to export your PHP vars to Angular constants, you will want to change
    | this to the Angular module that you want to bind your constants to.
    | This will also activate the Angular service.
    |
    */
    'ng_module' => false,

    /*
    |--------------------------------------------------------------------------
    | Angular Constant Name
    |--------------------------------------------------------------------------
    |
    | The name of the Angular constant we are attaching the data to.
    |
    */
    'ng_constant' => 'DATA'

];
