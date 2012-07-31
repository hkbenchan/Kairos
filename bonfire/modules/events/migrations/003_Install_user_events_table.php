<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_user_events_table extends Migration {
	
	public function up(){
		$prefix = $this->db->dbprefix;
		
		$fields = array(
			'event_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'uid' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE
			),
			'status' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
			)
		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('event_id',TRUE);
		$this->dbforge->add_key('uid',TRUE);
		$this->dbforge->create_table('user_events');
		
		// foreign key link
		
		$queries[] = "ALTER TABLE `bf_user_events` ADD FOREIGN KEY ( `event_id` ) REFERENCES `bf_events` (`event_id`) 
		ON DELETE CASCADE ON UPDATE NO ACTION ;"

		$queries[] = "ALTER TABLE `bf_user_events` ADD FOREIGN KEY ( `uid` ) REFERENCES `bf_users` (`id`)
		ON DELETE CASCADE ON UPDATE NO ACTION ;";
		
		foreach ($queries as $q)
			$this->db->query($q);
	}
	
	public function down(){
		$prefix = $this->db->dbprefix;
		
		$this->dbforge->drop_table('user_events');
	}
}