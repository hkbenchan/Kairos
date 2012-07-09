<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_display {
	
	public function test()
	{
		phpinfo();
	}
	
	/* 
		$name store the sequence of the data that want to display
		$data the array that contains the data
	*/
	
	public function set_sequence($name,$data)
	{
		$result_array = array(
			'header' => $name,
			'data' => $data,
		);
		
		/*foreach ($name as $display => $data_ref)
		{
			$result_array['header'][] = $display;
		}
		*/
		
		echo '<pre>' . print_r($result_array,TRUE) . '</pre>';
		
		//die();
		
		// return combined array
		return $result_array;
	}
}