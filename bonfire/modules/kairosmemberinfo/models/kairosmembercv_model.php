<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kairosmembercv_model extends BF_Model {

	protected $table		= "CV";
	protected $key			= "uid";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;
	
	public function insert($data){
		if (count($data) == 0) {
			return 0;
		}
		if ($this->find($data['uid'])->num_rows()>0)
			$this->delete($data['uid']);
		
		$this->db->insert('bf_CV', $data);
		
		return $this->db->affected_rows();
	}
	
	public function delete($uid){
		if ($uid == NULL) {
			return 0;
		}
		
		$this->db->delete('CV', array('uid' => $uid));
		return $this->db->affected_rows();
	}
	
	public function find($uid){
		if ($uid == NULL) {
			return 0;
		}
		
		$this->db->from('bf_CV')->where('uid',$uid);
		$query = $this->db->get();
		return $query;
	}
}