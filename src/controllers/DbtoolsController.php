<?php namespace Slave\Dbtools;

use Controller;

class DbtoolsController extends Controller {

     /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    
    public function getFoofunction()
    {
        echo 'this';
        // Validator::validate();
    } 
    public function missingMethod($parameters = array())
    {
        echo 'No method found';
        return;
    }
}