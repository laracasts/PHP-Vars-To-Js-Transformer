<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class MY_Loader extends CI_Loader {

    protected $ci;

    public function view($view, $vars = array(), $return = FALSE)
    {
        $this->ci =& get_instance();
        $this->ci->load->libraries('PHPToJavaScript');
        $vars = $this->ci->phptojavascript->phptojavascript($vars);
        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
    }

} 