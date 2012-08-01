<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_keeper {

	/**
	 * Stores the CodeIgniter core object.
	 *
	 * @access private
	 * @static
	 *
	 * @var object
	 */
	private static $ci;


	/**
	 * Stores the data object.
	 *
	 * @access private
	 * @static
	 *
	 * @var array
	 */
	private static $data_master;
	
	public function __construct() {
		
		self::$ci =& get_instance();
		self::$ci->load->library('session');
		
		if (self::$data_master = self::$ci->session->userdata('data_master')){
		} else {
			self::$data_master = array();
		}
	}
	
	/**
	 * 
	 *
	 *
	 *
	 */
	
	public function set_data($key,$data_need_to_save,$override = FALSE){
		if (isset(self::$data_master[$key]) && !($override)) {
			return false;
		} else {
			self::$data_master[$key] = $data_need_to_save;
			self::$ci->session->set_userdata('data_master',self::$data_master);
			return true;
		}
	}
	
	public function get_data($key){
		if (isset(self::$data_master[$key])) {
			return self::$data_master[$key];
		} else {
			return null;
		}
	}
	
	public function clear_data($key){
		if (isset(self::$data_master[$key])) {
			unset(self::$data_master[$key]);
			self::$ci->session->set_userdata('data_master',self::$data_master);
		}
	}

}