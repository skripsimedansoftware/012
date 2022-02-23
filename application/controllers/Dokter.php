<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template', ['module' => 'admin']);
		if (empty($this->session->userdata($this->router->fetch_class())))
		{
			redirect(base_url('web/login'), 'refresh');
		}
	}

	public function index()
	{
		$this->template->load('home');
	}

	public function profile($id = NULL, $option = NULL)
	{
		$data['profile'] = $this->user->read(array('id' => (!empty($id))?$id:$this->session->userdata(strtolower($this->router->fetch_class()))))->row();
		switch ($option)
		{
			case 'edit':
				if ($this->input->method() == 'post')
				{
					if ($id !== $this->session->userdata($this->router->fetch_class()) OR $id > $this->session->userdata($this->router->fetch_class()))
					{
						$this->session->set_flashdata('edit_profile', array('status' => 'failed', 'message' => 'Anda tidak memiliki akses untuk mengubah profil orang lain!'));
						redirect(base_url($this->router->fetch_class().'/profile/'.$id) ,'refresh');
					}

					$this->form_validation->set_data($this->input->post());
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_is_owned_data[user.email.'.strtolower($this->session->userdata($this->router->fetch_class()).']'));
					$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required|callback_is_owned_data[user.username.'.strtolower($this->session->userdata($this->router->fetch_class()).']'));
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');

					if ($this->form_validation->run() == TRUE)
					{
						$update_data = array(
							'email' => $this->input->post('email'),
							'username' => $this->input->post('username'),
							'full_name' => $this->input->post('full_name')
						);

						if (!empty($this->input->post('password')))
						{
							$update_data['password'] = sha1($this->input->post('password'));
						}

						if (!empty($_FILES['photo']))
						{
							$config['upload_path'] = './uploads/';
							$config['allowed_types'] = 'png|jpg|jpeg';
							$config['file_name'] = url_title('user-profile-'.$id);
							$this->load->library('upload', $config);

							if (!$this->upload->do_upload('photo'))
							{
								$this->session->set_flashdata('upload_photo_error', $this->upload->display_errors());
							}
							else
							{
								// resize
								$config['image_library']	= 'gd2';
								$config['source_image']		= $this->upload->data()['full_path'];
								$config['maintain_ratio']	= TRUE;
								$config['width']			= 160;
								$config['height']			= 160;
								// watermark
								$config['wm_text'] 			= strtolower($this->router->fetch_class());
								$config['wm_type'] 			= 'text';
								$config['wm_font_color'] 	= 'ffffff';
								$config['wm_font_size'] 	= 12;
								$config['wm_vrt_alignment'] = 'middle';
								$config['wm_hor_alignment'] = 'center';
								$this->load->library('image_lib', $config);

								if ($this->image_lib->resize())
								{
									$this->image_lib->watermark();
								}

								$update_data['photo'] = $this->upload->data()['file_name'];
							}
						}

						$this->user->update($update_data, array('id' => $id));
						$this->session->set_flashdata('edit_profile', array('status' => 'success', 'message' => 'Profil berhasil diperbaharui!'));
						redirect(base_url($this->router->fetch_class().'/profile/'.$id) ,'refresh');
					}
					else
					{
						$this->template->load('profile_edit', $data);
					}
				}
				else
				{
					$this->template->load('profile_edit', $data);
				}
			break;

			default:
				$this->template->load('profile', $data);
			break;
		}
	}

	public function logout()
	{
		session_destroy();
		redirect(base_url('/web/login'), 'refresh');
	}
}

/* End of file Dokter.php */
/* Location: ./application/controllers/Dokter.php */
