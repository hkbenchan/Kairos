<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events_model extends BF_Model {

	protected $table		= "events";
	protected $key			= "event_id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;
	
	public function insert_event($data){
		if (count($data) == 0) {
			return 0;
		}
		
		$this->db->insert('bf_events', $data);
		
		if ($this->db->affected_rows()>0)
			return array('affected_rows' => $this->db->affected_rows(), 'insert_id' => $this->db->insert_id());
		else
			return array('affected_rows' => $this->db->affected_rows(), 'insert_id' => '');
	}
	
	public function delete_event($event_id){
		if ($event_id == NULL) {
			return 0;
		}
		
		//$this->db->delete('user_events',array('event_id' => $event_id));
		
		$this->db->delete('events', array('event_id' => $event_id));
		return $this->db->affected_rows();
	}
	
	public function find_event($event_id){
		if ($event_id == NULL) {
			return 0;
		}
		
		$this->db->from('bf_events')->where('event_id',$event_id);
		$query = $this->db->get();
		return $query;
	}
	
	public function update_event($event_id,$data){
		if (($event_id == NULL) || (count($data)==0)){
			return 0;
		}
		
		$this->db->where('event_id', $event_id);
		$this->db->update('bf_events',$data);
		
		return $this->db->affected_rows();
	}
	
	public function find_all_events($limit=null, $offset=null){
		
		if (!is_numeric($limit)){
			$limit = $this->db->get('bf_events')->num_rows();
		}
		if (!is_numeric($offset)){
			$offset = 0;
		}
		
		$this->db->order_by('start_time','DESC')->limit($limit,$offset);
		return $this->db->get('bf_events');
	}
	
	public function find_all_users_by_event($event_id){
		if (!is_numeric($event_id)) {
			return null;
		}
		
		return $this->db->select('ue.*')->from('bf_events e')
				->join('bf_user_events ue','e.event_id = ue.event_id')
				->where('e.event_id', $event_id)
				->order_by('ue.uid', 'ASC')->get();
	}
	
	public function insert_user_events($data) {
		if (count($data) == 0) {
			return 0;
		}
		if ($this->find_user_join($data['uid'],$data['event_id'])->num_rows()>0) {
			return 0;
		}
		
		$this->db->insert('bf_user_events',$data);
		
		if ($this->db->affected_rows()>0)
			return array('affected_rows' => $this->db->affected_rows(), 'insert_id' => $this->db->insert_id());
		else
			return array('affected_rows' => $this->db->affected_rows(), 'insert_id' => '');
		
	}
	
	public function find_user_join($uid, $event_id = null, $limit = null, $offset = null){
		if (!is_numeric($event_id)) {
			if (!is_numeric($limit)){
				$limit = $this->db->from('bf_user_events ue')->join('bf_events e','ue.event_id = e.event_id')
					->where('ue.uid',$uid)->get()->num_rows();
			}
			if (!is_numeric($offset)){
				$offset = 0;
			}
			return $this->db->from('bf_user_events ue')->join('bf_events e','ue.event_id = e.event_id')
				->where('ue.uid',$uid)->limit($limit,$offset)->get();
		} else {
			$limit = 1;
			$offset = 0;
			return $this->db->from('bf_user_events ue')->join('bf_events e','ue.event_id = e.event_id')
				->where('ue.uid',$uid)->where('ue.event_id',$event_id)->limit($limit,$offset)->get();
		}
		
	}
	
	public function update_user_event_status($data){
		if (count($data)==0) {
			return 0;
		}
		
		$this->db->where('uid',$data['uid'])->where('event_id',$data['event_id'])->update('bf_user_events');
		
		return $this->db->affected_rows();
	}
	
	public function delete_user_event($uid = null,$event_id = null){
		if (!is_numeric($uid) || !(is_numeric($event_id))){
			return 0;
		}
		
		$this->db->delete('user_events', array('event_id' => $event_id,'uid' => $uid));
		return $this->db->affected_rows();
	}
}