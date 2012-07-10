<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('csvRequest'))
{
	function csvRequest($data, $name = 'export.csv')
	{
		$file;
		$error;
		if (!$this->csvExporter($file,$error,$data))
		{
			echo 'fail';
			die();
		}
		else
		{
			$this->load->helper('download');
			force_download($name,$file);
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
		$this->auth->restrict('KairosMemberInfo.Reports.View');

		if (count($data) == 0)
		{
			$error = array('message' => 'Data is empty');
			return false;
		}

		$delimiter = ",";
		$newline = "\r\n";

		$this->load->dbutil();

		$file = $this->dbutil->csv_from_result($data,$delimiter,$newline);
		return true;
	}
}