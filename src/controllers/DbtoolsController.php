<?php namespace Slave\Dbtools;

use Controller;
use Input;
use Validpack;
use Hash;
use View;
use Response;

class DbtoolsController extends Controller {

     /**
     * Basic Controller API
     * methods supported
     *
     * Post - /pathToController/create/model
     * Post - /pathToController/update/model/id/#tablekey
     * Post - /pathToController/delete/model/id/#tablekey
     * Get  - /pathToController/return/model/#id/#tablekey
     * #url parameters that contain hashtags are optional
     * All methods must input the data array that corresponds to the table data
     * If no id is given on return urls, all results paginated 15 will be returned
     * can choose page with @page url parameter
     * can choose sorting with @sort url parameter
     * 
     *  Http answer codes : 
     *  #database-1 Succesful data instert
     *  #database-2 Data not validated
     *  #database-3 Unknown input error, throws exception
     *  #database-4 User not found
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
        echo Dbtools::asdf();
    }
    public function postCreate($model){
        return  Dbtools::createFromModel($model, $table);
    }
    public function postDelete($model , $id, $tablekey = null ){
        $key = $tablekey==null?'id':$tablekey;
        return Dbtools::deleteFromModel($model, $id, $key);
    }
    public function postUpdate($model , $id, $tablekey = null ){
        $key = $tablekey==null?'id':$tablekey;
        return Dbtools::updateFromModel($model, $id, $key);
    }
    public function missingMethod($parameters = array()){
        echo 'No method found';
        return;
    }
    public function getReturn($model, $id =null, $tablekey = null){
        $key = $tablekey==null?'id':$tablekey;
        if($id!=null){
            $answer = $model::where($key , '=' , $id)->first();
        }else{
            $answer = $model::paginate(15);
        }
        return $answer;
    }
}