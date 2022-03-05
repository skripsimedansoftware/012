<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template
{
	protected $ci;

	protected $module;

	public function __construct($config)
	{
        $this->ci =& get_instance();
        if (isset($config['module'])) {
        	$this->module = $config['module'];
        }
	}

	public function set_module($module)
	{
		$this->module = $module;
	}

	public function load($page, $params = array())
	{
		if ($this->ci->session->has_userdata('admin'))
		{
			$data['user'] = $this->ci->user->read(array('id' => $this->ci->session->userdata('admin')))->row();
		}
		elseif ($this->ci->session->has_userdata('dokter'))
		{
			$data['user'] = $this->ci->user->read(array('id' => $this->ci->session->userdata('dokter')))->row();
		}
		else
		{
			$data['user'] = $this->ci->user->read(array('id' => $this->ci->session->userdata('pasien')))->row();
		}
		$data['page'] = $this->ci->load->view($this->module.'/'.$page, array_merge($params, $data), TRUE);
		$this->ci->load->view($this->module.'/base', array_merge($data, $params), FALSE);
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
