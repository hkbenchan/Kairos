<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class content extends Admin_Controller {

	//--------------------------------------------------------------------


	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('KairosMemberInfo.Content.View');
		$this->load->model('kairosmemberinfo_model', null, true);
		$this->lang->load('kairosmemberinfo');
		$this->load->helper('security');
		
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
						$result = $this->kairosmemberinfo_model->delete($this->auth->user_id());
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
		
		$records = $this->kairosmemberinfo_model->find('user',$this->auth->user_id());
		

		//print_r($records->result()); die();
		if ($records != null)
			Template::set('records', $records->row_array());
		else
			Template::set('records', null);
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
				$this->activity_model->log_activity($this->current_user->id, lang('kairosmemberinfo_act_create_record'). ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'kairosmemberinfo');

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
		
		$this->getAndPassOptions();
		
		Template::render(); 
	}

	private function getAndPassOptions()
	{
		/* get the list of Country */
		$this->db->order_by('name');
		$query = $this->db->get('bf_country');
		Template::set('country_code',$query->result());
		
		
		/* get the list of University */
		$this->db->order_by('name');
		$query = $this->db->get('bf_university');
		Template::set('university_code', $query->result());
		
		/* get the list of Industry */
		$this->db->order_by('name');
		$query = $this->db->get('bf_industry');
		Template::set('industry_code', $query->result());
	}


	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of KairosMemberInfo data.
	*/
	public function edit()
	{
		$this->auth->restrict('KairosMemberInfo.Content.Edit');
		
		$id = xss_clean($this->uri->segment(5));
		$role = $this->auth->role_id();
		if (!empty($id) && ($id != $this->auth->user_id())){
			if (($role != 1) && ($role != 6))
			{
				Template::set_message(lang('kairosmemberinfo_edit_permission_error'), 'error');
				$id = $this->auth->user_id();
			};
		};
		
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
				Template::redirect(SITE_AREA .'/content/kairosmemberinfo');
			}
			else
			{
				Template::set_message(lang('kairosmemberinfo_edit_failure') . $this->kairosmemberinfo_model->error, 'error');
			}
		}
		
		//$uid = $this->auth->user_id();
		$result = $this->kairosmemberinfo_model->find('user', $id)->row_array();;
		
		// break down the dob
		$dob = explode('-',$result['kairosmemberinfo_dob']);
		
		$result['kairosmemberinfo_dob_y'] = $dob[0];
		$result['kairosmemberinfo_dob_m'] = $dob[1];
		$result['kairosmemberinfo_dob_d'] = $dob[2];
		
		Template::set('kairosmemberinfo_skills', $this->input->post('kairosmemberinfo_skills'));
		
		
		//print_r($result); die();
		Template::set('kairosmemberinfo', $result);
		Assets::add_module_js('kairosmemberinfo', 'kairosmemberinfo.js');

		Template::set('toolbar_title', lang('kairosmemberinfo_edit') . ' KairosMemberInfo');

		$this->getAndPassOptions();

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

		$id = xss_clean($this->uri->segment(5));

		if (!empty($id))
		{
			// check if the entry's owner is current user
			if ($this->kairosmemberinfo_model->authroizeDelete($id,$this->auth->user_id())) {
				if ($this->kairosmemberinfo_model->delete($id))
				{
					// Log the activity
					$this->activity_model->log_activity($this->current_user->id, lang('kairosmemberinfo_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'kairosmemberinfo');
				
					Template::set_message(lang('kairosmemberinfo_delete_success'), 'success');
					Template::redirect(SITE_AREA .'/content/kairosmemberinfo');
				} else
				{
					Template::set_message(lang('kairosmemberinfo_delete_failure') . $this->kairosmemberinfo_model->error, 'error');
				}
			}
			else {
				Template::set_message(lang('kairosmemberinfo_delete_not_auth'),'error');
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

		
		$this->form_validation->set_rules('kairosmemberinfo_firstname','First name','required|trim|xss_clean|alpha_numeric|max_length[32]');
		$this->form_validation->set_rules('kairosmemberinfo_middlename','Middle Name','trim|xss_clean|alpha_numeric|max_length[32]');
		$this->form_validation->set_rules('kairosmemberinfo_lastname','Last name','required|trim|xss_clean|alpha_numeric|max_length[32]');
		$this->form_validation->set_rules('kairosmemberinfo_dob_d','Date Of Birth','required|trim|numeric|xss_clean|max_length[2]');
		$this->form_validation->set_rules('kairosmemberinfo_dob_m','Date Of Birth','required|trim|numeric|xss_clean|max_length[2]');
		$this->form_validation->set_rules('kairosmemberinfo_dob_y','Date Of Birth','required|trim|numeric|xss_clean|max_length[4]');
		$this->form_validation->set_rules('kairosmemberinfo_gender','Gender','required|max_length[1]');
		$this->form_validation->set_rules('kairosmemberinfo_UniversityID','University/Institution','required|trim|xss_clean|max_length[255]');
		$this->form_validation->set_rules('kairosmemberinfo_phoneNo','Contact Number','required|trim|xss_clean|max_length[14]|numeric');
		$this->form_validation->set_rules('kairosmemberinfo_ownVenture','Own Venture','required|max_length[1]');
		$this->form_validation->set_rules('kairosmemberinfo_skills','Special Skills','xss_clean|max_length[100]');
		
		Template::set('kairosmemberinfo_skills', $this->input->post('kairosmemberinfo_skills'));
		
		if ($this->input->post('kairosmemberinfo_ownVenture')=='T')
		{
			$this->form_validation->set_rules('kairosmemberinfo_ventureName','Name of Venture','required|trim|xss_clean|max_length[100]|min_length[1]');
			$this->form_validation->set_rules('kairosmemberinfo_ventureDescr','Description of Venture','required|trim|xss_clean|max_length[500]|min_length[2]');
			Template::set('kairosmemberinfo_ventureDescr', $this->input->post('kairosmemberinfo_ventureDescr'));
		}
		
		$this->form_validation->set_rules('kairosmemberinfo_newsletterUpdate','Receive Future Updates and Newsletter','trim|xss_clean|max_length[1]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		if (!(checkdate($this->input->post('kairosmemberinfo_dob_m'),$this->input->post('kairosmemberinfo_dob_d'),$this->input->post('kairosmemberinfo_dob_y'))))
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['kairosmemberinfo_firstname'] = $this->input->post('kairosmemberinfo_firstname');
		$data['kairosmemberinfo_middlename'] = $this->input->post('kairosmemberinfo_middlename');
		$data['kairosmemberinfo_lastname'] = $this->input->post('kairosmemberinfo_lastname');
		
		$data['kairosmemberinfo_dob'] = $this->input->post('kairosmemberinfo_dob_y') . '-' . $this->input->post('kairosmemberinfo_dob_m') . '-' . $this->input->post('kairosmemberinfo_dob_d');
		
		$data['kairosmemberinfo_nationalityID'] = $this->input->post('kairosmemberinfo_nationalityID');
		$data['kairosmemberinfo_gender'] = $this->input->post('kairosmemberinfo_gender');
		$data['kairosmemberinfo_UniversityID'] = $this->input->post('kairosmemberinfo_UniversityID');
		$data['kairosmemberinfo_yearOfStudy'] = $this->input->post('kairosmemberinfo_yearOfStudy');
		$data['kairosmemberinfo_phoneNo'] = $this->input->post('kairosmemberinfo_phoneNo');
		$data['kairosmemberinfo_newsletterUpdate'] = $this->input->post('kairosmemberinfo_newsletterUpdate')==0 ? 'F': 'T';
		$data['kairosmemberinfo_ownVenture'] = $this->input->post('kairosmemberinfo_ownVenture');
		$data['kairosmemberinfo_skills'] = $this->input->post('kairosmemberinfo_skills');
		
		if ($data['kairosmemberinfo_ownVenture'] == 'T')
		{
			$data['kairosmemberinfo_ventureName'] = $this->input->post('kairosmemberinfo_ventureName');
			$data['kairosmemberinfo_IndustryID'] = $this->input->post('kairosmemberinfo_IndustryID');
			$data['kairosmemberinfo_ventureDescr'] = $this->input->post('kairosmemberinfo_ventureDescr');
		}
		
		if ($type == 'insert')
		{
			$id = $this->kairosmemberinfo_model->insert($this->auth->user_id(),$data);

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