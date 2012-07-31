<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller
{
	// extends CI_Controller for CI 2.x users
	protected $data = array();
	
	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Events.Reports.View');
		$this->load->model('events_model', null, true);
		$this->lang->load('events');
		$this->load->helper('security');
		
		Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_module_css('events','events.css');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');
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
		$this->auth->restrict('Events.Reports.View');
		Template::redirect(SITE_AREA.'/reports/events/manage');
	}
	
	public function create() {
		
		$this->auth->restrict('events.Reports.Create');
		
		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_events())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('events_act_create_events'). ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'events');

				Template::set_message(lang('event_create_success'), 'success');
				Template::redirect(SITE_AREA .'/reports/events/manage');
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
		$this->auth->restrict('events.Reports.Edit');
		$entry_id = xss_clean($this->uri->segment(5));

		$query = $this->events_model->find_event($entry_id);
		if ($query->num_rows() == 0) {
			Template::set_message(lang('events_edit_start_failure') . '<br>Entry does not exist','error');
			Template::redirect(SITE_AREA.'/reports/events/manage');
		}
		
		$query = $query->first_row('array');
		$start_time_d = date('j',$query['start_time']);
		$start_time_m = date('n',$query['start_time']);
		$start_time_h = date('h',$query['start_time']);
		$start_time_y = date('Y',$query['start_time']);
		$start_time_i = date('i',$query['start_time']);
		
		$end_time_d = date('j',$query['end_time']);
		$end_time_m = date('n',$query['end_time']);
		$end_time_h = date('h',$query['end_time']);
		$end_time_y = date('Y',$query['end_time']);
		$end_time_i = date('i',$query['end_time']);
		
		$form_data = array(
			'event_name' => $query['title'],
			'ck_content' => $query['content'],
			'event_start_d' => $start_time_d,
			'event_start_m' => $start_time_m,
			'event_start_h' => $start_time_h,
			'event_start_y' => $start_time_y,
			'event_start_i' => $start_time_i,
			'event_end_d' => $end_time_d,
			'event_end_m' => $end_time_m,
			'event_end_h' => $end_time_h,
			'event_end_y' => $end_time_y,
			'event_end_i' => $end_time_i,
			'event_location' => $query['location'],
		);
		//debug_r($form_data);die();
		Template::set('form_data',$form_data);
		
		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_events('update',$entry_id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('events_act_edit_events'). ': ' . $entry_id . ' : ' . $this->input->ip_address(), 'events');

				Template::set_message(lang('events_edit_success'), 'success');
				Template::redirect(SITE_AREA .'/reports/events/manage');
			}
			else
			{
				Template::set_message(lang('events_edit_failure') . $this->events_model->error, 'error');
			}
		}	
		
		Assets::add_module_js('events', 'events.js');
		
		$this->ckeditor_setting();
		Template::set('ckeditor_data', $this->data);
		Template::set_view('reports/create');
		Template::render();
		
	}
	
	public function manage() {
		
		$this->auth->restrict('events.Reports.Edit');
		$this->auth->restrict('events.Reports.Delete');
		
		if ($action = $this->input->post('delete')) {
			if ($action == 'Delete')
			{
				$checked = $this->input->post('checked');

				if (is_array($checked) && count($checked))
				{
					$result = FALSE;
					foreach ($checked as $event_id)
					{
						$result = $this->events_model->delete_event($event_id);
					}

					if ($result != 0)
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
					Template::set_message(lang('events_delete_error') . ' You have not checked any box', 'error');
				}
			}
		}
		
		$this->load->library('pagination');
		$query = $this->events_model->find_all_events();
	
		$pagination_config = array(
			'uri_segment' => 5,
			'per_page' => 10, 
			'num_links' => 10,
			'base_url' => site_url(SITE_AREA. '/content/events/manage'),
			'total_rows' => $query->num_rows(),
		);
		
		$this->pagination->initialize($pagination_config);
		$query = $this->events_model->find_all_events($pagination_config['per_page'], xss_clean($this->uri->segment(5)))->result_array();
		
		$users_list = array();
		foreach ($query as $id => $val){
			$users_list[$val['event_id']] = $this->events_model->find_all_users_by_event($val['event_id']);
		}
		
		Template::set('events_list',$query);
		Template::set('users_list',$users_list);
		Assets::add_module_js('events', 'events.js');
		Template::set('toolbar_title', 'View events');
		Template::render();
	}
	
	public function records() {
		$event_id = (int)$this->uri->segment(5);
		if ($event_id > 0) {
			$list = $this->events_model->find_all_users_by_event($event_id);
			$event = $this->events_model->find_event($event_id);
		} else {
			die('ID not correct');
		}
		
		if (($list->num_rows() == 0) || ($event->num_rows() == 0)) {
			die('No result found');
		}
		$event = $event->first_row('array');
		$this->load->helper('exporter');
		csvRequest($list,'members_record_of_event_'.$event['title'].'_as_'.date('d-m-Y').'.csv');
		die();
	}
	
	public function approve() {
		
		Template::render();
	}
	
	private function save_events($type='insert',$id=0) {
		if ($type=='update') {
			$_POST['id'] = $id; 
		}
		
		$this->form_validation->set_rules('event_name', 'Title','required|xss_clean|trim|max_length[100]|min_length[1]');
		$this->form_validation->set_rules('ck_content','Content','required');
		$this->form_validation->set_rules('event_start_y', 'Start Time (year)', 'required|numeric|trim|max_length[4]');
		$this->form_validation->set_rules('event_start_m', 'Start Time (month)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_start_d', 'Start Time (day)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_start_h', 'Start Time (hour)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_start_i', 'Start Time (minute)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_end_y', 'End Time (year)', 'required|numeric|trim|max_length[4]');
		$this->form_validation->set_rules('event_end_m', 'End Time (month)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_end_d', 'End Time (day)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_end_h', 'End Time (hour)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_end_i', 'End Time (minute)', 'required|numeric|trim|max_length[2]');
		$this->form_validation->set_rules('event_location', 'Location', 'required|xss_clean|max_length[255]');
		

		$start_time = mktime(
				(int)$this->input->post('event_start_h'),
				(int)$this->input->post('event_start_i'),
				0,(int)$this->input->post('event_start_m'),
				(int)$this->input->post('event_start_d'),
				(int)$this->input->post('event_start_y')
				);
				
		$end_time = mktime(
				(int)$this->input->post('event_end_h'),
				(int)$this->input->post('event_end_i'),
				0,(int)$this->input->post('event_end_m'),
				(int)$this->input->post('event_end_d'),
				(int)$this->input->post('event_end_y')
				);
		
		if ($this->form_validation->run() === FALSE || $start_time === FALSE || $end_time === FALSE || $start_time >= $end_time) {
			$form_data = array(
				'event_name' => xss_clean($this->input->post('event_name')),
				'ck_content' => xss_clean($this->input->post('ck_content')),
				'event_location' => xss_clean($this->input->post('event_location')),
				'event_start_h' => $this->input->post('event_start_h'),
				'event_start_i' => $this->input->post('event_start_i'),
				'event_start_m' => $this->input->post('event_start_m'),
				'event_start_d' => $this->input->post('event_start_d'),
				'event_start_y' => $this->input->post('event_start_y'),
				'event_end_h' => $this->input->post('event_end_h'),
				'event_end_i' => $this->input->post('event_end_i'),
				'event_end_m' => $this->input->post('event_end_m'),
				'event_end_d' => $this->input->post('event_end_d'),
				'event_end_y' => $this->input->post('event_end_y'),
			);
			
			Template::set('form_data',$form_data);
			return false;
		}
		
		// make sure we only pass in the fields we want
		$data = array();
		$data['title'] = $this->input->post('event_name');
		$data['content'] = $this->input->post('ck_content');
		$data['created_by'] = $this->auth->user_id();
		$data['created_at'] = time();
		$data['start_time'] = $start_time;
		$data['end_time'] = $end_time;
		$data['location'] = $this->input->post('event_location');
		
		if ($type=='insert') {
			$result = $this->events_model->insert_event($data);
			if ($result['affected_rows'] > 0) {
				return $result['insert_id'];
			} else {
				return FALSE;
			}
		} else {
			return $this->events_model->update_event($id,$data)==0?FALSE:TRUE;
		}
	}
}