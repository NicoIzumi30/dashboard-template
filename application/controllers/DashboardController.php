<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('User');
		$this->User->middlewareAdmin();
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->view('administrator/layout/header',$data);
        $this->load->view('administrator/layout/sidebar',$data);
        $this->load->view('administrator/dashboard/index');
        $this->load->view('administrator/layout/footer');
    }
	public function datatable()
    {
        $data['title'] = 'Datatable';
        $this->load->view('administrator/layout/header',$data);
        $this->load->view('administrator/layout/sidebar',$data);
        $this->load->view('administrator/dashboard/datatable');
        $this->load->view('administrator/layout/footer');
    }

}
