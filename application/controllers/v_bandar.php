<?php
class V_bandar extends  CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->model('v_m_penjualan');
    }
    public function index()
    {
        $config['base_url'] = "http://" . $_SERVER['HTTP_HOST'];
        $config['base_url'] .= preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/v_bandar/index';
        $config['total_rows'] = $this->db->get_where('penjualan', array('id_bandar' => $_SESSION['id_bandar']))->num_rows();
        $config['per_page'] = 5;
        $this->pagination->initialize($config);
        $data['start'] = $this->uri->segment(3);
        $data['title'] = "Data Transaksi";
        $this->db->order_by('tgl_jual', 'DESC');
        $data['penjualan'] = $this->v_m_penjualan->getPenjualan($config['per_page'], $data['start']);
        $this->load->view('v_bandar/v_data_penjualan', $data);
    }
    public function nota_penjualan()
    {
        $data['title'] = "Nota Transaksi";
        $id_penjualan = $this->uri->segment('3');
        $this->db->join('bandar', 'bandar.id_bandar=penjualan.id_bandar');
        $query = $this->db->get_where("penjualan", array("id_penjualan" => $id_penjualan));
        $data['penjualan'] = $query->result();
        $this->load->view('v_bandar/nota_penjualan', $data);
    }
    public function view_cetak_penjualan()
    {
        $data['title'] = 'Cetak Data Transaksi';
        $this->load->view('v_bandar/view_cetak_penjualan', $data);
    }
    public function cetak_penjualan()
    {
        $data['title'] = "Laporan Transaksi";
        $id_bandar = $this->input->post('id_bandar');
        $barang = $this->input->post('barang');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        if ($this->input->post('range')) {
            if ($barang == null && $start != null && $end != null) {
                $this->db->where('id_bandar', $id_bandar);
                $this->db->where('tgl_jual >=', $start);
                $this->db->where('tgl_jual <=', $end);
                $query = $this->db->get('penjualan');
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $this->db->where('id_bandar', $id_bandar);
                    $this->db->where('tgl_jual >=', $start);
                    $this->db->where('tgl_jual <=', $end);
                    $this->db->order_by('tgl_jual', 'ASC');
                    $query = $this->db->get('penjualan');
                    $data['penjualan'] = $query->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null && $start != null && $end == null) {
                $query = $this->db->get_where("penjualan", array("tgl_jual" => $start, "id_bandar" => $id_bandar));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("tgl_jual" => $start, "id_bandar" => $id_bandar))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null && $start == null && $end != null) {
                $query = $this->db->get_where("penjualan", array("tgl_jual" => $end, "id_bandar" => $id_bandar));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("tgl_jual" => $end, "id_bandar" => $id_bandar))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $start != null && $end != null) {
                $this->db->where('id_bandar', $id_bandar);
                $this->db->where('barang', $barang);
                $this->db->where('tgl_jual >=', $start);
                $this->db->where('tgl_jual <=', $end);
                $query = $this->db->get('penjualan');
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $this->db->where('id_bandar', $id_bandar);
                    $this->db->where('barang', $barang);
                    $this->db->where('tgl_jual >=', $start);
                    $this->db->where('tgl_jual <=', $end);
                    $this->db->order_by('tgl_jual', 'ASC');
                    $query = $this->db->get('penjualan');
                    $data['penjualan'] = $query->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $start == null && $end == null) {
                $query = $this->db->get_where("penjualan", array("barang" => $barang, "id_bandar" => $id_bandar));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("barang" => $barang, "id_bandar" => $id_bandar))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else {
                $this->db->order_by('id_bandar', 'ASC');
                $query = $this->db->get_where("penjualan", array("id_bandar" => $id_bandar));
                $data['penjualan'] = $query->result();
            }
            $this->load->view('v_bandar/cetak_penjualan', $data);
        }
    }
}
