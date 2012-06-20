<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class settings extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Bugs_report.Settings.View');
		$this->load->model('bugs_report_model', null, true);
		$this->lang->load('bugs_report');
		
			Assets::add_js(Template::theme_url('js/editors/ckeditor/ckeditor.js'));
		Template::set_block('sub_nav', 'settings/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{

		// Deleting anything?
		if ($action = $this->input->post('delete'))
		{
			if ($action == 'Delete')
			{
				$checked = $this->input->post('checked');

				if (is_array($checked) && count($checked))
				{
					$result = FALSE;
					foreach ($checked as $pid)
					{
						$result = $this->bugs_report_model->delete($pid);
					}

					if ($result)
					{
						Template::set_message(count($checked) .' '. lang('bugs_report_delete_success'), 'success');
					}
					else
					{
						Template::set_message(lang('bugs_report_delete_failure') . $this->bugs_report_model->error, 'error');
					}
				}
				else
				{
					Template::set_message(lang('bugs_report_delete_error') . $this->bugs_report_model->error, 'error');
				}
			}
		}

		$records = $this->bugs_report_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Bugs report');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a Bugs report object.
	*/
	public function create()
	{
		$this->auth->restrict('Bugs_report.Settings.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_bugs_report())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('bugs_report_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'bugs_report');

				Template::set_message(lang('bugs_report_create_success'), 'success');
				Template::redirect(SITE_AREA .'/settings/bugs_report');
			}
			else
			{
				Template::set_message(lang('bugs_report_create_failure') . $this->bugs_report_model->error, 'error');
			}
		}
		Assets::add_module_js('bugs_report', 'bugs_report.js');

		Template::set('toolbar_title', lang('bugs_report_create') . ' Bugs report');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of Bugs report data.
	*/
	public function edit()
	{
		$this->auth->restrict('Bugs_report.Settings.Edit');

		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('bugs_report_invalid_id'), 'error');
			redirect(SITE_AREA .'/settings/bugs_report');
		}

		if ($this->input->post('submit'))
		{
			if ($this->save_bugs_report('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('bugs_report_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'bugs_report');

				Template::set_message(lang('bugs_report_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('bugs_report_edit_failure') . $this->bugs_report_model->error, 'error');
			}
		}

		Template::set('bugs_report', $this->bugs_report_model->find($id));
		Assets::add_module_js('bugs_report', 'bugs_report.js');

		Template::set('toolbar_title', lang('bugs_report_edit') . ' Bugs report');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: delete()

		Allows deleting of Bugs report data.
	*/
	public function delete()
	{
		$this->auth->restrict('Bugs_report.Settings.Delete');

		$id = $this->uri->segment(5);

		if (!empty($id))
		{

			if ($this->bugs_report_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('bugs_report_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'bugs_report');

				Template::set_message(lang('bugs_report_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('bugs_report_delete_failure') . $this->bugs_report_model->error, 'error');
			}
		}

		redirect(SITE_AREA .'/settings/bugs_report');
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_bugs_report()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_bugs_report($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['bug_id'] = $id;
		}

		
		$this->form_validation->set_rules('bugs_report_bug_type','Type - e.g. UI or php error','required|trim|max_length[30]');
		$this->form_validation->set_rules('bugs_report_URL','URL','unique[bf_bugs_report.bugs_report_URL,bf_bugs_report.bug_id]|trim|max_length[255]');
		$this->form_validation->set_rules('bugs_report_descr','Description - e.g. procedures on reproducing the bug and your platform','required|trim|xss_clean');
		$this->form_validation->set_rules('bugs_report_Status','Status','max_length[1]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['bugs_report_bug_type']        = $this->input->post('bugs_report_bug_type');
		$data['bugs_report_URL']        = $this->input->post('bugs_report_URL');
		$data['bugs_report_descr']        = $this->input->post('bugs_report_descr');
		$data['bugs_report_Status']        = $this->input->post('bugs_report_Status');

		if ($type == 'insert')
		{
			$id = $this->bugs_report_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->bugs_report_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}