<?php namespace Slave\Dbtools;

use Controller;
use Input;
use Validpack;
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
    public function getCreate($model){
        $data = Input::except('token');
        var_dump($data);
        Validpack::createview();


    }
    public function missingMethod($parameters = array())
    {
        echo 'No method found';
        return;
    }
}