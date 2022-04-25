<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('template', ['module' => 'admin']);
		$this->load->library('FPDF/Fpdf');
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

	public function is_owned_data($val, $str)
	{
		$str = explode('.', $str);
		$data = $this->db->get_where('user', array($str[1] => $val));
		if ($data->num_rows() >= 1)
		{
			if ($data->row()->id == $str[2])
			{
				return TRUE;
			}
			else
			{
				$this->form_validation->set_message('is_owned_data', lang('form_validation_is_unique'));
				return FALSE;
			}
		}
		else
		{
			return TRUE;
		}

		return FALSE;
	}

	public function jadwal()
	{
		$this->template->load('jadwal/home');
	}

	public function print_report($id = NULL)
	{
		$this->fpdf->SetTitle('Laporan Rekam Medis');
		$this->fpdf->SetAuthor($this->config->item('app_name'));
		$this->fpdf->AddPage();
		$this->fpdf->SetFont('Arial','B', 15);
		// Move to the right
		$this->fpdf->Cell(80);
		// Framed title
		$this->fpdf->Image(base_url('LOGO-BNN.png'), 10, 2, -440);
		$this->fpdf->Cell(-30);
		$this->fpdf->SetFont('Times', 'B', 16);
		$this->fpdf->Cell(120, 10, 'LAPORAN REKAM MEDIS PASIEN RAWAT JALAN', 0, 0, 'C');
		$this->fpdf->Ln(8);
		$this->fpdf->Cell(50);
		$this->fpdf->SetFont('Times', 'B', 14);
		$this->fpdf->Cell(120, 10, 'KLINIK PRATAMA BNN SUMUT', 0, 0, 'C');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(50);
		$this->fpdf->SetFont('Times', 'IU', 12);
		$this->fpdf->Cell(120, 10, 'Website : https://sumut.bnn.go.id', 0, 0, 'C');
		$this->fpdf->Ln(6);
		$this->fpdf->Cell(50);
		$this->fpdf->SetFont('Times', '', 12);
		$this->fpdf->Cell(120, 10, 'Alamat : Jl. Williem Iskandar Pasar V Barat I No. 1-A Medan Estate | Tel : (061) 800-3282', 0, 0, 'C');
		$this->fpdf->Ln(12);
		$this->fpdf->Cell(188, 1, '', 1, 0, 'L');
		$this->fpdf->Ln(6);


		$user = $this->user->read(array('id' => $id))->row();
		$rekam_medis = $this->rekam_medis->read(array('pasien' => $id))->result();
		$this->fpdf->SetFont('Times', 'BU', 14);
		$this->fpdf->Cell(200, 10, 'INFORMASI PASIEN', 0, 0, 'L');
		$this->fpdf->Ln(10);
		$this->fpdf->SetFont('Times', '', 12);
		$this->fpdf->Cell(60, 8, "\tNama Lengkap", 1, 0, 'L');
		$this->fpdf->Cell(80, 8, $user->full_name, 1, 0, 'L');
		$this->fpdf->Ln(8); // Line Break
		$this->fpdf->Cell(60, 8, "\tJenis Kelamin", 1, 0, 'L');
		$this->fpdf->Cell(80, 8, ($user->gender == 'male')?'Laki-laki':'Perempuan', 1, 0, 'L');
		$this->fpdf->Ln(8); // Line Break
		$this->fpdf->Cell(60, 8, "\tUsia", 1, 0, 'L');
		$this->fpdf->Cell(80, 8, ($user->age > 0)?$user->age:'-', 1, 0, 'L');
		$this->fpdf->Ln(8); // Line Break
		$this->fpdf->Cell(60, 8, "\tGolongan Darah", 1, 0, 'L');
		$this->fpdf->Cell(80, 8, $user->blood, 1, 0, 'L');
		$this->fpdf->Ln(8); // Line Break
		$this->fpdf->Cell(60, 8, "\tTanggal Mendaftar", 1, 0, 'L');
		$this->fpdf->Cell(80, 8, nice_date($user->registration_time, 'd F Y | H:i A'), 1, 0, 'L');
		$this->fpdf->Ln(20); // Line Break

		foreach ($rekam_medis as $data)
		{
			$this->fpdf->Cell(20, 8, "\tKode", 1, 0, 'L');
			$this->fpdf->Cell(124, 8, ': RM-'.$data->id, 1, 0, 'L');
			$this->fpdf->Ln(8); // Line Break
			$this->fpdf->Cell(20, 8, "\tTanggal", 1, 0, 'L');
			$this->fpdf->Cell(124, 8, ': '.nice_date($data->tanggal, 'd F Y'), 1, 0, 'L');
			$this->fpdf->Ln(8); // Line Break
			$this->fpdf->Cell(20, 8, "\tKeluhan", 1, 0, 'L');
			$this->fpdf->MultiCell(124, 8, ': '.$data->keluhan, 1, 'L');
			$this->fpdf->Ln(0); // Line Break
			$this->fpdf->Cell(20, 8, "\tDiagnosis", 1, 0, 'L');
			$this->fpdf->MultiCell(124, 8, ': '.$data->diagnosis, 1, 'L');
			$this->fpdf->Cell(20, 8, "\tSaran", 1, 0, 'L');
			$this->fpdf->MultiCell(124, 8, ': '.$data->saran, 1, 'L');
			$this->fpdf->Ln(6); // Line Break
			$this->fpdf->Cell(188, 0.2, '', 1, 0, 'L');
			$this->fpdf->Ln(6); // Line Break
		}

		$this->fpdf->Output();
	}

	public function logout()
	{
		session_destroy();
		redirect(base_url('/web/login'), 'refresh');
	}
}

/* End of file Dokter.php */
/* Location: ./application/controllers/Dokter.php */
