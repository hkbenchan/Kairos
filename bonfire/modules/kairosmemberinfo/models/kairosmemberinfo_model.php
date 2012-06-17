<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kairosmemberinfo_model extends BF_Model {

	protected $table		= "user_info";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;


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
		
		if (count($this->select($uid)) > 0)
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
		return 1;
	}

	public function delete($id)
	{
		
	}

	public function select($id)
	{
		$this->db->where('uid', $id);
		$query = $this->db->get('bf_user_info');
		/*if (count($query->result()) > 0)
		{*/
		return $query->result();
	}
}

