<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_bugs_report_permissions extends Migration {

	// permissions to migrate
	private $permission_values = array(
		array('name' => 'Bugs_report.Content.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Content.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Content.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Content.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Reports.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Reports.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Reports.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Reports.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Settings.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Settings.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Settings.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Settings.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Developer.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Developer.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Developer.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Bugs_report.Developer.Delete', 'description' => '', 'status' => 'active',),
	);

	//--------------------------------------------------------------------

	public function up()
	{
		$prefix = $this->db->dbprefix;

		// permissions
		foreach ($this->permission_values as $permission_value)
		{
			$permissions_data = $permission_value;
			$this->db->insert("{$prefix}permissions", $permissions_data);
			$role_permissions_data = array('role_id' => '1', 'permission_id' => $this->db->insert_id(),);
			$this->db->insert("{$prefix}role_permissions", $role_permissions_data);
		}
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

        // permissions
		foreach ($this->permission_values as $permission_value)
		{
			$query = $this->db->select('permission_id')->get_where("{$prefix}permissions", array('name' => $permission_value['name'],));
			foreach ($query->result_array() as $row)
			{
				$permission_id = $row['permission_id'];
				$this->db->delete("{$prefix}role_permissions", array('permission_id' => $permission_id));
			}
			$this->db->delete("{$prefix}permissions", array('name' => $permission_value['name']));

		}
	}

	//--------------------------------------------------------------------

}