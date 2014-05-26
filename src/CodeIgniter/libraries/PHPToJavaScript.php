<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/third_party/vendor/autoload.php';
use Laracasts\Utilities\JavaScript\PHPToJavaScriptTransformer;

    /**
     *
     * CodeIgniter PHP To JavaScript
     *
     * A Library to transfer PHP to JavaScript. Using JefferyWay's PHPToJavaScriptTransformer.
     * 
     * @package        	CodeIgniter
     * @subpackage    	Libraries
     * @category    	Libraries
     * @author        	Danny Nunez
     * @link            https://github.com/DannyNunez/PHP-Vars-To-Js-Transformer
     *
     */

    class PHPToJavaScript implements Laracasts\Utilities\JavaScript\ViewBinder {

        protected $ci;
        protected $javascript;
        protected $newJavaScript;
        protected $javaScriptNameSpace;

        public function __construct(){

            $this->ci =& get_instance();
            $this->javaScriptNameSpace = $this->ci->config->item('javaScriptNameSpace');

        }

        public function phpToJavaScript($vars){

            if(isset($vars['phpToJavaScript'])){
                $this->javascript = new PHPToJavaScriptTransformer($this,$this->javaScriptNameSpace);
                $this->javascript->put($vars['phpToJavaScript']);
                $vars['phpToJavaScript'] = $this->newJavaScript;
            }

            return $vars;

        }

        public function bind($js)
        {
            $this->newJavaScript =  '<script>' . $js . '</script>';
        }



    }