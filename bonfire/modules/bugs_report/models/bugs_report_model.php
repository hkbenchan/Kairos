<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bugs_report_model extends BF_Model {

	protected $table		= "bugs_report";
	protected $key			= "bug_id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= true;
	protected $set_modified = true;
	protected $created_field = "created_on";
	protected $modified_field = "modified_on";

	public function find_all()
	{
		$query = "SELECT * from `bf_bugs_report`, `bf_bugs_status_ref` WHERE `bf_bugs_report`.bugs_report_Status = `bf_bugs_status_ref`.status_id";
		$query = $this->db->query($query);
		return $query->result();
	}


	public function find($bug_id)
	{
		$query = "SELECT * from `bf_bugs_report`, `bf_bugs_status_ref` WHERE `bf_bugs_report`.bugs_report_Status = `bf_bugs_status_ref`.status_id AND `bf_bugs_report`.bug_id = " . $bug_id; 
		$query = $this->db->query($query);
		return $query->result();
	}

	public function insert($data)
	{ 
		$val = array (
			'bugs_report_URL' => $data['bugs_report_URL'],
			'bugs_report_descr' => $data['bugs_report_descr'],
			'bugs_report_bug_type' => $data['bugs_report_bug_type'],
			'bugs_report_Status' => 1,
			'created_on' => $data['created_on'],
			'modified_on' => $data['modified_on']
		);

		$this->db->insert('bf_bugs_report',$val);
		return 1;
	}

	public function update($bug_id, $data)
	{
		$val = array (
			'bugs_report_URL' => $data['bugs_report_URL'],
			'bugs_report_descr' => $data['bugs_report_descr'],
			'bugs_report_bug_type' => $data['bugs_report_bug_type'],
			'bugs_report_Status' => 1,
			'modified_on' => $data['modified_on']
		);

		$this->db->where('bug_id', $bug_id);
		$this->db->update('bf_bugs_report',$data);
		return 1;
	}

	public function changeStatus($bug_id, $status_id)
	{
		$this->db->where('bug_id',$bug_id);
		$data = array(
			'bugs_report_Status' => $status_id
		);
		$this->db->update('bf_bugs_report',$status_id);
		return 1;
	}

	public function closedThread($bug_id)
	{
		return $this->changeStatus($bug_id,5);
	}

}
