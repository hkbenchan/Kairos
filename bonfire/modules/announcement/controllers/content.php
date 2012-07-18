<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller
{
	// extends CI_Controller for CI 2.x users
	protected $data = array();
	
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Announcement.Content.View');
		$this->load->model('announcement_model', null, true);
		$this->lang->load('announcement');
		$this->load->helper('security');
		
		Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'content/_sub_nav');
	}
	
	private function ckeditor_setting() {
		//parent::Controller();
		//parent::__construct(); //for CI 2.x users
		$this->load->helper('ckeditor');
		
		//Ckeditor's configuration
		$this->data['ckeditor'] = array(
			
			//ID of the textarea that will be replaced
			'id' 	=> 	'ck_content',
			'path'	=>	'assets/js/ckeditor',
			//Optionnal values
			'config' => array(
				'toolbar' 	=> 	"Full", 	//Using the Full toolbar
				'width' 	=> 	"800px",	//Setting a custom width
				'height' 	=> 	'500px',	//Setting a custom height
			),
			/*
			//Replacing styles from the "Styles tool"
			'styles' => array(
				//Creating a new style named "style 1"
				'style 1' => array (
					'name' 		=> 	'Blue Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 	=> 	'Blue',
						'font-weight' 	=> 	'bold'
					)
				),
				//Creating a new style named "style 2"
				'style 2' => array (
					'name' 	=> 	'Red Title',
					'element' 	=> 	'h2',
					'styles' => array(
						'color' 		=> 	'Red',
						'font-weight' 		=> 	'bold',
						'text-decoration'	=> 	'underline'
					)
				)
			)*/
		);
	}
	
	public function index() {
		
		// get all announcements and prepare pagination (30 per-page)
		
		$this->load->library('pagination');
		$query = $this->announcement_model->find_all();
	
		$pagination_config = array(
			//'uri_segment' => 4,
			'per_page' => 2, 
			'num_links' => 10,
			'base_url' => site_url(SITE_AREA. '/content/announcement/index'),
			'total_rows' => $query->num_rows(),
		);
		
		$this->pagination->initialize($pagination_config);
		$query = $this->announcement_model->find_all($pagination_config['per_page'], xss_clean($this->uri->segment(5)))->result_array();
		
		Template::set('announcement_list',$query);
		Template::set('toolbar_title', 'View Announcement');
		Template::render();
	}
	
	public function create() {
		
		$this->ckeditor_setting();
		Template::set('ckeditor_data', $this->data);
		
		Template::render();
	}
}


