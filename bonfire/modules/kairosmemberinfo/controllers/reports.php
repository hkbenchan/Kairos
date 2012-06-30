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
//		print_r($reportOptions); die();
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
		
		$reportID = $this->uri->segment(5);
		
		if (!empty($reportID))
		{
			// get the report type
			//echo $reportID;
			$result = $this->kairosmemberinfo_model->getReportTypeByID($reportID);
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
			}
			// get all the data required and prepare for pagination
			
			
			// render the page
			
		}
		else
		{
			
		}
	}
	
	public function viewGroupByUniversity()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');

		$query = $this->kairosmemberinfo_model->groupByUniversity();
		
		$csv = $this->uri->segment(6);
		
		if (!empty($csv))
		{
			$name = 'export_all_University.csv';
			$this->csvRequest($query, $name);
			die();
		}
		
		$this->load->library('pagination');
		//$this->load->library('table');
		
		$this->pagination_config['base_url'] = SITE_AREA. 'reports/kairosmemberinfo/viewGroupByUniversity';
		$this->pagination_config['total_rows'] = $query->num_rows();


		$this->pagination->initialize($this->pagination_config); 
		
		$query = $this->kairosmemberinfo_model->groupByUniversity($this->pagination_config['per_page'], $this->uri->segment(5));
		//print_r($query); die();
		Template::set('toolbar_title', 'View University');
		Template::set_view('reports/query/groupByUniversity');
		Template::set('records',$query->result());
		Template::render();
		//echo $this->pagination->create_links();
	}
	
	public function viewUniversity()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		$uni_ID = $this->uri->segment(5);
		
		if (!empty($uni_ID))
		{
			$query = $this->kairosmemberinfo_model->membersInUniversity($uni_ID);
			
			$csv = $this->uri->segment(7);

			if (!empty($csv))
			{
				$name = 'export_University_' . $uni_ID . '.csv';
				$this->csvRequest($query, $name);
				die();
			}
			
			$this->load->library('pagination');
			
			$this->pagination_config['base_url'] = SITE_AREA. 'reports/kairosmemberinfo/viewUniversity';
			$this->pagination_config['total_rows'] = $query->num_rows();
			$this->pagination_config['uri_segment'] = 6;

			$this->pagination->initialize($this->pagination_config);
			$query = $this->kairosmemberinfo_model->membersInUniversity($uni_ID,$this->pagination_config['per_page'], $this->uri->segment(6));
			//print_r($query);die();
			Template::set('records',$query->result());
			Template::set('universityID', $uni_ID);
		}
		Template::set('toolbar_title', 'View Members in this University');
		Template::set_view('reports/query/viewUniversity');
		Template::render();
		
	}
	
	public function viewVentureOwner()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$query = $this->kairosmemberinfo_model->allVentureOwner();
		
		$csv = $this->uri->segment(6);
		
		if (!empty($csv))
		{
			$name = 'export_all_venture.csv';
			$this->csvRequest($query, $name);
			die();
		}
		
		$this->load->library('pagination');
		//$this->load->library('table');
		
		$this->pagination_config['base_url'] = SITE_AREA. 'reports/kairosmemberinfo/viewVentureOwner';
		$this->pagination_config['total_rows'] = $query->num_rows();

		$this->pagination->initialize($this->pagination_config); 
		
		$query = $this->kairosmemberinfo_model->allVentureOwner($this->pagination_config['per_page'], $this->uri->segment(5));
		//print_r($query); die();
		Template::set('toolbar_title', 'View Venture Owner');
		Template::set_view('reports/query/viewAllVenture');
		Template::set('records',$query->result());
		Template::render();
	}
	
	
	public function viewGroupByIndustry()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$query = $this->kairosmemberinfo_model->groupByIndustry();
		$csv = $this->uri->segment(6);
		
		if (!empty($csv))
		{
			$name = 'export_all_industry.csv';
			$this->csvRequest($query, $name);
			die();
		}
		
		$this->load->library('pagination');
		//$this->load->library('table');
		
		$this->pagination_config['base_url'] = SITE_AREA. 'reports/kairosmemberinfo/viewGroupByIndustry';
		$this->pagination_config['total_rows'] = $query->num_rows();

		$this->pagination->initialize($this->pagination_config); 
		
		$query = $this->kairosmemberinfo_model->groupByIndustry($this->pagination_config['per_page'], $this->uri->segment(5));
		//print_r($query); die();
		Template::set('toolbar_title', 'View Venture Owner');
		Template::set_view('reports/query/groupByIndustry');
		Template::set('records',$query->result());
		Template::render();
		
	}
	
	public function viewIndustry()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$industry_ID = $this->uri->segment(5);
		$csv = $this->uri->segment(7);
		
		if (!empty($industry_ID))
		{
			$query = $this->kairosmemberinfo_model->membersInIndustry($industry_ID);
			
			if (!empty($csv))
			{
				$name = 'export_Industry_id_' . $industry_ID . '.csv';
				$this->csvRequest($query, $name);
				die();
			}
			
			
			$this->load->library('pagination');

			$this->pagination_config['base_url'] = SITE_AREA. 'reports/kairosmemberinfo/viewIndustry';
			$this->pagination_config['total_rows'] = $query->num_rows();
			$this->pagination_config['uri_segment'] = 6;

			$this->pagination->initialize($this->pagination_config);
			$query = $this->kairosmemberinfo_model->membersInIndustry($industry_ID,$this->pagination_config['per_page'], $this->uri->segment(6));
			//print_r($query);die();
			Template::set('records',$query->result());
			Template::set('industryID', $industry_ID);
		}
		Template::set('toolbar_title', 'View Members in this Industry');
		Template::set_view('reports/query/viewIndustry');
		Template::render();

	}
	
	/**
	*
	*  {base_url}/index.php/admin/reports/KairosMemberInfo/detail/$user_id
	*  param: $user_id
	*/
	
	
	public function detail()
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');
		
		$detailID = $this->uri->segment(5);
		$csv = $this->uri->segment(6);
		
		if (!empty($detailID))
		{
			//get that user info
			$result = $this->kairosmemberinfo_model->find('user',$detailID);
			if (!empty($csv))
			{
				$name = 'export_detail_uid_' . $detailID . '.csv';
				$this->csvRequest($result, $name);
				die();
			}
			
			if (count($result->row_array())>0)
			{
				Template::set('records', $result->row_array());
			}
		}
		
		Template::set('toolbar_title', 'Manage KairosMemberInfo');
		Template::set_view('reports/detail.php');
		Template::render();
		
	}
	
	public function csvRequest($data, $name = 'export.csv')
	{
		$file;
		$error;
		if (!$this->csvExporter($file,$error,$data))
		{
			echo 'fail';
			die();
		}
		else
		{
			$this->load->helper('download');
			force_download($name,$file);
		}
	}

	/**
	 * @param file|null $file The CSV file stored
	 * @param array|null $error The error will be stored (if any)
	 * @param array $data The data that need to convert into CSV
	 * @return boolean The operation is successful or not
	 */

	public function csvExporter(&$file,&$error, $data)
	{
		$this->auth->restrict('KairosMemberInfo.Reports.View');

		if (count($data) == 0)
		{
			$error = array('message' => 'Data is empty');
			return false;
		}

		$delimiter = ",";
		$newline = "\r\n";

		$this->load->dbutil();

		$file = $this->dbutil->csv_from_result($data,$delimiter,$newline);
		return true;
	}
	
	
	
}