<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User');
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $this->User->validateCredentials();
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('administrator/auth/index');
        } else {
            $data = [
                'username' => htmlspecialchars($this->input->post('username')),
                'password' => $this->input->post('password')
            ];
            $this->User->login($data);
        }
    }

    public function logout()
    {
        $this->User->logout();
    }
}
