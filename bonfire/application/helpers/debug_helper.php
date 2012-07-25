<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('debug_r')){
	
	function debug_r($array = 0){
		echo '<pre>'.print_r($array,true).'</pre>';
	}
	
}