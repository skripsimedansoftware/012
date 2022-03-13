<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page'] = $this->load->view('web/home', array(), TRUE);
		$this->load->view('web/base', $data);
	}

	public function login()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('identity', 'Email / Nama Pengguna', 'trim|required');
			$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$user = $this->user->sign_in($this->input->post('identity'), $this->input->post('password'));
				if ($user->num_rows() >= 1)
				{
					if ($user->row()->status == 'active')
					{
						$this->session->set_userdata($user->row()->role, $user->row()->id);
						redirect(base_url($user->row()->role), 'refresh');
					}
					else
					{
						$this->session->set_flashdata('login', array('status' => 'failed', 'message' => 'Akun anda belum diaktifkan'));
						redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
					}
				}
				else
				{
					if ($this->user->search($this->input->post('identity'))->num_rows() >= 1)
					{
						$this->session->set_flashdata('login', array('status' => 'failed', 'message' => 'Kata sandi tidak sesuai'));
						redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
					}
					else
					{
						$this->session->set_flashdata('login', array('status' => 'failed', 'message' => 'Akun tidak ditemukan'));
						redirect(base_url($this->router->fetch_class().'/'.$this->router->fetch_method()), 'refresh');
					}
				}
			}
			else
			{
				$this->load->view('auth/login');
			}
		}
		else
		{
			$this->load->view('auth/login');
		}
	}

	public function register()
	{
		if ($this->input->method() == 'post')
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Kata Sandi', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('full_name', 'Nama Lengkap', 'trim|required');

			if ($this->form_validation->run() == TRUE)
			{
				$data = array(
					'role' => 'pasien',
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password')),
					'full_name' => $this->input->post('full_name'),
					'registration_time' => nice_date(unix_to_human(now()), 'Y-m-d H:i:s'),
					'status' => 'non-active'
				);

				$this->user->create($data);
				$this->session->set_flashdata('register', array('status' => 'success', 'message' => 'Pendaftaran berhasil!!'));
				redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
			}
			else
			{
				$this->load->view('auth/register');
			}
		}
		else
		{
			$this->load->view('auth/register');
		}
	}

	public function forgot_password()
	{
		if ($this->input->method() == 'post')
		{
			$search = $this->user->search($this->input->post('identity'));

			if ($search->num_rows() >= 1)
			{
				$code = random_string('numeric', 6);
				$this->load->library('email');
				$this->email->set_alt_message('Reset password');
				$this->email->to($search->row()->email);
				$this->email->from($this->config->item('smtp_user'), 'Skripsi');
				$this->email->subject('Ganti Kata Sandi');
				$data['link'] = base_url($this->router->fetch_class().'/reset_password/'.$code);
				$data['code'] = $code;
				$data['full_name'] = $search->row()->full_name;
				$this->email->message($this->load->view('email/reset_password', $data, TRUE));
				if (!$this->email->send())
				{
					$this->session->set_flashdata('forgot_password', array('status' => 'failed', 'message' => 'Sistem tidak bisa mengirim email!'));
					redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
				}
				else
				{
					$this->email_confirm->new_code($search->row()->id, $code, 'reset-password');
					$this->session->set_flashdata('forgot_password', array('status' => 'success', 'message' => 'Email permintaan atur ulang kata sandi sudah dikirim, silahkan verifikasi <a href="'.base_url($this->router->fetch_class().'/email_confirm').'">disini</a>'));
					redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('forgot_password', array('status' => 'failed', 'message' => 'Sistem tidak menemukan akun!'));
				redirect(base_url($this->router->fetch_class().'/forgot_password'), 'refresh');
			}
		}
		else
		{
			$this->load->view('auth/forgot_password');
		}
	}

	/**
	 * Confirm email
	 *
	 * @param      integer  $code   Confirmation code
	 */
	public function email_confirm($code = NULL)
	{
		$data = array();

		if (!empty($code))
		{
			$data = array('confirm_code' => $code);
		}

		if ($this->input->method() == 'post')
		{
			$data = $this->input->post();
			$this->form_validation->set_rules('confirm_code', 'Confirm Code', 'trim|required');
			if ($this->form_validation->run() == TRUE)
			{
				$email_confirm = $this->email_confirm->review_confirm_code($data['confirm_code']);
				if ($email_confirm->num_rows() >= 1)
				{
					$email_confirm = $email_confirm->row();

					if ($email_confirm->status == 'unconfirmed')
					{
						if (now() < human_to_unix($email_confirm->expire_date))
						{
							if ($email_confirm->type == 'account-activation')
							{
								$this->email_confirm->confirm($data['confirm_code']);
								redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
							}
							elseif ($email_confirm->type == 'reset-password')
							{
								$this->session->set_userdata('reset-password', $email_confirm->user_uid);
								$this->email_confirm->confirm($data['confirm_code']);
								redirect(base_url($this->router->fetch_class().'/reset_password'), 'refresh');
							}
							else
							{
								redirect(base_url(), 'refresh');
							}
						}
						else
						{
							$this->session->set_flashdata('email_confirm', array('status' => 'warning', 'message' => 'Masa waktu kode sudah habis'));
							redirect(base_url($this->router->fetch_class().'/email_confirm'), 'refresh');
						}
					}
					else
					{
						$this->session->set_flashdata('email_confirm', array('status' => 'warning', 'message' => 'Kode sudah pernah digunakan'));
						redirect(base_url($this->router->fetch_class().'/email_confirm'), 'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('email_confirm', array('status' => 'error', 'message' => 'Kode tidak ditemukan'));
					redirect(base_url($this->router->fetch_class().'/email_confirm'), 'refresh');
				}
			}
			else
			{
				$this->load->view('auth/email_confirm');
			}
		}
		else
		{
			$this->load->view('auth/email_confirm');
		}
	}

	public function reset_password($code = NULL)
	{
		if ($this->input->method() == 'post')
		{
			if ($this->session->has_userdata('reset-password'))
			{
				$this->form_validation->set_rules('new_password', 'Kata Sandi', 'trim|required');
				$this->form_validation->set_rules('repeat_new_password', 'Ulangi Kata Sandi', 'trim|required|matches[new_password]');

				if ($this->form_validation->run() == TRUE)
				{
					if ($this->user->update(array('password' => sha1($this->input->post('new_password'))), array('id' => $this->session->userdata('reset-password'))))
					{
						$this->session->unset_userdata('reset-password');
					}

					redirect(base_url($this->router->fetch_class().'/login'), 'refresh');
				}
				else
				{
					$this->load->view('admin/reset_password');
				}
			}
		}
		else
		{
			if ($this->session->has_userdata('reset-password'))
			{
				$this->load->view('admin/reset_password');
			}
			else
			{
				show_404();
			}
		}
	}
}
