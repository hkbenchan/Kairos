<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('KairosMemberInfo.Content.View');
		$this->load->model('kairosmemberinfo_model', null, true);
		$this->lang->load('kairosmemberinfo');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
		Template::set_block('sub_nav', 'content/_sub_nav');
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
						$result = $this->kairosmemberinfo_model->delete($pid);
					}

					if ($result)
					{
						Template::set_message(count($checked) .' '. lang('kairosmemberinfo_delete_success'), 'success');
					}
					else
					{
						Template::set_message(lang('kairosmemberinfo_delete_failure') . $this->kairosmemberinfo_model->error, 'error');
					}
				}
				else
				{
					Template::set_message(lang('kairosmemberinfo_delete_error') . $this->kairosmemberinfo_model->error, 'error');
				}
			}
		}
		
		$records = $this->kairosmemberinfo_model->find_all();
				
		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage KairosMemberInfo');
		Template::render();
		
	}

	//--------------------------------------------------------------------



	/*
		Method: create()

		Creates a KairosMemberInfo object.
	*/
	public function create()
	{
		$this->auth->restrict('KairosMemberInfo.Content.Create');

		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_kairosmemberinfo())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('kairosmemberinfo_act_create_record').': ' . $insert_id . ' : ' . $this->input->ip_address(), 'kairosmemberinfo');

				Template::set_message(lang('kairosmemberinfo_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/kairosmemberinfo');
			}
			else
			{
				Template::set_message(lang('kairosmemberinfo_create_failure') . $this->kairosmemberinfo_model->error, 'error');
			}
		}
		Assets::add_module_js('kairosmemberinfo', 'kairosmemberinfo.js');

		Template::set('toolbar_title', lang('kairosmemberinfo_create') . ' KairosMemberInfo');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of KairosMemberInfo data.
	*/
	public function edit()
	{
		$this->auth->restrict('KairosMemberInfo.Content.Edit');

		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('kairosmemberinfo_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/kairosmemberinfo');
		}

		if ($this->input->post('submit'))
		{
			if ($this->save_kairosmemberinfo('update', $id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('kairosmemberinfo_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'kairosmemberinfo');

				Template::set_message(lang('kairosmemberinfo_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('kairosmemberinfo_edit_failure') . $this->kairosmemberinfo_model->error, 'error');
			}
		}

		Template::set('kairosmemberinfo', $this->kairosmemberinfo_model->find($id));
		Assets::add_module_js('kairosmemberinfo', 'kairosmemberinfo.js');

		Template::set('toolbar_title', lang('kairosmemberinfo_edit') . ' KairosMemberInfo');
		Template::render();
	}

	//--------------------------------------------------------------------



	/*
		Method: delete()

		Allows deleting of KairosMemberInfo data.
	*/
	public function delete()
	{
		$this->auth->restrict('KairosMemberInfo.Content.Delete');

		$id = $this->uri->segment(5);

		if (!empty($id))
		{

			if ($this->kairosmemberinfo_model->delete($id))
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('kairosmemberinfo_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'kairosmemberinfo');

				Template::set_message(lang('kairosmemberinfo_delete_success'), 'success');
			} else
			{
				Template::set_message(lang('kairosmemberinfo_delete_failure') . $this->kairosmemberinfo_model->error, 'error');
			}
		}

		redirect(SITE_AREA .'/content/kairosmemberinfo');
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/*
		Method: save_kairosmemberinfo()

		Does the actual validation and saving of form data.

		Parameters:
			$type	- Either "insert" or "update"
			$id		- The ID of the record to update. Not needed for inserts.

		Returns:
			An INT id for successful inserts. If updating, returns TRUE on success.
			Otherwise, returns FALSE.
	*/
	private function save_kairosmemberinfo($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		
		$this->form_validation->set_rules('kairosmemberinfo_surname','Surname','required|trim|xss_clean|alpha_numeric|max_length[32]');
		$this->form_validation->set_rules('kairosmemberinfo_middlename','Middle Name','trim|xss_clean|alpha_numeric|max_length[32]');
		$this->form_validation->set_rules('kairosmemberinfo_lastname','Last name','required|trim|xss_clean|alpha_numeric|max_length[32]');
		$this->form_validation->set_rules('kairosmemberinfo_dob','Date Of Birth','required|trim|xss_clean|max_length[8]');
		$this->form_validation->set_rules('kairosmemberinfo_nationality_id','Nationality','required|trim|xss_clean|max_length[10]');
		$this->form_validation->set_rules('kairosmemberinfo_gender','Gender','required|max_length[1]');
		$this->form_validation->set_rules('kairosmemberinfo_University','University','required|trim|xss_clean|max_length[255]');
		$this->form_validation->set_rules('kairosmemberinfo_yearOfStudy','Year of Study','required|trim|xss_clean|max_length[6]');
		$this->form_validation->set_rules('kairosmemberinfo_phoneNo','Contact Number','required|trim|xss_clean|max_length[14]');
		$this->form_validation->set_rules('kairosmemberinfo_newsletterUpdate','Receive Future Updates and Newsletter','required|trim|xss_clean|max_length[1]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['kairosmemberinfo_surname']        = $this->input->post('kairosmemberinfo_surname');
		$data['kairosmemberinfo_middlename']        = $this->input->post('kairosmemberinfo_middlename');
		$data['kairosmemberinfo_lastname']        = $this->input->post('kairosmemberinfo_lastname');
		$data['kairosmemberinfo_dob']        = $this->input->post('kairosmemberinfo_dob') ? $this->input->post('kairosmemberinfo_dob') : '0000-00-00';
		$data['kairosmemberinfo_nationality_id']        = $this->input->post('kairosmemberinfo_nationality_id');
		$data['kairosmemberinfo_gender']        = $this->input->post('kairosmemberinfo_gender');
		$data['kairosmemberinfo_University']        = $this->input->post('kairosmemberinfo_University');
		$data['kairosmemberinfo_yearOfStudy']        = $this->input->post('kairosmemberinfo_yearOfStudy');
		$data['kairosmemberinfo_phoneNo']        = $this->input->post('kairosmemberinfo_phoneNo');
		$data['kairosmemberinfo_newsletterUpdate']        = $this->input->post('kairosmemberinfo_newsletterUpdate');

		if ($type == 'insert')
		{
			$id = $this->kairosmemberinfo_model->insert($data);

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
			$return = $this->kairosmemberinfo_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------



}