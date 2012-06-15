<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class kairosmemberinfo extends Front_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('kairosmemberinfo_model', null, true);
		$this->lang->load('kairosmemberinfo');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{
		/* find_by($field='', $value='', $type='and') */
		$field = 'uid';
		$value = user_id();
		$records = $this->kairosmemberinfo_model->find_by($field, $value);

		Template::set('records', $records);
		Template::render();
	}

	//--------------------------------------------------------------------




}