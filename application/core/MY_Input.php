<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage MY_Input
 * @category Libraries
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

class MY_Input extends CI_Input
{
	/**
	 * Post Data
	 *
	 * @param      string  $index    Index for item to be fetched from $_POST
	 * @param      mixed   $default  Set default value if property doesn't exists
	 *
	 * @return     mixed
	 */
	public function post_data($index, $default = NULL)
	{
		if (empty($this->post($index)))
		{
			$_POST[$index] = $default;
		}

		return $this->post($index);
	}

	/**
	 * Get Data
	 *
	 * @param      string  $index    Index for item to be fetched from $_GET
	 * @param      mixed   $default  Set default value if property doesn't exists
	 *
	 * @return     mixed
	 */
	public function get_data($index, $default = NULL)
	{
		if (empty($this->get($index)))
		{
			$_GET[$index] = $default;
		}

		return $this->get($index);
	}
}

/* End of file MY_Input.php */
/* Location : ./application/core/MY_Input.php */
