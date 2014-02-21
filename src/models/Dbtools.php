<?php namespace Slave\Dbtools;
use DB;
use Input;
use Validpack;
use Hash;
use Auth;
use Redirect;
use Illuminate\Database\Eloquent\Model;

class Dbtools extends Model {

    public static function exists($model, $id, $tablekey){
        $counter = $model::where($tablekey , '=' , $id)->count();
        return $counter>0;
    }

	public static function createFromModel($model , $arrayOfAttributes = null){
        if($arrayOfAttributes==null)
		  $input = Input::except('_token');
        else
            $input = Input::get($arrayOfAttributes);

        $inputData = new $model();
        try{
            foreach ($input as $key => $value)
                    $inputData->$key = $value;

            $flag = Validpack::validateoperation($inputData);
            if($flag->passes()){
                foreach ($inputData->attributes as $key => $value)
                    if($key == "password")
                        $inputData->$key = Hash::make($value);
                $inputData->save();
                $message = 'Succesful data insert!';
                return $message;
            }else{
                $message = 'Data Validation error!';
                return $message;
            }
        }catch(Exception $e){
            echo 'Caught exception: '.  $e->getMessage(). "\n";
        }
	}
	public static function deleteFromModel($model, $id, $tablekey){
		try{
			if(!Dbtools::exists($model, $id, $tablekey)){
                $message = 'Record with id '.$id.' not found in model' . $model. " delete aborted.";
                return $message;
            }
				
			else if($tablekey!='id'){
				$model::where($tablekey , '=' , $id)->delete();
				return "Succesful data delete!";
			}else{
				$model::find($id)->delete();
				return "Succesful data delete!";
			}
		}catch(Exception $e){
			echo 'Caught exception: '.  $e->getMessage(). "\n";	
		}
	}
	public static function updateFromModel($model , $id , $tablekey , $arrayOfAttributes = null){
        if($arrayOfAttributes==null)
          $input = Input::except('_token' , 'rnewpassword' , 'newpassword');
        else
            $input = Input::get($arrayOfAttributes);

        
        $inputData = $model::where($tablekey, '=' , $id)->first();
        try{
            if(!Dbtools::exists($model, $id, $tablekey)){
                $message = 'Something went wrong, record of '.$model.' not found!';
                return $message;
            }
                
            foreach ($input as $key => $value){
                if($key == "password" && Input::get('newpassword')!="")
                    $inputData->$key = Input::get('newpassword');
                else if($value!="" && $key != "password")
                    $inputData->$key = $value;
            }
            $flag = Validpack::validateoperation($inputData);
            if($flag->passes()){
                foreach ($inputData->attributes as $key => $value)
                    if($key == "password" && strlen(Input::get('newpassword'))>2)
                        $inputData->$key = Hash::make(Input::get('newpassword'));
                $inputData->save();
                $message = 'Succesful ' .$model. " record update!";
                return $message;

            }else{
                $message = 'Data for  ' . $model. " not valid!";
                return $message;
            }
        }catch(Exception $e){
            echo 'Caught exception: '.  $e->getMessage(). "\n";
        }
	}
	
    public static function returnData($model, $id, $singleRecord){
        if($singleRecord==true){
            $data = $model::find($id);
            echo $data;
        }
    }
	

}