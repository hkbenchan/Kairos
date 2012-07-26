<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class reports extends Admin_Controller {

	//--------------------------------------------------------------------

	protected $pagination_config = array(
		
		'per_page' => 20, 
		'num_links' => 5
	);




	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('KairosMemberInfo.Reports.View');
		$this->load->model('kairosmemberinfo_model', null, true);
		$this->load->model('kairosmembercv_model', null, true);
		$this->load->model('kairosmembership_model', null, true);
		$this->lang->load('kairosmemberinfo');
		$this->load->helper('security');
		$this->load->helper('exporter');
		$this->load->library('info_display');
		
		Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
		Assets::add_js('jquery-ui-1.8.13.min.js');
		Assets::add_module_js('kairosmemberinfo', 'kairosmemberinfo_report.js');
		Template::set_block('sub_nav', 'reports/_sub_nav');
	}

	//--------------------------------------------------------------------



	/*
		Method: index()

		Displays a list of form data.
	*/
	public function index()
	{
		$reportOptions = $this->kairosmemberinfo_model->getReportOptions();
		
		Template::set('records', $reportOptions);
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
		$this->auth->restrict('KairosMemberInfo.Reports.Create');
		
		Template::set_message('You cannot create anything', 'error');
		Template::redirect(SITE_AREA . '/reports/kairosmemberinfo');
	}

	//--------------------------------------------------------------------



	/*
		Method: edit()

		Allows editing of KairosMemberInfo data.
	*/
	public function edit()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.Edit');
		
		Template::set_message('You cannot edit anything', 'error');
		Template::redirect(SITE_AREA . '/reports/kairosmemberinfo');
	}

	//--------------------------------------------------------------------



	/*
		Method: delete()

		Allows deleting of KairosMemberInfo data.
	*/
	public function delete()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.Delete');

		Template::set_message('You cannot delete anything', 'error');
		Template::redirect(SITE_AREA . '/reports/kairosmemberinfo');
	}


	/*
		Method: View
		Display the summary of selected report type
	*/
	public function view()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$reportID = xss_clean($this->uri->segment(5));
		
		if (!empty($reportID))
		{
			// get the report type
			//echo $reportID;
			$result = $this->kairosmemberinfo_model->getReportOptions($reportID);
			//print_r($result);
			
			// check if the ID is valid
			if (count($result)>0)
			{
				if ($reportID == 2)
				{
					Template::redirect(SITE_AREA .'/reports/kairosmemberinfo/viewGroupByUniversity');
				}
				elseif ($reportID == 4)
				{
					Template::redirect(SITE_AREA . '/reports/kairosmemberinfo/viewVentureOwner');
				}
				elseif ($reportID == 5)
				{
					Template::redirect(SITE_AREA . '/reports/kairosmemberinfo/viewGroupByIndustry');
				}
				elseif ($reportID == 7)
				{
					Template::redirect(SITE_AREA . '/reports/kairosmemberinfo/viewAllUsers');
				}
			}
			// get all the data required and prepare for pagination
			
			
			// render the page
		}
		Template::redirect(SITE_AREA . '/reports/kairosmemberinfo/');
	}
	
	public function viewGroupByUniversity()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');

		$query = $this->kairosmemberinfo_model->groupByUniversity();
		
		$csv = xss_clean($this->uri->segment(6));
		
		if (!empty($csv))
		{
			$name = 'export_all_University.csv';
			csvRequest($query, $name);
			die();
		}
		
		$this->load->library('pagination');
		$this->pagination_config['base_url'] = SITE_AREA. '/reports/kairosmemberinfo/viewGroupByUniversity';
		$this->pagination_config['total_rows'] = $query->num_rows();
		$this->pagination->initialize($this->pagination_config); 
		$query = $this->kairosmemberinfo_model->groupByUniversity($this->pagination_config['per_page'], xss_clean($this->uri->segment(5)));
		
		$config_header = array (
			'University Name' => 'name',
			'Number of Members' => 'NumberOfMembers',
		);

		$config_url = array (
			'0' => array(
				'url' => SITE_AREA . '/reports/kairosmemberinfo/viewUniversity/',
				'variable' => 'uid',
			),
		);

		$sequencer = $this->info_display->set_sequence($config_header,$query->result(),$config_url);
		
		Template::set('toolbar_title', 'View University');
		Template::set_view('reports/query/queryResult');
		Template::set('display_data',$sequencer);
		Template::render();
		//echo $this->pagination->create_links();
	}
	
	public function viewUniversity()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		$uni_ID = xss_clean($this->uri->segment(5));
		
		if (!empty($uni_ID))
		{
			$query = $this->kairosmemberinfo_model->membersInUniversity($uni_ID);
			$this->email_send_checker($query);
			
			$csv = xss_clean($this->uri->segment(7));

			if (!empty($csv))
			{
				$name = 'export_University_' . $uni_ID . '.csv';
				csvRequest($query, $name);
				die();
			}
			
			$this->load->library('pagination');
			
			$this->pagination_config['base_url'] = SITE_AREA. '/reports/kairosmemberinfo/viewUniversity';
			$this->pagination_config['total_rows'] = $query->num_rows();
			$this->pagination_config['uri_segment'] = 6;

			$this->pagination->initialize($this->pagination_config);
			$query = $this->kairosmemberinfo_model->membersInUniversity($uni_ID,$this->pagination_config['per_page'], xss_clean($this->uri->segment(6)));
			//print_r($query);die();
			
			$config_header = array (
				'User ID' => 'uid',
				'Name' => 'kairosmemberinfo_name',
			);

			$config_url = array (
				'0' => array(
					'url' => SITE_AREA . '/reports/kairosmemberinfo/detail/',
					'variable' => 'uid',
				),
			);

			$sequencer = $this->info_display->set_sequence($config_header,$query->result(),$config_url);
			
			Template::set('display_data',$sequencer);
			//Template::set('universityID', $uni_ID);
		}
		Template::set('toolbar_title', 'View Members in this University');
		Template::set_view('reports/query/queryResult');
		Template::render();
		
	}
	
	public function viewVentureOwner()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$query = $this->kairosmemberinfo_model->allVentureOwner();
		$this->email_send_checker($query);
		
		$csv = xss_clean($this->uri->segment(6));
		
		if (!empty($csv))
		{
			$name = 'export_all_venture.csv';
			csvRequest($query, $name);
			die();
		}
		
		$this->load->library('pagination');
		//$this->load->library('table');
		
		$this->pagination_config['base_url'] = SITE_AREA. '/reports/kairosmemberinfo/viewVentureOwner';
		$this->pagination_config['total_rows'] = $query->num_rows();

		$this->pagination->initialize($this->pagination_config); 
		
		$query = $this->kairosmemberinfo_model->allVentureOwner($this->pagination_config['per_page'], xss_clean($this->uri->segment(5)));
		//print_r($query); die();
		
		$config_header = array (
			'Venture Name' => 'name',
			'Venture Owner' => 'kairosmemberinfo_name',
		);

		$config_url = array (
			'0' => array(
				'url' => SITE_AREA . '/reports/kairosmemberinfo/detail/',
				'variable' => 'uid',
			),
		);

		$sequencer = $this->info_display->set_sequence($config_header,$query->result(),$config_url);
			
		Template::set('display_data',$sequencer);
		
		Template::set('toolbar_title', 'View Venture Owner');
		Template::set_view('reports/query/queryResult');
		Template::render();
	}
	
	
	public function viewGroupByIndustry()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$query = $this->kairosmemberinfo_model->groupByIndustry();
		
		$csv = xss_clean($this->uri->segment(6));
		
		if (!empty($csv))
		{
			$name = 'export_all_industry.csv';
			csvRequest($query, $name);
			die();
		}
		
		$this->load->library('pagination');
		//$this->load->library('table');
		
		$this->pagination_config['base_url'] = SITE_AREA. '/reports/kairosmemberinfo/viewGroupByIndustry';
		$this->pagination_config['total_rows'] = $query->num_rows();

		$this->pagination->initialize($this->pagination_config); 
		
		$query = $this->kairosmemberinfo_model->groupByIndustry($this->pagination_config['per_page'], xss_clean($this->uri->segment(5)));
		//print_r($query); die();
		
		$config_header = array (
			'Industry Name' => 'IndustryName',
			'Number of Members' => 'NumberOfMembers',
		);

		$config_url = array (
			'0' => array(
				'url' => SITE_AREA . '/reports/kairosmemberinfo/viewIndustry/',
				'variable' => 'IndustryID',
			),
		);

		$sequencer = $this->info_display->set_sequence($config_header,$query->result(),$config_url);
		
		Template::set('display_data',$sequencer);
		
		Template::set('toolbar_title', 'Group By Industry');
		Template::set_view('reports/query/queryResult');
		Template::render();
		
	}
	
	public function viewIndustry()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$industry_ID = xss_clean($this->uri->segment(5));
		$csv = xss_clean($this->uri->segment(7));
		
		if (!empty($industry_ID))
		{
			$query = $this->kairosmemberinfo_model->membersInIndustry($industry_ID);
			$this->email_send_checker($query);
			
			if (!empty($csv))
			{
				$name = 'export_Industry_id_' . $industry_ID . '.csv';
				csvRequest($query, $name);
				die();
			}
			
			
			$this->load->library('pagination');

			$this->pagination_config['base_url'] = SITE_AREA. '/reports/kairosmemberinfo/viewIndustry';
			$this->pagination_config['total_rows'] = $query->num_rows();
			$this->pagination_config['uri_segment'] = 6;

			$this->pagination->initialize($this->pagination_config);
			$query = $this->kairosmemberinfo_model->membersInIndustry($industry_ID,$this->pagination_config['per_page'], xss_clean($this->uri->segment(6)));
			//print_r($query);die();
			$config_header = array (
				'User ID' => 'uid',
				'Name' => 'kairosmemberinfo_name',
				'Venture Name' => 'name',
			);

			$config_url = array (
				'0' => array(
					'url' => SITE_AREA . '/reports/kairosmemberinfo/detail/',
					'variable' => 'uid',
				),
			);

			$sequencer = $this->info_display->set_sequence($config_header,$query->result(),$config_url);
			
			Template::set('display_data',$sequencer);
			//Template::set('industryID', $industry_ID);
		}
		Template::set('toolbar_title', 'View Members in this Industry');
		Template::set_view('reports/query/queryResult');
		Template::render();

	}
	
	
	public function viewAllUsers()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		$query = $this->kairosmemberinfo_model->getAllUsers();
		
		$this->email_send_checker($query);
		
		$csv = xss_clean($this->uri->segment(6));
		
		if (!empty($csv))
		{
			$name = 'export_all_users.csv';
			csvRequest($query, $name);
			die();
		}
		
		$this->load->library('pagination');
		//$this->load->library('table');
		
		$this->pagination_config['base_url'] = SITE_AREA. '/reports/kairosmemberinfo/viewAllUsers';
		$this->pagination_config['total_rows'] = $query->num_rows();

		$this->pagination->initialize($this->pagination_config); 
		$url_seg = xss_clean($this->uri->segment(5));
		$query = $this->kairosmemberinfo_model->getAllUsers($this->pagination_config['per_page'], $url_seg);
		//print_r($query); die();
		
		$config_header = array (
			'Name' => 'kairosmemberinfo_name',
			'Date of Birth (YYYY-DD-MM)' => 'kairosmemberinfo_dob',
			'Gender' => 'kairosmemberinfo_gender',
			'Year of Study' => 'kairosmemberinfo_yearOfStudy',
			'Phone Number' => 'kairosmemberinfo_phoneNo',
			'Skills' => 'kairosmemberinfo_skills',
			'University' => 'kairosmemberinfo_University',
			'Country' => 'kairosmemberinfo_nationality',
			'Own Venture(T/F)' => 'kairosmemberinfo_ownVenture',
			'Newsletter Update' => 'kairosmemberinfo_newsletterUpdate',
		);
		
		$config_url = array (
			'0' => array(
				'url' => SITE_AREA . '/reports/kairosmemberinfo/detail/',
				'variable' => 'uid',
			),
		);
		if (!empty($url_seg))
			$csv_url = current_url().'/1';
		else
			$csv_url = current_url().'/0/1';
		
		$sequencer = $this->info_display->set_sequence($config_header,$query->result(),$config_url);
		Template::set('display_data',$sequencer);
		Template::set('url_csv', $csv_url);
		Template::set('toolbar_title', 'View All Users');
		Template::set_view('reports/query/queryResult');
		Template::render();
	}
	
	public function CV_download()
	{
		$request_ID = (int) xss_clean($this->uri->segment(5));
		if ($request_ID != $this->auth->user_id()){
			$this->auth->restrict('KairosMemberInfo.Reports.View');
		}
		
		// ask the db to get the file
		$query = $this->kairosmembercv_model->find($request_ID);
		if (($query == null) || ($query->num_rows()<1))
		{
			die('The file does not exists.');
		};
		
		$data = $query->row_array();

		$file = $data['file'];
		$name = 'CV_' . $request_ID . $data['ext'];
		// force download and die
		
		$this->load->helper('download');
		force_download($name,$file);
		die();
	}
	
	/**
	*
	*  {base_url}/index.php/admin/reports/KairosMemberInfo/detail/$user_id
	*  param: $user_id
	*/
	
	
	public function detail()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$detailID = xss_clean($this->uri->segment(5));
		$csv = xss_clean($this->uri->segment(6));
		
		//echo $detailID;die();
		
		if (!empty($detailID))
		{
			//get that user info
			$result = $this->kairosmemberinfo_model->find('user',$detailID);
			if (!empty($csv))
			{
				$name = 'export_detail_uid_' . $detailID . '.csv';
				csvRequest($result, $name);
				die();
			}

			if ($result->num_rows()>0)
			{
				$CV_uploaded = $this->kairosmembercv_model->find($detailID);
				$result_row = $result->first_row('array');
				if ($CV_uploaded->num_rows()>0)
				{
					$result_row['kairosmemberinfo_CV'] = TRUE;
				}
				
				Template::set('records', $result_row);
				$userPreference = $this->kairosmemberinfo_model->selectUserPreferenceName($detailID)->result_array();
				Template::set('preference_records',$userPreference);
			}
		}
		$csv_url = current_url().'/1';
		Template::set('url_csv',$csv_url);
		Template::set('toolbar_title', 'Manage KairosMemberInfo');
		Template::set_view('reports/detail.php');
		Template::render();
		
	}
	
	private function email_send_checker($query = null){
		
		if ($this->input->post('email')) {
			$this->load->library('data_keeper');
			
			$users = array();
			if ($query != null) {
				foreach ($query->result() as $row){
					$users[] = $row->uid;
				}

				$this->data_keeper->set_data('emailer',$users);
			
				Template::redirect(SITE_AREA.'/settings/emailer/create');
			}
		}
		
	}
	
	public function manage(){
		$this->auth->restrict('Kairosmemberinfo.Reports.View');
		$this->auth->restrict('Kairosmemberinfo.Reports.Edit');
		
		// get all users' status -- Info, CV, Payment
		$this->load->model('users/user_model');
		$users = $this->user_model->select('id, email, username, display_name')->find_all();
		
		foreach ($users as $id=>$row) {
			$q = $this->kairosmemberinfo_model->find('user',$row->id);
			$q2 = $this->kairosmembercv_model->find($row->id);
			$q3 = $this->kairosmembership_model->find($row->id);
			
			if ($q->num_rows()>0) {
				$row->filled_info = 'T';
			} else {
				$row->filled_info = 'F';
			}
			
			if ($q2->num_rows()>0) {
				$row->filled_cv = 'T';
			} else {
				$row->filled_cv = 'F';
			}
			
			if ($q3->num_rows()>0) {
				$row->filled_ship = 'T';
			} else {
				$row->filled_ship = 'F';
			}
		}
		/*
		echo '<pre>'.print_r($users,TRUE).'</pre>';
		die();
		*/
		Template::set('toolbar_title', 'Manage Users');
		Template::set('users',$users);
		Template::render();
	}
	
	public function manage_status(){
		$this->auth->restrict('Kairosmemberinfo.Reports.View');
		$this->auth->restrict('Kairosmemberinfo.Reports.Edit');
		
		if (!(xss_clean($this->input->post('checked'))) && !(xss_clean($this->input->post('total')))) {
			Template::set_message('Please select at least one user to edit','error');
			Template::redirect(SITE_AREA.'/reports/kairosmemberinfo/manage');
		}
		
		if ($checked = xss_clean($this->input->post('checked'))) {
			$this->load->library('data_keeper');
			$this->data_keeper->set_data('checked',$checked, TRUE);
			
		}
		
		if ($total = (int)xss_clean($this->input->post('total'))) {
			
			if (!($ignore = $this->input->post('ignore'))){
				$ignore = array();
			}
			
			$form_data = array();
			// form validation
			for($i=0; $i<$total; $i++){
				if (array_search($i,$ignore) !== FALSE){
					//skip this entry
				} else {
					$this->form_validation->set_rules('m_type_'.$i,'User '.($i+1).'\'s Membership Type','required|xss_clean|max_length[30]');
					$this->form_validation->set_rules('valid_from_d_'.$i,'User '.($i+1).'\'s Valid From Day','numeric|required|xss_clean|max_length[2]');
					$this->form_validation->set_rules('valid_from_m_'.$i,'User '.($i+1).'\'s Valid From Month','numeric|required|xss_clean|max_length[2]');
					$this->form_validation->set_rules('valid_from_y_'.$i,'User '.($i+1).'\'s Valid From Year','numeric|required|xss_clean|max_length[4]');
					$this->form_validation->set_rules('valid_to_d_'.$i,'User '.($i+1).'\'s Valid To Day','numeric|required|xss_clean|max_length[2]');
					$this->form_validation->set_rules('valid_to_m_'.$i,'User '.($i+1).'\'s Valid To Month','numeric|required|xss_clean|max_length[2]');
					$this->form_validation->set_rules('valid_to_y_'.$i,'User '.($i+1).'\'s Valid To Year','numeric|required|xss_clean|max_length[4]');
					$this->form_validation->set_rules('paid_'.$i,'User '.($i+1).'\'s Paid', 'required|xss_clean|max_length[1]');
					
				}
				
				$temp = array();
				$temp['uid'] = (int)($this->input->post('uid_'.$i));
				$temp['m_type'] = xss_clean($this->input->post('m_type_'.$i));
				$temp['valid_from_d'] = xss_clean($this->input->post('valid_from_d_'.$i));
				$temp['valid_from_m'] = xss_clean($this->input->post('valid_from_m_'.$i));
				$temp['valid_from_y'] = xss_clean($this->input->post('valid_from_y_'.$i));
				$temp['valid_to_d'] = xss_clean($this->input->post('valid_to_d_'.$i));
				$temp['valid_to_m'] = xss_clean($this->input->post('valid_to_m_'.$i));
				$temp['valid_to_y'] = xss_clean($this->input->post('valid_to_y_'.$i));
				$temp['paid'] = xss_clean($this->input->post('paid_'.$i));
				
				$form_data[$i] = $temp;
				unset($temp);
			}
			
			if ($this->form_validation->run() == FALSE) {
				$this->load->library('data_keeper');
				$checked = $this->data_keeper->get_data('checked');
				
				Template::set('ignore',$ignore);
				Template::set('form_data',$form_data);
			} else {
				
				$success_query = 0;
				for($i = 0; $i < $total; $i++){
					if (array_search($i,$ignore)!==FALSE) {
						continue;
					}
					$tmp = $form_data[$i];
					$tmp['valid_from'] = $tmp['valid_from_y'].'-'.$tmp['valid_from_m'].'-'.$tmp['valid_from_d'];
					$tmp['valid_to'] = $tmp['valid_to_y'].'-'.$tmp['valid_to_m'].'-'.$tmp['valid_to_d'];
					
					unset($tmp['valid_from_y']);unset($tmp['valid_from_m']);unset($tmp['valid_from_d']);
					unset($tmp['valid_to_y']);unset($tmp['valid_to_m']);unset($tmp['valid_to_d']);
					if ($this->kairosmembership_model->find($tmp['uid'])->num_rows()>0) {
						$affected_row = $this->kairosmembership_model->update($tmp['uid'],$tmp[$i]);
						if ($affected_row > 0) {
							$success_query++;
							// log the activity
						}
					} else {
						$id = $this->kairosmembership_model->insert($tmp);
						if ($id !== FALSE) {
							$success_query++;
							// log the activity
							
						}
					}
					
				}//end for
				
				if ($success_query > 0){
					Template::set_message($success_query . ' record(s) have been added/updated.','success');
					$this->load->library('data_keeper');
					$this->data_keeper->clear_data('checked');
					Template::redirect(SITE_AREA.'/reports/kairosmemberinfo/manage');
				} else {
					Template::set_message('Failed, because: '.$this->kairosmembership_model->error,'error');
					$this->load->library('data_keeper');
					$checked = $this->data_keeper->get_data('checked');

					Template::set('ignore',$ignore);
					Template::set('form_data',$form_data);
				}
			}
			
		}
		
		$users_array = array();
		$total = 0;
		if ($checked == null) {
			Template::set_message('Your session data is expired, please submit again.','error');
			Template::redirect(SITE_AREA.'/reports/kairosmemberinfo/manage');
		}
		foreach($checked as $user){
			$tmp = array();
			$tmp['id'] = $user;
			$q = $this->kairosmemberinfo_model->find('user',$user);
			$tmp['info'] = $q->first_row('array');
			$q = $this->kairosmembership_model->find($user);
			$tmp['ship'] = $q->first_row('array');
			if (isset($tmp['ship']['valid_from'])) {
				$d = explode('-',$tmp['ship']['valid_from']);
				$tmp['ship']['valid_from_y'] = $d[0];
				$tmp['ship']['valid_from_m'] = $d[1];
				$tmp['ship']['valid_from_d'] = $d[2];
			}
			if (isset($tmp['ship']['valid_to'])) {
				$d = explode('-',$tmp['ship']['valid_to']);
				$tmp['ship']['valid_to_y'] = $d[0];
				$tmp['ship']['valid_to_m'] = $d[1];
				$tmp['ship']['valid_to_d'] = $d[2];
			}
			$users_array[$total++] = $tmp;
		}
		
		Template::set('users_data',$users_array);
		Template::set('total',$total);
		Template::set('toolbar_title', 'Edit Users\' Status');
		Template::render();
		
	}
}