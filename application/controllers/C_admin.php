<?php
class C_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    public function index()
    {
        $query = $this->db->get("admin");
        $data['title'] = "Data Admin";
        $data['records'] = $query->result();
        $this->load->view('page/v_d_admin', $data);
    }
    public function delete_admin()
    {
        $this->load->model('m_admin');
        $id_admin = $this->uri->segment('3');
        $this->m_admin->delete_admin($id_admin);
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_admin'));
    }
    public function view_add_admin()
    {
        $data['title'] = "Tambah Admin";
        $this->load->view('page/v_add_admin', $data);
    }
    public function view_edit_admin()
    {
        $id_admin = $this->uri->segment('3');
        $data['title'] = "Edit Admin";
        $query = $this->db->get_where("admin", array("id_admin" => $id_admin));
        $data['records'] = $query->result();
        $data['old_id_admin'] = $id_admin;
        $this->load->view('page/v_edit_admin', $data);
    }
    public function add_admin()
    {
        $this->load->model('m_admin');
        $password = $this->input->post('password');
        $pwd = md5(htmlentities($this->input->post('password', TRUE)));
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $pwd,
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'email' => $this->input->post('email')
        );
        $this->m_admin->add_admin($data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Tambahkan
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_admin'));
    }
    public function edit_admin()
    {
        $this->load->model('m_admin');
        $password = $this->input->post('password');
        $pwd = md5(htmlentities($this->input->post('password', TRUE)));
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $pwd,
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'email' => $this->input->post('email')
        );
        $old_id_admin = $this->input->post('id_admin');
        $this->m_admin->edit_admin($data, $old_id_admin);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Edit
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_admin'));
    }
}
