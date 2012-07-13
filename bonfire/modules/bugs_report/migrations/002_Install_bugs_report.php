<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_bugs_report extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$query = "CREATE TABLE  `bf_bugs_status_ref` (
		`status_id` INT( 1 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`status_text` VARCHAR( 50 ) NOT NULL
		)";
		
		$result = $this->db->query($query);
		if (!$result) {
			show_error('Fail to run pre_setup' , 500);
		}


		$fields = array(
			'bug_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'bugs_report_bug_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
				
			),
			'bugs_report_URL' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'bugs_report_descr' => array(
				'type' => 'TEXT',
				
			),
			'bugs_report_Status' => array(
				'type' => 'INT',
				'constraint' => 1,
				
			),
			'created_on' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
			'modified_on' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('bug_id', true);
		$this->dbforge->create_table('bugs_report');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;
		
		$this->dbforge->drop_table('bugs_report');
		$this->dbforge->drop_table('bugs_status_ref');
	}

	//--------------------------------------------------------------------

}