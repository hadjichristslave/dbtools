<?php namespace Slave\Dbtools;

use Controller;
use Input;
use Validpack;
use Hash;
class DbtoolsController extends Controller {

     /**
     * Basic Controller API
     * methods supported
     *
     * Post - /pathToController/create/model/table/passwordfield
     * Post - /pathToController/update/model/id/#tablekey
     * Post - /pathToController/delete/model/id/#tablekey
     *
     * #url parameters that contain hashtags are optional
     * All methods must input the data array that corresponds to the table data
     * 
     *  Http answer codes : 
     *  #database-1 Succesful data instert
     *  #database-2 Data not validated
     *  #database-3 Unknown input error, throws exception
     *  #database-4
     *  #database-5
     *
     *
     * @return void
     */

    public function __construct(){
        $this->beforeFilter('csrf', array('on' => 'post'));
        //$this->beforeFilter('auth');
    }
    public function getFoofunction(){
        echo 'this';
    }
    public function postCreate($model , $table){
        $input = Input::except('_token');
        $inputData = new $model();
        try{
            foreach ($input as $key => $value)
                    $inputData->$key = $value;

            $flag = Validpack::validateoperation($inputData);
            if($flag->passes()){
                $inputData->save();
                foreach ($inputData as $key => $value)
                    if($key == "password")
                        $inputData->key = Hash::make($value);
                return "database-" ."1";
            }else{
                return "database-" ."2";
            }
        }catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n"
;            return "database-" ."3";
        }

       
    }
    public function missingMethod($parameters = array()){
        echo 'No method found';
        return;
    }
}