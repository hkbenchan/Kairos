<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Insert_ref_table extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;
		
		/* values for status_ref */
		$data = array (
			array (
				'status_text' => 'Submitted'
			),
			
			array (
				'status_text' => 'Need more information (Refer content)'
			),
			
			array (
				'status_text' => 'Pending to solve'
			),
			
			array (
				'status_text' => 'Solved and please test again'
			),
			
			array (
				'status_text' => 'Solved and Closed'
			),
		);
		
		$this->db->insert_batch('bf_bugs_status_ref',$data);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;
		
		$this->db->empty_table('bf_bugs_status_ref');
	}
}