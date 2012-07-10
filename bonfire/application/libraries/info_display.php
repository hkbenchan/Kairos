<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Info_display {

	/* 
		$name store the sequence of the data that want to display
		$data the array that contains the data
		
		url_index: { header_id => { static_url + variable(get from data) }  }
	*/
	
	public function set_sequence($name,$data, $url_index = array())
	{
		$result_array = array(
			'header' => $name,
			'data' => $data,
			'url' => array(),
		);
		
		/*foreach ($name as $display => $data_ref)
		{
			$result_array['header'][] = $display;
		}
		*/
		foreach ($url_index as $header_id => $a){
			$url = $a['url'];
			$var = $a['variable'];
			$result_array['url'][$header_id] = array( 'url' => $url, 'var' => $var) ;
		}
		echo '<pre>' . print_r($result_array,TRUE) . '</pre>';
		
		//die();
		
		// return combined array
		return $result_array;
	}
}