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