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
			'uri_segment' => 5,
			'per_page' => 10, 
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
		
		$this->auth->restrict('Announcement.Content.Create');
		
		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_announcement())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('announcement_act_create_announcement'). ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'announcement');

				Template::set_message(lang('annoncement_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/announcement');
			}
			else
			{
				Template::set_message(lang('announcement_create_failure') . $this->announcement_model->error, 'error');
			}
		}	
		
		Assets::add_module_js('announcement', 'announcement.js');
		
		$this->ckeditor_setting();
		Template::set('ckeditor_data', $this->data);
		
		Template::render();
	}
	
	public function edit() {
		$this->auth->restrict('Announcement.Content.Edit');
		$entry_id = xss_clean($this->uri->segment(5));

		$query = $this->announcement_model->find($entry_id);
		if ($query->num_rows() == 0) {
			Template::set_message(lang('announcement_edit_start_failure') . '<br>Entry does not exist','error');
			Template::redirect(SITE_AREA.'/content/announcement/manage');
		}
		
		$query = $query->result_array();
		$form_data = array(
			'announcement_title' => $query['0']['title'],
			'ck_content' => $query['0']['content'],
		);
		Template::set('form_data',$form_data);
		
		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_announcement('update',$entry_id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('announcement_act_edit_announcement'). ': ' . $entry_id . ' : ' . $this->input->ip_address(), 'announcement');

				Template::set_message(lang('annoncement_edit_success'), 'success');
				Template::redirect(SITE_AREA .'/content/announcement/manage');
			}
			else
			{
				Template::set_message(lang('announcement_edit_failure') . $this->announcement_model->error, 'error');
			}
		}	
		
		Assets::add_module_js('announcement', 'announcement.js');
		
		$this->ckeditor_setting();
		Template::set('ckeditor_data', $this->data);
		Template::set_view('content/create');
		Template::render();
		
	}
	
	public function manage() {
		
		$this->auth->restrict('Announcement.Content.Edit');
		$this->auth->restrict('Announcement.Content.Delete');
		
		if ($action = $this->input->post('delete')) {
			if ($action == 'Delete')
			{
				$checked = $this->input->post('checked');

				if (is_array($checked) && count($checked))
				{
					$result = FALSE;
					foreach ($checked as $entry_id)
					{
						$result = $this->announcement_model->delete($entry_id);
					}

					if ($result)
					{
						Template::set_message(count($checked) .' '. lang('announcement_delete_success'), 'success');
					}
					else
					{
						Template::set_message(lang('announcement_delete_failure') . $this->announcement_model->error, 'error');
					}
				}
				else
				{
					Template::set_message(lang('announcement_delete_error') . $this->announcement_model->error, 'error');
				}
			}
		}
		
		$this->load->library('pagination');
		$query = $this->announcement_model->find_all();
	
		$pagination_config = array(
			'uri_segment' => 5,
			'per_page' => 10, 
			'num_links' => 10,
			'base_url' => site_url(SITE_AREA. '/content/announcement/index'),
			'total_rows' => $query->num_rows(),
		);
		
		$this->pagination->initialize($pagination_config);
		$query = $this->announcement_model->find_all($pagination_config['per_page'], xss_clean($this->uri->segment(5)))->result_array();
		
		Template::set('announcement_list',$query);
		Assets::add_module_js('announcement', 'announcement.js');
		Template::set('toolbar_title', 'View Announcement');
		Template::render();
	}
	
	private function save_announcement($type='insert',$id=0) {
		if ($type=='update') {
			$_POST['id'] = $id; 
		}
		
		$this->form_validation->set_rules('announcement_title', 'Title','required|xss_clean|trim|max_length[100]|min_length[1]');
		$this->form_validation->set_rules('ck_content','Content','required');
		
		if ($this->form_validation->run() === FALSE) {
			$form_data = array(
				'announcement_title' => xss_clean($this->input->post('announcement_title')),
				'ck_content' => xss_clean($this->input->post('ck_content')),
			);
			
			Template::set('form_data',$form_data);
			return false;
		}
		
		// make sure we only pass in the fields we want
		$data = array();
		$data['title'] = $this->input->post('announcement_title');
		$data['content'] = $this->input->post('ck_content');
		$data['created_by'] = $this->auth->user_id();
		$data['created_at'] = time();
		
		if ($type=='insert') {
			$result = $this->announcement_model->insert($data);
			if ($result['affected_rows'] > 0) {
				return $result['insert_id'];
			} else {
				return FALSE;
			}
		} else {
			return $this->announcement_model->update($id,$data)==0?FALSE:TRUE;
		}
	}
}


