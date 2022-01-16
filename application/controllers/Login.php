<?php
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_login');
        $this->load->library('session');
    }
    public function index()
    {
        $this->load->view('login');
    }
    public function logout()
    {
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('keyword_penjualan');
        $this->session->unset_userdata('keyword_pembelian');
        $this->session->set_flashdata('message', '<div class="alert alert-danger  text-center" role="alert">
        Logout Berhasil
        </div>');
        redirect('login');
    }
    public function logout_supp()
    {
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('id_supp');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('keyword_penjualan');
        $this->session->unset_userdata('keyword_pembelian');
        $this->session->set_flashdata('message', '<div class="alert alert-danger  text-center" role="alert">
        Logout Berhasil
        </div>');
        redirect('login/login_supp');
    }
    public function logout_bandar()
    {
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('id_bandar');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('keyword_penjualan');
        $this->session->unset_userdata('keyword_pembelian');
        $this->session->set_flashdata('message', '<div class="alert alert-danger  text-center" role="alert">
        Logout Berhasil
        </div>');
        redirect('login/login_bandar');
    }
    function wrong_password()
    {
        $this->load->view('page/wrong_password');
    }
    function wrong_password_supp()
    {
        $this->load->view('page/wrong_password_supp');
    }
    function wrong_password_bandar()
    {
        $this->load->view('page/wrong_password_bandar');
    }
    public function login_supp()
    {
        $this->load->view('login_supp');
    }
    public function login_bandar()
    {
        $this->load->view('login_bandar');
    }
    public function aksi_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $where = array('username' => $username, 'password' => md5($password));
        $cek = $this->m_login->cek_login('admin', $where);
        if ($cek->num_rows() > 0) {
            $data = $cek->row_array();
            $data_session = array('nama' => $data['nama'], 'level' => 'admin');
            $this->session->set_userdata($data_session);
            redirect(base_url('admin'));
        } else {
            redirect(base_url('login/wrong_password'));
        }
    }
    public function aksi_login_supp()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $where = array('username' => $username, 'password' => md5($password));
        $cek = $this->m_login->cek_login('supplier', $where);
        if ($cek->num_rows() > 0) {
            $data = $cek->row_array();
            $this->session->set_userdata('id_supp', $data['id_supplier']);
            $data_session = array('nama' => $data['nama'], 'level' => 'supplier');
            $this->session->set_userdata($data_session);
            redirect(base_url('v_supplier'));
        } else {
            redirect(base_url('login/wrong_password_supp'));
        }
    }
    public function aksi_login_bandar()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $where = array('username' => $username, 'password' => md5($password));
        $cek = $this->m_login->cek_login('bandar', $where);
        if ($cek->num_rows() > 0) {
            $data = $cek->row_array();
            $this->session->set_userdata('id_bandar', $data['id_bandar']);
            $data_session = array('nama' => $data['nama'], 'level' => 'bandar');
            $this->session->set_userdata($data_session);
            redirect(base_url('v_bandar'));
        } else {
            redirect(base_url('login/wrong_password_bandar'));
        }
    }
}
