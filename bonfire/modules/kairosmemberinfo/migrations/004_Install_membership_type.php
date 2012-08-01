<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_membership_type extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;
		
		/* table for membership */
		$fields = array(
			'uid' => array(
				'type' => 'BIGINT',
				'constraint' => 20,
				'unsigned' => TRUE
			),
			
			'm_type' => array(
				'type' => 'VARCHAR',
				'constraint' => 30,
			),
			
			'valid_from' => array(
				'type' => 'date',
			),
			
			'valid_to' => array(
				'type' => 'date'
			),
			
			'paid' => array(
				'type' => 'VARCHAR',
				'constraint' => 1,
				'default' => 'F',
			),
		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('uid');
		$this->dbforge->create_table('membership');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;
		
		$this->db->drop_table('membership');
	}
}