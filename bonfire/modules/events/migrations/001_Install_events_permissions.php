<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_events_permissions extends Migration {

	// permissions to migrate
	private $permission_values = array(
		array('name' => 'Events.Content.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Content.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Content.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Content.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Reports.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Reports.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Reports.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Reports.Delete', 'description' => '', 'status' => 'active',),
		/*array('name' => 'Events.Settings.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Settings.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Settings.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Settings.Delete', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Developer.View', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Developer.Create', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Developer.Edit', 'description' => '', 'status' => 'active',),
		array('name' => 'Events.Developer.Delete', 'description' => '', 'status' => 'active',),*/
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