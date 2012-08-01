<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_announcement_table extends Migration {

	public function up(){
		$prefix = $this->db->dbprefix;
		
		$fields = array(
			'entry_id' => array(
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
			/* time of the announcement */
			'created_at' => array(
				'type' => 'BIGINT',
				'constraint' => 15,
				'unsigned' => TRUE,
			)
		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('entry_id');
		$this->dbforge->create_table('announcements');
	}
	
	public function down(){
		$prefix = $this->db->dbprefix;
		
		$this->dbforge->drop_table('announcements');
	}
}