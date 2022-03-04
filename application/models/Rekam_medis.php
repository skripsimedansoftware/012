<?php
/**
 * @package Codeigniter
 * @subpackage Rekam_medis
 * @category Model
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

namespace Angeli;

class Rekam_medis extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->set_table('rekam-medis');
	}
}

/* End of file Rekam_medis.php */
/* Location : ./application/models/Rekam_medis.php */
