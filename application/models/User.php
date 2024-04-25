<?php
class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function validateCredentials()
    {
        if ($this->session->userdata('user_id')) {
            if ($this->session->userdata('role') == 'user') {
                return redirect('home');
            } elseif ($this->session->userdata('role') == 'admin') {
                return redirect('dashboard');
            }
        }
    }
    public function is_logged_in()
    {
        if ($this->session->userdata('user_id')) {
            return true;
        } else {
            return false;
        }
    }
	public function middlewareAdmin(){
		if ($this->session->userdata('user_id')) {
            if ($this->session->userdata('role') == 'user') {
                return redirect('home');
            } elseif ($this->session->userdata('role') == 'admin') {
                return true;
            }
        }
	} 

    public function login($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $user = $this->db->get_where('users', ['username' => $username])->row_array();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data_session = [
                    'user_id' => $user['id'],
                    'role' => $user['role']
                ];
                $this->session->set_userdata($data_session);
                if ($user['role'] == 'admin') {
                    return redirect('dashboard');
                } elseif ($user['role'] == 'user') {
                    return redirect('home');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Username atau Password Salah
              </div>');
                return redirect('login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Akun Tidak Ditemukan
      </div>');
            return redirect('login');
        }
    }
    public function register($data)
    {
        $this->db->insert('users', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Selamat! Akun anda telah dibuat. Silahkan masuk
      </div>');
        return redirect('login');
    }
    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('role');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Anda telah berhasil keluar dari akun Anda.
      </div>');
        return redirect('login');
    }
}
