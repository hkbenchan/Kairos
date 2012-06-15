<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_user_info extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'entry_id' => array(
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
			'kairosmemberinfo_surname' => array(
				'type' => 'VARCHAR',
				'constraint' => 32,
				
			),
			'kairosmemberinfo_middlename' => array(
				'type' => 'VARCHAR',
				'constraint' => 32,
				'NULL' => TRUE
			),
			'kairosmemberinfo_lastname' => array(
				'type' => 'VARCHAR',
				'constraint' => 32,
				
			),
			'kairosmemberinfo_dob' => array(
				'type' => 'DATE',
				'default' => '0000-00-00',
				
			),
			'kairosmemberinfo_nationality_id' => array(
				'type' => 'INT',
				'constraint' => 8,
				
			),
			'kairosmemberinfo_gender' => array(
				'type' => 'enum',
				'constraint' => array('M','F'),
				
			),
			'kairosmemberinfo_UniversityID' => array(
				'type' => 'INT',
				'constraint' => 8,
				
			),
			'kairosmemberinfo_yearOfStudy' => array(
				'type' => 'enum',
				'constraint' => array('0','1','2','3','4','Others'),
				
			),
			'kairosmemberinfo_phoneNo' => array(
				'type' => 'VARCHAR',
				'constraint' => 14,
				
			),
			'kairosmemberinfo_ownVenture' => array(
				'type' => 'enum',
				'constraint' => array('T','F')
			),
			
			'kairosmemberinfo_skills' => array(
				'type' => 'VARCHAR',
				'constraint' => 50
			),
			
			'kairosmemberinfo_newsletterUpdate' => array(
				'type' => 'enum',
				'constraint' => array('T','F'),
				
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key(array('entry_id','uid'));
		$this->dbforge->create_table('user_info');
		
		/* Edit the table to link bf_user_info.id with bf_users.id */
		$query = "ALTER TABLE `bf_user_info` ADD FOREIGN KEY (`uid` ) REFERENCES  `KairosDatabase`.`bf_users` (
		`id`) ON DELETE CASCADE";
		
		$query = $this->db->query($query);
		if (!($query))
		{
			show_error('message' , 500);
		}
		
		

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;
		
		$this->dbforge->drop_table('user_info');
		
		/* self-defined tables */
		$this->dbforge->drop_table('venture');
		$this->dbforge->drop_table('country');
		$this->dbforge->drop_table('industry');
		$this->dbforge->drop_table('CV');
		$this->dbforge->drop_table('university');

	}

	//--------------------------------------------------------------------
	
	private function pre_setup_table()
	{
		$prefix = $this->db->dbprefix;
		
		/* CV table */
		$queries[] = "CREATE TABLE  `KairosDatabase`.`bf_CV` (
		`uid` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`file` MEDIUMBLOB,
		FOREIGN KEY (`uid`) REFERENCES bf_users (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE = INNODB;";
		
		/* University table */
		$queries[] = "CREATE TABLE  `KairosDatabase`.`bf_university` (
		`uid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 100 ) NOT NULL
		) ENGINE = INNODB;";
		
		/* Country table */
		$queries[] = "CREATE TABLE  `KairosDatabase`.`bf_country` (
		`nid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 50 ) NOT NULL
		) ENGINE = INNODB;";
		
		/* Industry table */
		$queries[] = "CREATE TABLE  `KairosDatabase`.`bf_industry` (
		`iid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 100 ) NOT NULL UNIQUE
		) ENGINE = INNODB;";
		
		/* Venture table */
		$queries[] = "CREATE TABLE  `KairosDatabase`.`bf_venture` (
		`vid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`uid` BIGINT( 20 ) UNSIGNED NOT NULL,
		`IndustryID` INT( 8 ) UNSIGNED NOT NULL,
		`name` VARCHAR( 100 ) NOT NULL,
		`descr` TEXT NOT NULL,
		FOREIGN KEY (`uid`) REFERENCES bf_users(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`IndustryID`) REFERENCES bf_industry(`iid`) ON DELETE RESTRICT ON UPDATE NO ACTION
		) ENGINE = INNODB;";
		
		
		
		foreach ($queries as $query) {
			$result = $this->db->query($query);
			if (!$result) {
				show_error('Fail to run pre_setup' , 500);
			}
		}
	}
}