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


	public function insert($id, $data)
	{
		$uid = $id;
		
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
	
	public function update($id,$data)
	{
		return $this->insert($id,$data);
	}
	
	public function find($type, $id)
	{
		if ($type == "user")
		{
			$user_info = $this->select_user_info($id);
			$user_info_rel = $user_info->result();
			$venture = $user_info_rel[0]->kairosmemberinfo_ownVenture;
			$user_id = $id;
		}
		elseif ($type == "rec")
		{
			$user_info = $this->db->get_where('bf_user_info', array('entry_id' => $id));
			$user_info_rel = $user_info->result();
			$user_id = $user_info_rel[0]->uid;
			$venture = $user_info_rel[0]->kairosmemberinfo_ownVenture;//$this->select_venture($user_id);
		}
		if ($venture != 'T')
		{
			return $this->findWithoutVenture($user_id);
		}
		else
		{
			return $this->findWithVenture($user_id);
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
		return $this->db->affected_rows() == 1;
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
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_university')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		
		$this->db->select('uni.uid, uni.name, count(*) as `Number of members`', FALSE)
			->from('bf_user_info ui')
			->join('bf_university uni','ui.kairosmemberinfo_UniversityID = uni.uid')
			->group_by('uni.uid')
			->limit($limit,$offset);
		$query = $this->db->get();
		
		return $query;
	}
	
	public function membersInUniversity($uni_ID, $limit = 0, $offset = 0)
	{
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_user_info')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		
		$this->db->select('usr.uid, usr.kairosmemberinfo_firstname, usr.kairosmemberinfo_middlename, usr.kairosmemberinfo_lastname, uni.name')
			->from('bf_user_info usr')
			->join('bf_university uni','usr.kairosmemberinfo_UniversityID = uni.uid')
			->where('uni.uid', $uni_ID)
			->limit($limit,$offset);
		$query = $this->db->get();
		
		return $query;
	}
	
	public function allVentureOwner($limit = 0 , $offset = 0)
	{
		
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_university')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		
		$this->db->select('info.uid, info.kairosmemberinfo_firstname, info.kairosmemberinfo_middlename,
			info.kairosmemberinfo_lastname, venture.vid, venture.name')
			->from('bf_user_info AS info')
			->join('bf_venture venture', 'info.uid = venture.uid')
			->where('info.kairosmemberinfo_ownVenture', 'T')
			->limit($limit, $offset);
		$query = $this->db->get();

		return $query;
		
	}
	
	public function groupByIndustry($limit = 0, $offset = 0)
	{
		
		
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_industry')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}		
		
		$this->db->select('v.IndustryID, i.name as IndustryName, count(*) as `Number of members`', FALSE)
			->from('bf_venture AS v')
			->join('bf_industry i', 'v.IndustryID = i.iid')
			->group_by('v.IndustryID')
			->limit($limit, $offset);
		$query = $this->db->get();
		
		return $query;
		
	}
	
	public function membersInIndustry($industry_ID, $limit = 0, $offset = 0)
	{
		if (!is_numeric($limit))
		{
			$limit = $this->db->get('bf_user_info')->num_rows();
		}
		if (!is_numeric($offset))
		{
			$offset = 0;
		}
		
		$this->db->select('v.name, v.IndustryID, i.name IndustryName,
			user.kairosmemberinfo_firstname, user.kairosmemberinfo_middlename, user.kairosmemberinfo_lastname,
			user.uid')
			->from('bf_venture AS v')
			->join('bf_user_info user', 'v.uid = user.uid')
			->join('bf_industry i', 'v.IndustryID = i.iid')
			->where('i.iid', $industry_ID)
			->limit($limit,$offset);
		$query = $this->db->get();

		return $query;
	}
	
	
	public function select_nation($nid)
	{
		$this->db->where('nid',$nid);
		$query = $this->db->get('bf_country');
		return $query;
	}

	
	public function select_venture($uid)
	{
		$this->db->where('uid', $uid);
		$query = $this->db->get('bf_venture');
		return $query;
	}

	public function select_industry($iid)
	{
		$this->db->where('iid',$iid);
		$query = $this->db->get('bf_industry');
		return $query;
	}

	public function select_uni($uid)
	{
		$this->db->where('uid',$uid);
		$query = $this->db->get('bf_university');
		return $query;
	}

	public function select_user_info($id)
	{
		$this->db->where('uid', $id);
		$query = $this->db->get('bf_user_info');
		return $query;
	}
	

	private function findWithoutVenture($uid)
	{
		$this->db->select('info.*, uni.name AS kairosmemberinfo_University, nation.name AS kairosmemberinfo_nationality')
			->from('bf_user_info info')
			->join('bf_university uni', 'info.kairosmemberinfo_UniversityID = uni.uid')
			->join('bf_country nation', 'info.kairosmemberinfo_nationalityID = nation.nid')
			->where('info.uid', $uid);
		$query = $this->db->get();
		
		return $query;
	}
	
	private function findWithVenture($uid)
	{
		$this->db->select('info.*, uni.name AS kairosmemberinfo_University, nation.name AS kairosmemberinfo_nationality,
			v.name AS kairosmemberinfo_ventureName, v.descr as kairosmemberinfo_ventureDescr, v.IndustryID as kairosmemberinfo_IndustryID,
			ind.name as kairosmemberinfo_ventureIndustry')
			->from('bf_user_info info')
			->join('bf_university uni', 'info.kairosmemberinfo_UniversityID = uni.uid')
			->join('bf_country nation', 'info.kairosmemberinfo_nationalityID = nation.nid')
			->join('bf_venture v', 'info.uid = v.uid')
			->join('bf_industry ind', 'v.IndustryID = ind.iid')
			->where('info.uid', $uid);
		$query = $this->db->get();
		
		return $query;
	}
}

