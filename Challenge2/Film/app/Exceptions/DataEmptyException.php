<?php 
namespace App\Exceptions;

/**
* 
*/
class DataEmptyException extends \Exception
{	
	public function responseJson()
	{
		return \Response::json(
	        [
	            'data' => [
	                'message' => 'Error Found.', 
	                'status_code' => 404,
	                'error' => (!empty($this->message)) ? $this->message : 'Data Not Found'
	            ]
	        ], 
	    404);
	}
}
