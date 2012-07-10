<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_display {

	/* 
		$name store the sequence of the data that want to display
		$data the array that contains the data
		
		url_index: { row => { header_id => url } }
	*/
	
	public function set_sequence($name,$data, $url_index = array())
	{
		$result_array = array(
			'header' => $name,
			'data' => $data,
			'url' => $url_index,
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