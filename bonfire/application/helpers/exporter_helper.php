<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('csvRequest'))
{
	function csvRequest($data, $name = 'export.csv')
	{
		$file;
		$error;
		$ci =& get_instance();
		if (csvExporter($file,$error,$data))
		{
			$ci->load->helper('download');
			force_download($name,$file);
		}
		else
		{
			die('Fail');
		}
	}
}

if (! function_exists('csvExporter'))
{
	/**
	 * @param file|null $file The CSV file stored
	 * @param array|null $error The error will be stored (if any)
	 * @param array $data The data that need to convert into CSV
	 * @return boolean The operation is successful or not
	 */

	function csvExporter(&$file,&$error, $data)
	{
		if (count($data) == 0)
		{
			$error = array('message' => 'Data is empty');
			return false;
		}

		$delimiter = ",";
		$newline = "\r\n";

		$ci =& get_instance();

		$ci->load->dbutil();

		$file = $ci->dbutil->csv_from_result($data,$delimiter,$newline);
		return true;
	}
}