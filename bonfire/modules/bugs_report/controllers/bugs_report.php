<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class bugs_report extends Front_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('bugs_report_model', null, true);
		$this->lang->load('bugs_report');
		
			Assets::add_js(Template::theme_url('js/editors/ckeditor/ckeditor.js'));
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		$records = $this->bugs_report_model->find_all();

		Template::set('records', $records);
		Template::render();
	}

	//--------------------------------------------------------------------




}