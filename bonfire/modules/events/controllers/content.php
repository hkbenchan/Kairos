<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller
{	
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
		
		$query2 = $this->events_model->find_user_join($this->auth->user_id())->result_array();
		
		Template::set('events_list',$query);
		Template::set('user_events_list',$query2);
		Template::set('toolbar_title', 'View events');
		Template::render();
	}
	
	public function join() {
		
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
							$this->activity_model->log_activity($this->current_user->id, ' joins event with event id: '. ': ' . $event_id . ' : ' . $this->input->ip_address(), 'events');
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
	
	public function delete() {
		
		if ($this->input->post('delete')) {
			if ($checked = $this->input->post('self_checked')) {
				$deleted_count = 0;
				foreach($checked as $id) {
					if ($this->events_model->delete_user_event($this->auth->user_id(),$id) == 0) {
						//fail
					} else {
						$deleted_count++;
						//log the activity
						$this->activity_model->log_activity($this->current_user->id, ' delete the event with event id: : ' . $id . ' : ' . $this->input->ip_address(), 'events');
					}
				}
				
				if ($deleted_count == 0) {
				} else {
					Template::set_message($deleted_count . ' event(s) deleted.','success');
				}
			} else {
				Template::set_message('You must select at least one event to delete.','error');
			}
		}
		Template::redirect(SITE_AREA.'/content/events/');
	}
}


