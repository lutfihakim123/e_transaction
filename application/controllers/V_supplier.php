<?php
class V_supplier extends  CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('v_m_pembelian');
    }
    public function index()
    {
        $config['base_url'] = "http://" . $_SERVER['HTTP_HOST'];
        $config['base_url'] .= preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/v_supplier/index';
        $config['total_rows'] = $this->db->get_where('pembelian', array('id_supplier' => $_SESSION['id_supp']))->num_rows();
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['start'] = $this->uri->segment(3);
        $data['title'] = "Data Transaksi";
        $this->db->order_by('tgl_beli', 'DESC');
        $data['pembelian'] = $this->v_m_pembelian->getPembelian($config['per_page'], $data['start']);
        $this->load->view('v_supplier/v_data_pembelian', $data);
    }
    public function nota_pembelian()
    {
        $data['title'] = "Nota Transaksi";
        $id_pembelian = $this->uri->segment('3');
        $this->db->join('supplier', 'supplier.id_supplier=pembelian.id_supplier');
        $query = $this->db->get_where("pembelian", array("id_pembelian" => $id_pembelian));
        $data['pembelian'] = $query->result();
        $this->load->view('v_supplier/nota_pembelian', $data);
    }
    public function view_cetak_pembelian()
    {
        $data['title'] = 'Cetak Data Pembelian';
        $this->load->view('v_supplier/view_cetak_pembelian', $data);
    }
    public function cetak_pembelian()
    {
        $data['title'] = "Laporan Transaksi";
        $id_supplier = $this->input->post('id_supplier');
        $start = $this->input->post('start');
        $barang = $this->input->post('barang');
        $end = $this->input->post('end');
        if ($this->input->post('range')) {
            if ($barang == null && $start != null && $end != null) {
                $this->db->where('id_supplier', $id_supplier);
                $this->db->where('tgl_beli >=', $start);
                $this->db->where('tgl_beli <=', $end);
                $query = $this->db->get('pembelian');
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $this->db->where('id_supplier', $id_supplier);
                    $this->db->where('tgl_beli >=', $start);
                    $this->db->where('tgl_beli <=', $end);
                    $this->db->order_by('tgl_beli', 'ASC');
                    $query = $this->db->get('pembelian');
                    $data['pembelian'] = $query->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null && $start != null && $end == null) {
                $query = $this->db->get_where("pembelian", array("tgl_beli" => $start, "id_supplier" => $id_supplier));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("tgl_beli" => $start, "id_supplier" => $id_supplier))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null && $start == null && $end != null) {
                $query = $this->db->get_where("pembelian", array("tgl_beli" => $end, "id_supplier" => $id_supplier));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("tgl_beli" => $end, "id_supplier" => $id_supplier))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $start != null && $end != null) {
                $this->db->where('id_supplier', $id_supplier);
                $this->db->where('barang', $barang);
                $this->db->where('tgl_beli >=', $start);
                $this->db->where('tgl_beli <=', $end);
                $query = $this->db->get('pembelian');
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $this->db->where('id_supplier', $id_supplier);
                    $this->db->where('barang', $barang);
                    $this->db->where('tgl_beli >=', $start);
                    $this->db->where('tgl_beli <=', $end);
                    $this->db->order_by('tgl_beli', 'ASC');
                    $query = $this->db->get('pembelian');
                    $data['pembelian'] = $query->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $start == null && $end == null) {
                $query = $this->db->get_where("pembelian", array("barang" => $barang, "id_supplier" => $id_supplier));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("barang" => $barang, "id_supplier" => $id_supplier))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else {
                $this->db->order_by('id_supplier', 'ASC');
                $query = $this->db->get_where("pembelian", array("id_supplier" => $id_supplier));
                $data['pembelian'] = $query->result();
            }
            $this->load->view('v_supplier/cetak_pembelian', $data);
        }
    }
}
