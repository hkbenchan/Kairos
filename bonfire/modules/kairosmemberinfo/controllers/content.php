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
			//Assets::add_js('jquery-ui-1.8.13.min.js');
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
		
		Template::set_view('reports/detail');
		if ($records != null) {
			$this->load->model('kairosmembercv_model',null,true);
			$records = $records->row_array();
			if ($this->kairosmembercv_model->find($this->auth->user_id())->num_rows() == 0){
				Template::set_message(lang('kairosmemberinfo_missing_part_two'),'attention');
			}
			else {
				$records['kairosmemberinfo_CV'] = TRUE;
			}
			
			Template::set('records', $records);
			$userPreference = $this->kairosmemberinfo_model->selectUserPreferenceName($this->auth->user_id())->result_array();
			Template::set('preference_records',$userPreference);
		}
		else {
			Template::set('records', null);
			Template::set_message(lang('kairosmemberinfo_missing_part_one'), 'attention');
		}
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
		
		if ($this->kairosmemberinfo_model->find('user',$this->auth->user_id()) != null)
			Template::redirect(SITE_AREA . '/content/kairosmemberinfo/edit/' . $this->auth->user_id());
		if ($this->input->post('submit'))
		{
			if ($insert_id = $this->save_kairosmemberinfo())
			{
				// Log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('kairosmemberinfo_act_create_record'). ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'kairosmemberinfo');

				Template::set_message(lang('kairosmemberinfo_create_success'), 'success');
				Template::redirect(SITE_AREA .'/content/kairosmemberinfo/create_cv');
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
		$query = $this->kairosmemberinfo_model->listCountry();
		Template::set('country_code',$query->result());
		
		
		/* get the list of University */
		$query = $this->kairosmemberinfo_model->listUniversity();
		Template::set('university_code', $query->result());
		
		/* get the list of Industry */
		$query = $this->kairosmemberinfo_model->listIndustry();
		Template::set('industry_code', $query->result());
		
		/* get the list of preference */
		$query = $this->kairosmemberinfo_model->listPreference();
		Template::set('preference_code', $query->result_array());
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
				Template::redirect(SITE_AREA .'/content/kairosmemberinfo/create_cv');
			}
			else
			{
				Template::set_message(lang('kairosmemberinfo_edit_failure') . $this->kairosmemberinfo_model->error, 'error');
			}
		}
		else {
			//$uid = $this->auth->user_id();
			$result = $this->kairosmemberinfo_model->find('user', $id)->row_array($id);;
		
			// break down the dob
			$dob = explode('-',$result['kairosmemberinfo_dob']);
		
			$result['kairosmemberinfo_dob_y'] = $dob[0];
			$result['kairosmemberinfo_dob_m'] = $dob[1];
			$result['kairosmemberinfo_dob_d'] = $dob[2];
		
			Template::set('kairosmemberinfo_skills', $result['kairosmemberinfo_skills']);
		
			if ($result['kairosmemberinfo_ownVenture'] == 'T')
			{
				Template::set('kairosmemberinfo_ventureDescr', $result['kairosmemberinfo_ventureDescr']);
			}
			Template::set('kairosmemberinfo', $result);
			
			$rs = $this->kairosmemberinfo_model->selectUserPreference($id)->result_array();
			$kairosmemberinfo_preference = array();
			foreach($rs as $id => $row){
				$kairosmemberinfo_preference[$row['pid']] = 'T';
			}
			Template::set('kairosmemberinfo_preference',$kairosmemberinfo_preference);
		}
		//print_r($result); die();
		Assets::add_module_js('kairosmemberinfo', 'kairosmemberinfo.js');

		Template::set('toolbar_title', lang('kairosmemberinfo_edit') . ' KairosMemberInfo');

		$this->getAndPassOptions();
		Template::set_view('content/create');
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
		if ($id == 0){
			$id = $this->auth->user_id();
		}
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
		$this->form_validation->set_rules('kairosmemberinfo_newsletterUpdate','Receive Future Updates and Newsletter','xss_clean|trim');
		$this->form_validation->set_rules('kairosmemberinfo_yearOfStudy','Year of Study','required|xss_clean');
		
		Template::set('kairosmemberinfo_skills', $this->input->post('kairosmemberinfo_skills'));
		
		if ($this->input->post('kairosmemberinfo_ownVenture')=='T')
		{
			$this->form_validation->set_rules('kairosmemberinfo_ventureName','Name of Venture','required|trim|xss_clean|max_length[100]|min_length[1]');
			$this->form_validation->set_rules('kairosmemberinfo_ventureDescr','Description of Venture','required|trim|xss_clean|max_length[500]|min_length[2]');
			Template::set('kairosmemberinfo_ventureDescr', $this->input->post('kairosmemberinfo_ventureDescr'));
		}
		
		$this->form_validation->set_rules('kairosmemberinfo_newsletterUpdate','Receive Future Updates and Newsletter','trim|xss_clean|max_length[1]');

		$preference_explode = explode(';',xss_clean($this->input->post('kairosmemberinfo_preference_combine')));
		$query = $this->kairosmemberinfo_model->listPreference()->result_array();
		$preference_need_to_add = array();
		$kairosmemberinfo_preference = array();
		foreach ($preference_explode as $descr){
			foreach ($query as $r_id => $row) {
				if ($row['description'] == $descr) {
					$preference_need_to_add[] = array(
						'uid' => $id,
						'pid' => $row['pid'],
					);
					$kairosmemberinfo_preference[$row['pid']] = 'T';
				}
			}
		}
		Template::set('kairosmemberinfo_preference',$kairosmemberinfo_preference);
		
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
		
		if (count($preference_need_to_add) > 0) {
			$this->kairosmemberinfo_model->updateUserPreference($id,$preference_need_to_add);
		}
		
		if ($type == 'insert')
		{
			$id = $this->kairosmemberinfo_model->insert($id,$data);

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

	
	public function create_cv() {
		$this->auth->restrict('KairosMemberInfo.Content.Create');
		
		if ($this->kairosmemberinfo_model->find('user',$this->auth->user_id())->num_rows() <= 0){
			Template::set_message('You need to fill information before uploading your CV', 'error');
			Template::redirect(SITE_AREA .'/content/kairosmemberinfo/create');
		}
		
		Assets::add_module_js('kairosmemberinfo', 'kairosmemberinfo.js');

		Template::set('toolbar_title', lang('kairosmemberinfo_create_cv') . ' KairosMemberInfo');
		Template::render();
	}
	
	public function create_cv_upload() {
		$this->auth->restrict('KairosMemberInfo.Content.Create');
		
		$upload_config['upload_path'] = './uploads/';
		$upload_config['allowed_types'] = 'doc|docx|pdf';
		$upload_config['max_size']	= '1024';
		$upload_config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $upload_config);
		
		if ( ! $this->upload->do_upload())
		{
			$error = $this->upload->display_errors();
			Template::set_message($error,'error');
			Template::redirect(SITE_AREA .'/content/kairosmemberinfo/create_cv');
		}
		else
		{
			$data = $this->upload->data();
			//echo '<pre>'. print_r($data,TRUE) .'</pre>'; 
			
			// open the file
			$fp = fopen($data['full_path'],'r');
			$content = fread($fp, filesize($data['full_path']));
			fclose($fp);
			//remove the temp file
			unlink($data['full_path']);
			$this->load->library('encrypt');
			
			$key = time();
			$key1 = $this->encrypt->sha1($key);
			$content = $this->encrypt->encode($content,$key);
			
			$insert_data = array(
				'uid'	=> $this->auth->user_id(),
				'name' => $data['file_name'],
				'size' => $data['file_size'],
				'type' => $data['file_type'],
				'ext' => $data['file_ext'],
				'key' => $key,
				'file' => $content,
			);
			
			$this->load->model('kairosmembercv_model',null,TRUE);
			$result = $this->kairosmembercv_model->insert($insert_data);

			if ($result == 0)
			{
				$error = lang('kairosmemberinfo_create_cv_failure');
				Template::set_message($error,'error');
				Template::redirect(SITE_AREA .'/content/kairosmemberinfo/create_cv');
			} else {
				//log the activity
				$this->activity_model->log_activity($this->current_user->id, lang('kairosmemberinfo_act_create_cv_record'). ': ' . $this->auth->user_id() . ' : ' . $this->input->ip_address(), 'kairosmemberinfo');
				Template::set_message(lang('kairosmemberinfo_create_cv_success'), 'success');
				Template::redirect(SITE_AREA .'/content/kairosmemberinfo');
			}
		}
	}
	
	
	private function save_kairosmembercv($type='insert',$id = 0, $file) {
		
		if ($type == 'update'){
			$_POST['id'] = $id;
		}
		
		//$this->form_validation->set
	}


}