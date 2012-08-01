<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Announcement_model extends BF_Model {

	protected $table		= "announcement";
	protected $key			= "entry_id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;
	
	public function insert($data){
		if (count($data) == 0) {
			return 0;
		}
		
		$this->db->insert('bf_announcements', $data);
		
		if ($this->db->affected_rows()>0)
			return array('affected_rows' => $this->db->affected_rows(), 'insert_id' => $this->db->insert_id());
		else
			return array('affected_rows' => $this->db->affected_rows(), 'insert_id' => '');
	}
	
	public function delete($entry_id){
		if ($entry_id == NULL) {
			return 0;
		}
		
		$this->db->delete('announcements', array('entry_id' => $entry_id));
		return $this->db->affected_rows();
	}
	
	public function find($entry_id){
		if ($entry_id == NULL) {
			return 0;
		}
		
		$this->db->from('bf_announcements')->where('entry_id',$entry_id);
		$query = $this->db->get();
		return $query;
	}
	
	public function update($entry_id,$data){
		if (($entry_id == NULL) || (count($data)==0)){
			return 0;
		}
		
		$this->db->where('entry_id', $entry_id);
		$this->db->update('bf_announcements',$data);
		
		return $this->db->affected_rows();
	}
	
	public function find_all($limit=null, $offset=null){
		
		if (!is_numeric($limit)){
			$limit = $this->db->get('bf_announcements')->num_rows();
		}
		if (!is_numeric($offset)){
			$offset = 0;
		}
		
		$this->db->order_by('created_at','DESC')->limit($limit,$offset);
		return $this->db->get('bf_announcements');
	}
	
}