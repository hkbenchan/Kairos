<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller
{
	// extends CI_Controller for CI 2.x users
	protected $data = array();
	
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Events.Content.View');
		$this->load->model('events_model', null, true);
		$this->lang->load('events');
		$this->load->helper('security');
		
		Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_module_css('events','events.css');
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
		
		// get all events and prepare pagination (30 per-page)
		
		$this->load->library('pagination');
		$query = $this->events_model->find_all_events();
	
		$pagination_config = array(
			'uri_segment' => 5,
			'per_page' => 10, 
			'num_links' => 10,
			'base_url' => site_url(SITE_AREA. '/content/events/index'),
			'total_rows' => $query->num_rows(),
		);
		
		$this->pagination->initialize($pagination_config);
		$query = $this->events_model->find_all_events($pagination_config['per_page'], xss_clean($this->uri->segment(5)))->result_array();
		
		Template::set('events_list',$query);
		Template::set('toolbar_title', 'View events');
		Template::render();
	}
	
	public function join() {
		$this->auth->restrict('events.Content.View');
		
		if ($this->input->post('join')) {
			// recall all events and display and ask once again
			if ($checked = $this->input->post('checked')) {
				$events = array();
				foreach($checked as $id) {
					$tmp = $this->events_model->find_event($id);
					if ($tmp->num_rows()>0) {
						$events[] = $tmp->first_row('array');
					}
				}
				if (count($events) == 0) {
					Template::set_message('No event found.','error');
					Template::redirect(SITE_AREA.'/content/events/');
				}
				Template::set('events',$events);
			} else {
				Template::set_message('Please select at least one event.','error');
				Template::redirect(SITE_AREA.'/content/events/');
			}
		} elseif ($this->input->post('confirm')) {
			//get all events id
			if ($id = xss_clean($this->input->post('ids'))) {
				$joined = 0;
				$data = array(
					'uid' => $this->auth->user_id(),
					'status' => 'Requested'
				);
				foreach($id as $event_id) {
					if ($this->events_model->find_event($event_id)->num_rows() > 0) {
						$data['event_id'] = $event_id;
						$result = $this->events_model->insert_user_events($data);
						if ($result['affected_rows']>0) {
							//log the activity
							
							$joined++;
						}
					}
				}//end foreach
				
				if ($joined > 0) {
					Template::set_message('Event(s) joined.','success');
					Template::redirect(SITE_AREA.'/content/events/');
				} else {
					Template::set_message(lang('events_join_failure'), 'error');
					Template::redirect(SITE_AREA.'/content/events/');
				}
			}
		}
		
		Template::set('toolbar_title','Confirm Events');
		Template::render();
	}
	
	public function create() {
		
		$this->auth->restrict('events.Content.Create');
		
		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_events())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('events_act_create_events'). ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'events');

				Template::set_message(lang('annoncement_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/events');
			}
			else
			{
				Template::set_message(lang('events_create_failure') . $this->events_model->error, 'error');
			}
		}	
		
		Assets::add_module_js('events', 'events.js');
		
		$this->ckeditor_setting();
		Template::set('ckeditor_data', $this->data);
		
		Template::render();
	}
	
	public function edit() {
		$this->auth->restrict('events.Content.Edit');
		$entry_id = xss_clean($this->uri->segment(5));

		$query = $this->events_model->find($entry_id);
		if ($query->num_rows() == 0) {
			Template::set_message(lang('events_edit_start_failure') . '<br>Entry does not exist','error');
			Template::redirect(SITE_AREA.'/content/events/manage');
		}
		
		$query = $query->result_array();
		$form_data = array(
			'events_title' => $query['0']['title'],
			'ck_content' => $query['0']['content'],
		);
		Template::set('form_data',$form_data);
		
		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_events('update',$entry_id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('events_act_edit_events'). ': ' . $entry_id . ' : ' . $this->input->ip_address(), 'events');

				Template::set_message(lang('annoncement_edit_success'), 'success');
				Template::redirect(SITE_AREA .'/content/events/manage');
			}
			else
			{
				Template::set_message(lang('events_edit_failure') . $this->events_model->error, 'error');
			}
		}	
		
		Assets::add_module_js('events', 'events.js');
		
		$this->ckeditor_setting();
		Template::set('ckeditor_data', $this->data);
		Template::set_view('content/create');
		Template::render();
		
	}
	
	public function manage() {
		
		$this->auth->restrict('events.Content.Edit');
		$this->auth->restrict('events.Content.Delete');
		
		if ($action = $this->input->post('delete')) {
			if ($action == 'Delete')
			{
				$checked = $this->input->post('checked');

				if (is_array($checked) && count($checked))
				{
					$result = FALSE;
					foreach ($checked as $entry_id)
					{
						$result = $this->events_model->delete($entry_id);
					}

					if ($result)
					{
						Template::set_message(count($checked) .' '. lang('events_delete_success'), 'success');
					}
					else
					{
						Template::set_message(lang('events_delete_failure') . $this->events_model->error, 'error');
					}
				}
				else
				{
					Template::set_message(lang('events_delete_error') . $this->events_model->error, 'error');
				}
			}
		}
		
		$this->load->library('pagination');
		$query = $this->events_model->find_all();
	
		$pagination_config = array(
			'uri_segment' => 5,
			'per_page' => 10, 
			'num_links' => 10,
			'base_url' => site_url(SITE_AREA. '/content/events/index'),
			'total_rows' => $query->num_rows(),
		);
		
		$this->pagination->initialize($pagination_config);
		$query = $this->events_model->find_all($pagination_config['per_page'], xss_clean($this->uri->segment(5)))->result_array();
		
		Template::set('events_list',$query);
		Assets::add_module_js('events', 'events.js');
		Template::set('toolbar_title', 'View events');
		Template::render();
	}
	
	private function save_events($type='insert',$id=0) {
		if ($type=='update') {
			$_POST['id'] = $id; 
		}
		
		$this->form_validation->set_rules('events_title', 'Title','required|xss_clean|trim|max_length[100]|min_length[1]');
		$this->form_validation->set_rules('ck_content','Content','required');
		
		if ($this->form_validation->run() === FALSE) {
			$form_data = array(
				'events_title' => xss_clean($this->input->post('events_title')),
				'ck_content' => xss_clean($this->input->post('ck_content')),
			);
			
			Template::set('form_data',$form_data);
			return false;
		}
		
		// make sure we only pass in the fields we want
		$data = array();
		$data['title'] = $this->input->post('events_title');
		$data['content'] = $this->input->post('ck_content');
		$data['created_by'] = $this->auth->user_id();
		$data['created_at'] = time();
		
		if ($type=='insert') {
			$result = $this->events_model->insert($data);
			if ($result['affected_rows'] > 0) {
				return $result['insert_id'];
			} else {
				return FALSE;
			}
		} else {
			return $this->events_model->update($id,$data)==0?FALSE:TRUE;
		}
	}
}


