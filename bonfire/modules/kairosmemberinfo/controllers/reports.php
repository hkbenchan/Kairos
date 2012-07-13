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
		$this->lang->load('kairosmemberinfo');
		$this->load->helper('security');
		$this->load->helper('exporter');
		$this->load->library('info_display');
		
			Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
			Assets::add_js('jquery-ui-1.8.13.min.js');
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
		
		$query = $this->kairosmemberinfo_model->getAllUsers($this->pagination_config['per_page'], xss_clean($this->uri->segment(5)));
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

		$sequencer = $this->info_display->set_sequence($config_header,$query->result(),$config_url);
		Template::set('display_data',$sequencer);
		
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
		$this->load->model('kairosmembercv_model',null,TRUE);
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
				$this->load->model('kairosmembercv_model',null,TRUE);
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
		
		Template::set('toolbar_title', 'Manage KairosMemberInfo');
		Template::set_view('reports/detail.php');
		Template::render();
		
	}
}