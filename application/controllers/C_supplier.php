<?php
class C_supplier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    public function index()
    {
        $query = $this->db->get("supplier");
        $data['title'] = "Data Supplier";
        $data['records'] = $query->result();
        $this->load->view('supplier/v_d_supplier', $data);
    }
    public function view_add_supplier()
    {
        $data['title'] = "Tambah Supplier";
        $this->load->view('supplier/v_add_supplier', $data);
    }
    public function view_edit_supplier()
    {
        $id_supplier = $this->uri->segment('3');
        $data['title'] = "Edit supplier";
        $query = $this->db->get_where("supplier", array("id_supplier" => $id_supplier));
        $data['records'] = $query->result();
        $data['old_id_supplier'] = $id_supplier;
        $this->load->view('supplier/v_edit_supplier', $data);
    }

    public function add_supplier()
    {
        $this->load->model('m_supplier');
        $password = $this->input->post('password');
        $pwd = md5(htmlentities($this->input->post('password', TRUE)));
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $pwd,
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat')
        );
        $this->m_supplier->add_supplier($data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Tambahkan
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_supplier'));
    }
    public function delete_supplier()
    {
        $this->load->model('m_supplier');
        $id_supplier = $this->uri->segment('3');
        $this->m_supplier->delete_supplier($id_supplier);
        redirect(base_url('c_supplier'));
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
    }
    public function edit_supplier()
    {
        $this->load->model('m_supplier');
        $password = $this->input->post('password');
        $pwd = md5(htmlentities($this->input->post('password', TRUE)));
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $pwd,
            'nama' => $this->input->post('nama'),
            'no_telp' => $this->input->post('no_telp'),
            'alamat' => $this->input->post('alamat')
        );
        $old_id_supplier = $this->input->post('id_supplier');
        $this->m_supplier->edit_supplier($data, $old_id_supplier);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible  fade show mt-3 text-center" role="alert">
        Data Telah Di Edit
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect(base_url('c_supplier'));
    }
    public function cetak_supplier()
    {
        $data['title'] = 'Data Supplier';
        $data['supplier'] = $this->db->get('supplier')->result();
        $this->load->view('supplier/data_supplier', $data);
    }
}
