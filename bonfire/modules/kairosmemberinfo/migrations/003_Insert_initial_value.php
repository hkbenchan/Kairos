<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Insert_initial_value extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;
		
		/* values for university */
		$data_u = array (
			array (
				'name' => 'The University of Hong Kong'
			),
			
			array (
				'name' => 'The Chinese University of Hong Kong'
			),
			
			array (
				'name' => 'The Hong Kong University of Science and Technology'
			),
			
			array (
				'name' => 'The Hong Kong Polytechnic University'
			),
			
			array (
				'name' => 'City University of Hong Kong'
			),
			
			array (
				'name' => 'Hong Kong Baptist University'
			),
			
			array (
				'name' => 'Lingnan University'
			),
			
			array (
				'name' => 'Hong Kong Shue Yan University'
			),
			
			array (
				'name' => 'The Hong Kong Institute of Education'
			),
			
			array (
				'name' => 'The Open University of Hong Kong'
			),
			
			array (
				'name' => 'Other'
			),
		);
		
		$this->db->insert_batch('bf_university',$data_u);
		
		/* values for industry */
		$data_i = array (
			array (
				'name' => 'Accounting'
			),
			
			array (
				'name' => 'Art'
			),
			
			array (
				'name' => 'Banking'
			),
			
			array (
				'name' => 'Education'
			),
			
			array (
				'name' => 'Engineering'
			),
			
			array (
				'name' => 'Finance'
			),
			
			array (
				'name' => 'Food'
			),
			
			array (
				'name' => 'Information and Technology'
			),
			
			array (
				'name' => 'Marketing'
			),
			
			array (
				'name' => 'Medicine'
			),
			
			array (
				'name' => 'Real Eastate'
			),
			
			array (
				'name' => 'Transportation'
			),
			
			array (
				'name' => 'Venture Capitalist'
			),
			
			array (
				'name' => 'Other'
			),
		);
		
		$this->db->insert_batch('bf_industry',$data_i);
		
		/* values for country */
		$data_c = array (
			array (
				'name' => 'Afghanistan'
			),
			
			array (
				'name' => 'Bahrain'
			),
			
			array (
				'name' => 'Bangladesh'
			),
			
			array (
				'name' => 'Bhutan'
			),
			
			array (
				'name' => 'Brunei'
			),
			
			array (
				'name' => 'Burma (Myanmar)'
			),
			
			array (
				'name' => 'Cambodia'
			),
			
			array (
				'name' => 'China'
			),
			
			array (
				'name' => 'East Timor'
			),
			
			array (
				'name' => 'India'
			),
			
			array (
				'name' => 'Indonesia'
			),
			
			array (
				'name' => 'Iran'
			),
			
			array (
				'name' => 'Iraq'
			),
			
			array (
				'name' => 'Israel'
			),
			
			array (
				'name' => 'Japan'
			),
			
			array (
				'name' => 'Jordan'
			),
			
			array (
				'name' => 'Kazakhstan'
			),
			
			array (
				'name' => 'Korea, North'
			),
			
			array (
				'name' => 'Korea, South'
			),
			
			array (
				'name' => 'Kuwait'
			),
			
			array (
				'name' => 'Kyrgyzstan'
			),
			
			array (
				'name' => 'Laos'
			),
			
			array (
				'name' => 'Lebanon'
			),
			
			array (
				'name' => 'Malaysia'
			),
			
			array (
				'name' => 'Maldives'
			),
			
			array (
				'name' => 'Mongolia'
			),
			
			array (
				'name' => 'Nepal'
			),
			
			array (
				'name' => 'Oman'
			),
			
			array (
				'name' => 'Pakistan'
			),
			
			array (
				'name' => 'Philippines'
			),
			
			array (
				'name' => 'Qatar'
			),
			
			array (
				'name' => 'Russian Federation'
			),
			
			array (
				'name' => 'Saudi Arabia'
			),
			
			array (
				'name' => 'Singapore'
			),
			
			array (
				'name' => 'Sri Lanka'
			),
			
			array (
				'name' => 'Syria'
			),
			
			array (
				'name' => 'Tajikistan'
			),
			
			array (
				'name' => 'Thailand'
			),
			
			array (
				'name' => 'Turkey'
			),
			
			array (
				'name' => 'Turkmenistan'
			),
			
			array (
				'name' => 'United Arab Emirates'
			),
			
			array (
				'name' => 'Uzbekistan'
			),
			
			array (
				'name' => 'Vietnam'
			),
			
			array (
				'name' => 'Yemen'
			),
			
			array (
				'name' => 'Hong Kong'
			),
			
			array (
				'name' => 'Macau'
			),
			
			array (
				'name' => 'Others'
			)	
		);
		
		$this->db->insert_batch('bf_country',$data_c);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;
		
		$this->db->empty_table('bf_university');
		$this->db->empty_table('bf_industry');
		$this->db->empty_table('bf_country');
	}
}