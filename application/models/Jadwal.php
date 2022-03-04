<?php
/**
 * @package Codeigniter
 * @subpackage Jadwal
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Jadwal extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('jadwal');
	}
}

/* End of file Jadwal.php */
/* Location : ./application/models/Jadwal.php */
