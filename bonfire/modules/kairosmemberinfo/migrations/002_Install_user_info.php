<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_user_info extends Migration {

	public function up()
	{
		$this->pre_setup_table();
		
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
			'kairosmemberinfo_firstname' => array(
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
			'kairosmemberinfo_nationalityID' => array(
				'type' => 'INT',
				'constraint' => 8,
				'unsigned' => TRUE
			),
			'kairosmemberinfo_gender' => array(
				'type' => 'enum',
				'constraint' => array('M','F'),
				
			),
			'kairosmemberinfo_UniversityID' => array(
				'type' => 'INT',
				'constraint' => 8,
				'unsigned' => TRUE
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
				'constraint' => 100
			),
			
			'kairosmemberinfo_newsletterUpdate' => array(
				'type' => 'enum',
				'constraint' => array('T','F'),
				
			),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key(array('entry_id','uid'));
		$this->dbforge->create_table('user_info');
		
		/* Link bf_user_info.uid with bf_users.id */
		$queries[] = "ALTER TABLE `bf_user_info` ADD FOREIGN KEY (`uid` ) REFERENCES  `kairosso_membership_info`.`bf_users` 
		(`id`) ON DELETE CASCADE";
		
		/* Link bf_user_info.nationalityID with bf_country.nid */
		$queries[] = "ALTER TABLE `bf_user_info` ADD FOREIGN KEY (`kairosmemberinfo_nationalityID` ) REFERENCES  
		`kairosso_membership_info`.`bf_country` (`nid`) ON DELETE RESTRICT ON UPDATE NO ACTION";
		
		/* Link bf_user_info.UniversityID with bf_university.uid */
		$queries[] = "ALTER TABLE `bf_user_info` ADD FOREIGN KEY (`kairosmemberinfo_UniversityID` ) REFERENCES 
		`kairosso_membership_info`.`bf_university` (`uid`) ON DELETE RESTRICT ON UPDATE NO ACTION";
		
		/* execute all queries */
		foreach ($queries as $query) {
			$result = $this->db->query($query);
			if (!$result) {
				show_error('Fail to install' , 500);
			}
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
		$this->dbforge->drop_table('user_preference');
		$this->dbforge->drop_table('preference');
	}

	//--------------------------------------------------------------------
	
	private function pre_setup_table()
	{
		$prefix = $this->db->dbprefix;
		
		/* CV table */
		$queries[] = "CREATE TABLE  `kairosso_membership_info`.`bf_CV` (
		`uid` BIGINT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`file` MEDIUMBLOB,
		FOREIGN KEY (`uid`) REFERENCES bf_users (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		
		/* University table */
		$queries[] = "CREATE TABLE  `kairosso_membership_info`.`bf_university` (
		`uid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 100 ) NOT NULL
		)";
		
		/* Country table */
		$queries[] = "CREATE TABLE  `kairosso_membership_info`.`bf_country` (
		`nid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 50 ) NOT NULL
		)";
		
		/* Industry table */
		$queries[] = "CREATE TABLE  `kairosso_membership_info`.`bf_industry` (
		`iid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`name` VARCHAR( 100 ) NOT NULL UNIQUE
		)";
		
		/* Venture table */
		$queries[] = "CREATE TABLE  `kairosso_membership_info`.`bf_venture` (
		`vid` INT( 8 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`uid` BIGINT( 20 ) UNSIGNED NOT NULL,
		`IndustryID` INT( 8 ) UNSIGNED NOT NULL,
		`name` VARCHAR( 100 ) NOT NULL,
		`descr` TEXT NOT NULL,
		FOREIGN KEY (`uid`) REFERENCES bf_users(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`IndustryID`) REFERENCES bf_industry(`iid`) ON DELETE RESTRICT ON UPDATE NO ACTION
		)";
		
		/* Preference table */
		$queries[] = "CREATE TABLE `kairosso_membership_info`.`bf_preference` (
		`pid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`description` VARCHAR( 100 ) NOT NULL
		)";
		
		/* User Preference table */
		$queries[] = "CREATE TABLE `kairosso_membership_info`.`bf_user_preference` (
		`pid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
		`uid` BIGINT( 20 ) UNSIGNED NOT NULL,
		PRIMARY KEY (`pid`,`uid`),
		FOREIGN KEY(`pid`) REFERENCES bf_preference(`pid`),
		FOREIGN KEY(`uid`) REFERENCES bf_users(`id`) ON DELETE CASCADE ON UPDATE CASCADE
		)";
		
		foreach ($queries as $query) {
			$result = $this->db->query($query);
			if (!$result) {
				show_error('Fail to run pre_setup' , 500);
			}
		}
	}
}