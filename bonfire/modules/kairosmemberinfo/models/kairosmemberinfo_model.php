<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kairosmemberinfo_model extends BF_Model {

	protected $table		= "user_info";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;


	private $reportOptions = array (
		'1' => array(
			'reportID' => 1,
			'reportName' => 'Select by UserID',
			'reportDescription' => 'Show all detail of a member',
			'display' => FALSE
		),
		
		'2' => array(
			'reportID' => 2,
			'reportName' => 'Group by University',
			'reportDescription' => 'Group by University and show the number of members in that university',
			'display' => TRUE
		),
		
		'3' => array(
			'reportID' => 3,
			'reportName' => 'Filter out by University',
			'reportDescription' => 'Select members in that university',
			'display' => FALSE
		),
		
		'4' => array(
			'reportID' => 4,
			'reportName' => 'Select all venture owner',
			'reportDescription' => 'Show all members who own venture',
			'display' => TRUE
		),
		
		'5' => array(
			'reportID' => 5,
			'reportName' => 'Group by Industry of Venture',
			'reportDescription' => 'Group by Industry of Venture and show the number of venture in that industry',
			'display' => TRUE
		),
		
		'6' => array(
			'reportID' => 6,
			'reportName' => 'Filter out by Industry of Venture',
			'reportDescription' => 'Select members in that Industry of Venture',
			'display' => FALSE
		)
	);

	public function getReportOptions()
	{
		return $this->reportOptions;
	}

	public function getReportTypeByID($reportID)
	{
		return $this->reportOptions[$reportID];
	}


	public function insert($data)
	{
		$uid = $this->auth->user_id();
		
		/* user_info data */
		$insert_array_user_info = array(
			'uid' => $uid,
			'kairosmemberinfo_firstname' => $data['kairosmemberinfo_firstname'],
			'kairosmemberinfo_middlename' => $data['kairosmemberinfo_middlename'],
			'kairosmemberinfo_lastname' => $data['kairosmemberinfo_lastname'],
			'kairosmemberinfo_dob' => $data['kairosmemberinfo_dob'],
			'kairosmemberinfo_gender' => $data['kairosmemberinfo_gender'],
			'kairosmemberinfo_nationalityID' => $data['kairosmemberinfo_nationalityID'],
			'kairosmemberinfo_UniversityID' => $data['kairosmemberinfo_UniversityID'],
			'kairosmemberinfo_yearOfStudy' => $data['kairosmemberinfo_yearOfStudy'],
			'kairosmemberinfo_phoneNo' => $data['kairosmemberinfo_phoneNo'],
			'kairosmemberinfo_ownVenture' => $data['kairosmemberinfo_ownVenture'],
			'kairosmemberinfo_skills' => $data['kairosmemberinfo_skills'],
			'kairosmemberinfo_newsletterUpdate' => $data['kairosmemberinfo_newsletterUpdate'],
			
		);
		
		if (count($this->select_user_info($uid)) > 0)
		{
			// update
			$this->db->where('uid',$uid);
			$this->db->update('bf_user_info',$insert_array_user_info);
		}
		else 
		{
			// insert
			$this->db->insert('bf_user_info',$insert_array_user_info);
		}
		
		// decide if he/she has venture
		if ($data['kairosmemberinfo_ownVenture'] == 'T')
		{
			
			$insert_array_venture = array (
				'uid' => $uid,
				'IndustryID' => $data['kairosmemberinfo_IndustryID'],
				'name' => $data['kairosmemberinfo_ventureName'],
				'descr' => $data['kairosmemberinfo_ventureDescr']
			);
			
			// check if the table contains the record
			if (count($this->select_venture($uid)) > 0)
			{
				// update
				$this->db->where('uid',$uid);
				$this->db->update('bf_venture', $insert_array_venture);
			}
			else
			{
				// insert
				$this->db->insert('bf_venture', $insert_array_venture);
			}
		}
		
		return 1;
	}
	
	public function update($entry_id,$data)
	{
		return $this->insert($data);
	}
	
	public function find($uid)
	{
		$user_info = $this->select_user_info($uid);
		$venture = $this->select_venture($uid);
		if (isset($user_info[0]->kairosmemberinfo_nationalityID))
			$nation = $this->select_nation($user_info[0]->kairosmemberinfo_nationalityID);
		if (isset($user_info[0]->kairosmemberinfo_UniversityID))
			$university = $this->select_uni($user_info[0]->kairosmemberinfo_UniversityID);
		if (isset($venture[0]->IndustryID))
			$industry = $this->select_industry($venture[0]->IndustryID);
		
		// combine results
		if (count($user_info) && count($venture)) {
			$result = $this->join_user_info_and_venture($user_info,$venture);
			$result['kairosmemberinfo_University'] = $university[0]->name;
			$result['kairosmemberinfo_nationality'] = $nation[0]->name;
			$result['kairosmemberinfo_ventureIndustry'] = $industry[0]->name;
//			print_r($result); die();
			return $result;
		}
		elseif (count($user_info))
		{
			$result = $this->join_user_info_and_venture($user_info,$venture);
			$result['kairosmemberinfo_University'] = $university[0]->name;
			$result['kairosmemberinfo_nationality'] = $nation[0]->name;
			$result['kairosmemberinfo_ventureIndustry'] = '';
			return $result;
		}
		else
		{
			return $user_info;
		}
	}

	public function delete($uid)
	{
		$d_v = $this->select_venture($uid);
		
		if (count($d_v)>0) {
			$this->db->where('uid',$uid);
			$this->db->delete('bf_venture');
		}
		
		$this->db->where('uid',$uid);
		$this->db->delete('bf_user_info');
		return 1;
	}
	
	public function authroizeDelete($entry_id, $uid)
	{
		$this->db->where('entry_id',$entry_id);
		$this->db->where('uid',$uid);
		$query = $this->db->select('bf_user_info');
		if (count($query->result())>0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function groupByUniversity($limit = 0, $offset = 0)
	{
		//$this->db->select('university.name, ')
		$query = "SELECT `uni`.uid, `uni`.name, count(*) as `Number of members`
		FROM `bf_user_info`, `bf_university` as `uni`
		WHERE `bf_user_info`.kairosmemberinfo_UniversityID = `uni`.uid
		GROUP BY `uni`.uid";
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_university')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		if ($limit == $offset && $limit == 0)
		{
			//do nothing
		}
		else
		{
			$query = $query . " limit " . $offset . " , " . $limit;
		}
		
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function membersInUniversity($uni_ID, $limit = 0, $offset = 0)
	{
		$query = "SELECT `usr`.uid, `usr`.kairosmemberinfo_firstname, `usr`.kairosmemberinfo_middlename, `usr`.kairosmemberinfo_lastname, `uni`.name
		FROM `bf_user_info` as `usr`, `bf_university` as `uni`
		WHERE `usr`.kairosmemberinfo_UniversityID = `uni`.uid
		AND `uni`.uid = " . $uni_ID;
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_user_info')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		if ($limit == $offset && $limit == 0)
		{
			//do nothing
		}
		else
		{
			$query = $query . " limit " . $offset . " , " . $limit;
		}
		
		$query = $this->db->query($query);
		return $query->result();
	}
	
	public function allVentureOwner($limit = 0 , $offset = 0)
	{
		$query = "SELECT `info`.uid, `info`.`kairosmemberinfo_firstname`, `info`.`kairosmemberinfo_middlename`, `info`.`kairosmemberinfo_lastname`, `venture`.vid, `venture`.name
		from `bf_user_info` as `info`, `bf_venture` as `venture`
		where `info`.kairosmemberinfo_ownVenture = 'T' AND
		`info`.uid = `venture`.uid";
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_university')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		if ($limit == $offset && $limit == 0)
		{
			//do nothing
		}
		else
		{
			$query = $query . " limit " . $offset . " , " . $limit;
		}
		
		$query = $this->db->query($query);
		return $query->result();
		
	}
	
	public function groupByIndustry($limit = 0, $offset = 0)
	{
		$query = "SELECT v.IndustryID, i.name as IndustryName, count(*) as `Number of members`
		from bf_venture as v, bf_industry as i
		where v.IndustryID = i.iid
		group by v.IndustryID";
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_industry')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		if ($limit == $offset && $limit == 0)
		{
			//do nothing
		}
		else
		{
			$query = $query . " limit " . $offset . " , " . $limit;
		}
		
		$query = $this->db->query($query);
		return $query->result();
		
	}
	
	public function membersInIndustry($industry_ID, $limit = 0, $offset = 0)
	{
		$query = "SELECT v.name, v.IndustryID, i.name as IndustryName,
		u.kairosmemberinfo_firstname, u.kairosmemberinfo_middlename, u.kairosmemberinfo_lastname, u.uid
		from bf_venture as v, bf_industry as i, bf_user_info as u
		where v.uid = u.uid
		and v.IndustryID = i.iid
		and i.iid = " . $industry_ID;
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_user_info')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		if ($limit == $offset && $limit == 0)
		{
			//do nothing
		}
		else
		{
			$query = $query . " limit " . $offset . " , " . $limit;
		}
		
		$query = $this->db->query($query);
		return $query->result();
	}
	
	
	public function select_nation($nid)
	{
		$this->db->where('nid',$nid);
		$query = $this->db->get('bf_country');
		return $query->result();
	}

	
	public function select_venture($uid)
	{
		$this->db->where('uid', $uid);
		$query = $this->db->get('bf_venture');
		/*$query = "SELECT * from `bf_venture`, `bf_industry` where `bf_venture`.uid = " . $uid . " AND `bf_venture`.IndustryID = `bf_industry`.iid";
		$query = $this->db->query($query);*/
		return $query->result();
	}

	public function select_industry($iid)
	{
		$this->db->where('iid',$iid);
		$query = $this->db->get('bf_industry');
		return $query->result();
	}

	public function select_uni($uid)
	{
		$this->db->where('uid',$uid);
		$query = $this->db->get('bf_university');
		return $query->result();
	}

	public function select_user_info($id)
	{
		$this->db->where('uid', $id);
		$query = $this->db->get('bf_user_info');
		/*if (count($query->result()) > 0)
		{*/
		return $query->result();
	}
	
	private function join_user_info_and_venture($user_info,$venture)
	{
		$result = array();
		
		foreach ($user_info as $row => $record)
		{
			foreach ($record as $name => $value)
			{
				$result[$name] = $value;
			}
			if ($record->kairosmemberinfo_ownVenture == 'T')
			{
				// get the result in venture and combine
				foreach ($venture as $row2 => $record2)
				{
					foreach ($record2 as $name2 => $value2)
					{
						if ($name2 == 'name') {
							$result['kairosmemberinfo_ventureName'] = $value2; }
						elseif ($name2 == 'descr') {
							$result['kairosmemberinfo_ventureDescr'] = $value2; }
						else {
							$result['kairosmemberinfo_' . $name2] = $value2; }
					}
				}
			}
			else if (count($venture)>0)
			{
				// something strange, php_error
			}
			else
			{
				$result['kairosmemberinfo_ventureName'] = '';
				$result['kairosmemberinfo_ventureDescr'] = '';
				$result['kairosmemberinfo_IndustryID'] = '';
			}
			
		}
		if ($result['kairosmemberinfo_newsletterUpdate'] == 'T')
		{
			$result['kairosmemberinfo_newsletterUpdate'] = 1;
		}
		else
		{
			$result['kairosmemberinfo_newsletterUpdate'] = 0;
		}
		
		return $result;
	}
	
}

