<?php
class C_bandar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    public function index()
    {
        $query = $this->db->get("bandar");
        $data['title'] = "Data Bandar";
        $data['records'] = $query->result();
        $this->load->view('bandar/v_d_bandar', $data);
    }
    public function view_add_bandar()
    {
        $data['title'] = "Tambah bandar";
        $this->load->view('bandar/v_add_bandar', $data);
    }
    public function view_edit_bandar()
    {
        $id_bandar = $this->uri->segment('3');
        $data['title'] = "Edit bandar";
        $query = $this->db->get_where("bandar", array("id_bandar" => $id_bandar));
        $data['records'] = $query->result();
        $data['old_id_bandar'] = $id_bandar;
        $this->load->view('bandar/v_edit_bandar', $data);
    }

    public function add_bandar()
    {
        $this->load->model('m_bandar');
        $password = $this->input->post('password');
        $pwd = md5(htmlentities($this->input->post('password', TRUE)));
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $pwd,
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat')
        );
        $this->m_bandar->add_bandar($data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Tambahkan
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_bandar'));
    }
    public function delete_bandar()
    {
        $this->load->model('m_bandar');
        $id_bandar = $this->uri->segment('3');
        $this->m_bandar->delete_bandar($id_bandar);
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_bandar'));
    }
    public function edit_bandar()
    {
        $this->load->model('m_bandar');
        $password = $this->input->post('password');
        $pwd = md5(htmlentities($this->input->post('password', TRUE)));
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $pwd,
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat')
        );
        $old_id_bandar = $this->input->post('id_bandar');
        $this->m_bandar->edit_bandar($data, $old_id_bandar);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Edit
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_bandar'));
    }
    public function cetak_bandar()
    {
        $data['title'] = 'Data Bandar';
        $data['bandar'] = $this->db->get('bandar')->result();
        $this->load->view('bandar/data_bandar', $data);
    }
}
