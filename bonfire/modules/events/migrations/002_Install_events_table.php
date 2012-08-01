<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_events_table extends Migration {

	public function up(){
		$prefix = $this->db->dbprefix;
		
		$fields = array(
			'event_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'created_by' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'content' => array(
				'type' => 'TEXT',
			),
			'created_at' => array(
				'type' => 'BIGINT',
				'constraint' => 15,
				'unsigned' => TRUE,
			),
			'start_time' => array(
				'type' => 'BIGINT',
				'constraint' => 15,
				'unsigned' => TRUE,
			),
			'end_time' => array(
				'type' => 'BIGINT',
				'constraint' => 15,
				'unsigned' => TRUE
			),
			'location' => array(
				'type' => 'TEXT'
			)
		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('event_id',TRUE);
		$this->dbforge->create_table('events');
	}
	
	public function down(){
		$prefix = $this->db->dbprefix;
		
		$this->dbforge->drop_table('events');
	}
}