<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kairosmembership_model extends BF_Model {

	public function find($uid){
		$this->db->from('bf_membership')->where('uid',$uid);
		return $this->db->get();
	}
	
	public function insert($data){
		$this->db->insert('bf_membership',$data);
		if ($this->db->affected_rows()>0)
			return $this->db->insert_id();
		else
			return FALSE;
	}

	public function update($uid,$data){
		$this->db->where('uid',$uid)->update('bf_membership',$data);
		if ($this->db->affected_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
	
	public function delete($uid){
		$this->db->where('uid',$uid)->delete('bf_membership');
		if ($this->db->affected_rows()>0)
			return TRUE;
		else
			return FALSE;
	}
}