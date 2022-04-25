<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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

	public function dokter($option = 'view', $id = NULL)
	{
		switch ($option)
		{
			case 'add':
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
					$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required');
					$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required|min_length[5]');
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
					$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required|in_list[male,female]');
					$this->form_validation->set_rules('status', 'Status Akun', 'trim|required|in_list[active,non-active]');

					if ($this->form_validation->run() == TRUE)
					{
						$data = array(
							'role' => 'dokter',
							'email' => $this->input->post('email'),
							'username' => $this->input->post('username'),
							'password' => sha1($this->input->post('password')),
							'full_name' => $this->input->post('full_name'),
							'gender' => $this->input->post('gender'),
							'status' => $this->input->post('status')
						);

						$this->user->create($data);
						$this->session->set_flashdata('data_query', 'Data dokter telah ditambahkan');
						redirect(base_url($this->router->fetch_class().'/dokter'), 'refresh');
					}
					else
					{
						$this->template->load('dokter/add');
					}
				}
				else
				{
					$this->template->load('dokter/add');
				}
			break;

			case 'edit':
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
					$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required');
					$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|min_length[5]');
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
					$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required|in_list[male,female]');

					if ($this->form_validation->run() == TRUE)
					{
						$find = $this->user->read(array('id' => $id))->row();
						$data = array(
							'email' => $this->input->post_data('email', $find->email),
							'username' => $this->input->post_data('username', $find->username),
							'full_name' => $this->input->post_data('full_name', $find->full_name),
							'gender' => $this->input->post_data('gender', $find->gender),
							'status' => $this->input->post('status')
						);

						$data['password'] = (!empty($this->input->post('password')))?sha1($this->input->post('password')):$find->password;

						$this->user->update($data, array('id' => $id));
						$this->session->set_flashdata('data_query', 'Data dokter telah diperbaharui');
						redirect(base_url($this->router->fetch_class().'/dokter'), 'refresh');
					}
					else
					{
						$data['data'] = $this->user->read(array('id' => $id))->row();
						$this->template->load('dokter/edit', $data);
					}
				}
				else
				{
					$data['data'] = $this->user->read(array('id' => $id))->row();
					$this->template->load('dokter/edit', $data);
				}
			break;

			case 'delete':
				$this->user->delete(array('id' => $id));
				$this->session->set_flashdata('data_query', 'Akun dokter telah dihapus');
				redirect(base_url($this->router->fetch_class().'/dokter'), 'refresh');
			break;

			default:
				if (!empty($id))
				{
					$data['data'] = $this->user->read(array('id' => $id))->row();
					$this->template->load('dokter/view', $data);
				}
				else
				{
					$this->template->load('dokter/home');
				}
			break;
		}
	}

	public function pasien($option = 'view', $id = NULL)
	{
		switch ($option)
		{
			case 'add':
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
					$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required');
					$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required|min_length[5]');
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
					$this->form_validation->set_rules('age', 'Usia', 'trim|required');
					$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required|in_list[male,female]');
					$this->form_validation->set_rules('blood', 'Golongan Darah', 'trim|required|in_list[A,B,AB,O,A+,B+,AB+,O+]');
					$this->form_validation->set_rules('status', 'Status Akun', 'trim|required|in_list[active,non-active]');

					if ($this->form_validation->run() == TRUE)
					{
						$data = array(
							'role' => 'pasien',
							'email' => $this->input->post('email'),
							'username' => $this->input->post('username'),
							'password' => sha1($this->input->post('password')),
							'full_name' => $this->input->post('full_name'),
							'gender' => $this->input->post('gender'),
							'age' => $this->input->post('age'),
							'blood' => $this->input->post('blood'),
							'status' => $this->input->post('status')
						);

						$this->user->create($data);
						$this->session->set_flashdata('data_query', 'Data pasien telah ditambahkan');
						redirect(base_url($this->router->fetch_class().'/pasien'), 'refresh');
					}
					else
					{
						$this->template->load('pasien/add');
					}
				}
				else
				{
					$this->template->load('pasien/add');
				}
			break;

			case 'edit':
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
					$this->form_validation->set_rules('username', 'Nama Pengguna', 'trim|required');
					$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|min_length[5]');
					$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');
					$this->form_validation->set_rules('age', 'Usia', 'trim|required');
					$this->form_validation->set_rules('gender', 'Jenis Kelamin', 'trim|required|in_list[male,female]');
					$this->form_validation->set_rules('blood', 'Golongan Darah', 'trim|required|in_list[A,B,AB,O,A+,B+,AB+,O+]');

					if ($this->form_validation->run() == TRUE)
					{
						$find = $this->user->read(array('id' => $id))->row();
						$data = array(
							'email' => $this->input->post_data('email', $find->email),
							'username' => $this->input->post_data('username', $find->username),
							'full_name' => $this->input->post_data('full_name', $find->full_name),
							'gender' => $this->input->post_data('gender', $find->gender),
							'age' => $this->input->post_data('age', $find->age),
							'blood' => $this->input->post_data('blood', $find->blood),
							'photo' => NULL,
							'status' => $this->input->post('status')
						);

						$data['password'] = (!empty($this->input->post('password')))?sha1($this->input->post('password')):$find->password;

						$this->user->update($data, array('id' => $id));
						$this->session->set_flashdata('data_query', 'Data pasien telah diperbaharui');
						redirect(base_url($this->router->fetch_class().'/pasien'), 'refresh');
					}
					else
					{
						$data['data'] = $this->user->read(array('id' => $id))->row();
						$this->template->load('pasien/edit', $data);
					}
				}
				else
				{
					$data['data'] = $this->user->read(array('id' => $id))->row();
					$this->template->load('pasien/edit', $data);
				}
			break;

			case 'activate':
				$this->user->update(array('status' => $this->input->get('status')), array('id' => $id));
				$status = ($this->input->get('status') == 'active')?'aktif':'non-aktif';
				$this->session->set_flashdata('data_query', 'Akun pasien telah '.$status);
				redirect(base_url($this->router->fetch_class().'/pasien'), 'refresh');
			break;

			case 'delete':
				$this->user->delete(array('id' => $id));
				$this->session->set_flashdata('data_query', 'Akun pasien telah dihapus');
				redirect(base_url($this->router->fetch_class().'/pasien'), 'refresh');
			break;

			default:
				if (!empty($id))
				{
					$data['data'] = $this->user->read(array('id' => $id))->row();
					$this->template->load('pasien/view', $data);
				}
				else
				{
					$this->template->load('pasien/home');
				}
			break;
		}
	}

	public function jadwal($option = 'view', $id = NULL)
	{
		$waktu = NULL;
		if (!empty($this->input->post('waktu')))
		{
			$waktu = preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})/i', $this->input->post('waktu'), $matches);
			$waktu = $matches[3].'-'.$matches[1].'-'.$matches[2].' '.$matches[4].':'.$matches[5].':00';
		}

		switch ($option)
		{
			case 'add':
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('pasien', 'Pasien', 'trim|required');
					$this->form_validation->set_rules('dokter', 'Dokter', 'trim|required');
					$this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
					if ($this->form_validation->run() == TRUE)
					{
						$valid_date = validateDate($waktu);

						if (!$valid_date)
						{
							$this->session->set_flashdata('data_query', 'Format waktu tidak sesuai');
							redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
						}

						$data = array(
							'pasien' => $this->input->post('pasien'),
							'dokter' => $this->input->post('dokter'),
							'waktu' => $waktu,
							'status' => 'dijadwalkan',
							'catatan' => $this->input->post('catatan')
						);

						$this->jadwal->create($data);
						$this->session->set_flashdata('data_query', 'Data jadwal telah dibuat');
						redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
					}
					else
					{
						$this->template->load('jadwal/add');
					}
				}
				else
				{
					$this->template->load('jadwal/add');
				}
			break;

			case 'edit':
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('pasien', 'Pasien', 'trim|required');
					$this->form_validation->set_rules('dokter', 'Dokter', 'trim|required');
					$this->form_validation->set_rules('waktu', 'Waktu', 'trim|required');
					if ($this->form_validation->run() == TRUE)
					{
						$valid_date = validateDate($waktu);

						if (!$valid_date)
						{
							$this->session->set_flashdata('data_query', 'Format waktu tidak sesuai');
							redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
						}

						$data = array(
							'pasien' => $this->input->post('pasien'),
							'dokter' => $this->input->post('dokter'),
							'waktu' => $waktu,
							'catatan' => $this->input->post('catatan')
						);

						$this->jadwal->update($data, array('id' => $id));
						$this->session->set_flashdata('data_query', 'Data jadwal telah diperbaharui');
						redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
					}
					else
					{
						$data['data'] = $this->jadwal->read(array('id' => $id))->row();
						$this->template->load('jadwal/edit', $data);
					}
				}
				else
				{
					$data['data'] = $this->jadwal->read(array('id' => $id))->row();
					$this->template->load('jadwal/edit', $data);
				}
			break;

			case 'done':
				$this->jadwal->update(array('status' => 'selesai'), array('id' => $id));
				$this->session->set_flashdata('data_query', 'Jadwal praktek telah dijalankan');
				redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
			break;

			case 'delete':
				$this->jadwal->delete(array('id' => $id));
				$this->session->set_flashdata('data_query', 'Data jadwal telah dihapus');
				redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
			break;

			default:
				$this->template->load('jadwal/home');
			break;
		}
	}

	public function rekam_medis($option = 'view', $id = NULL)
	{
		$tanggal = NULL;

		if (!empty($this->input->post('tanggal')))
		{
			$tanggal = explode('/', $this->input->post('tanggal'));
			$tanggal_available = array();
			foreach ($tanggal as $dl)
			{
				if (!in_array($dl, ['dd', 'mm', 'yyyy']))
				{
					array_push($tanggal_available, $dl);
				}
			}

			if (count($tanggal_available) == 3)
			{
				$tanggal[2] = explode(' ', $tanggal[2])[0];
				$tanggal = $tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0];
			}
			else
			{
				$tanggal = NULL;
			}
		}

		switch ($option)
		{
			case 'add':
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('pasien', 'Pasien', 'trim|required');
					$this->form_validation->set_rules('jadwal', 'Jadwal', 'trim|required');
					$this->form_validation->set_rules('keluhan', 'Keluhan', 'trim');
					$this->form_validation->set_rules('diagnosis', 'Diagnosis', 'trim|required');
					$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

					if (!empty($id))
					{
						$rekam_medis = $this->rekam_medis->read(array('jadwal' => $id));
						if ($rekam_medis->num_rows() >= 1)
						{
							redirect(base_url($this->router->fetch_class().'/rekam_medis/edit/'.$rekam_medis->row()->id), 'refresh');
						}
					}

					if ($this->form_validation->run() == TRUE)
					{
						$data = array(
							'pasien' => $this->input->post('pasien'),
							'jadwal' => $this->input->post('jadwal'),
							'keluhan' => $this->input->post('keluhan'),
							'diagnosis' => $this->input->post('diagnosis'),
							'saran' => $this->input->post('saran'),
							'tanggal' => $tanggal
						);

						$this->rekam_medis->create($data);
						$this->session->set_flashdata('data_query', 'Data rekam medis telah ditambahkan');
						redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
					}
					else
					{
						$data['jadwal'] = $this->jadwal->read(array('id' => $id))->row();
						$this->template->load('rekam_medis/add', $data);
					}
				}
				else
				{
					$data['jadwal'] = $this->jadwal->read(array('id' => $id))->row();
					$this->template->load('rekam_medis/add', $data);
				}
			break;

			case 'edit':
				$rekam_medis = $this->rekam_medis->read(array('id' => $id));
				if ($this->input->method() == 'post')
				{
					$this->form_validation->set_rules('pasien', 'Pasien', 'trim|required');
					$this->form_validation->set_rules('keluhan', 'Keluhan', 'trim');
					$this->form_validation->set_rules('diagnosis', 'Diagnosis', 'trim|required');
					$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

					if ($this->form_validation->run() == TRUE)
					{
						$data = array(
							'pasien' => $this->input->post('pasien'),
							'keluhan' => $this->input->post('keluhan'),
							'diagnosis' => $this->input->post('diagnosis'),
							'saran' => $this->input->post('saran'),
							'tanggal' => $tanggal
						);

						$this->rekam_medis->update($data, array('id' => $id));
						$this->session->set_flashdata('data_query', 'Data rekam medis telah diperbaharui');
						redirect(base_url($this->router->fetch_class().'/jadwal'), 'refresh');
					}
					else
					{
						$data['rekam_medis'] = $rekam_medis->row();
						$this->template->load('rekam_medis/edit', $data);
					}
				}
				else
				{
					$data['rekam_medis'] = $rekam_medis->row();
					$this->template->load('rekam_medis/edit', $data);
				}
			break;
		}
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

	public function logout()
	{
		session_destroy();
		redirect(base_url('/web/login'), 'refresh');
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */
