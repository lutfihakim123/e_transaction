<?php
class Pembelian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('m_pembelian');
        $this->load->library('pagination');
    }
    public function index()
    {


        if ($this->input->post('pembelian')) {
            $data['keyword_pembelian'] = $this->input->post('keyword_pembelian');
            $this->session->set_userdata('keyword_pembelian', $data['keyword_pembelian']);
        } else {
            $data['keyword_pembelian'] = $this->session->userdata('keyword_pembelian');
        }

        $this->db->join('supplier', 'supplier.id_supplier=pembelian.id_supplier');

        // query number
        $this->db->like('nama', $data['keyword_pembelian']);
        $this->db->or_like('quantitas', $data['keyword_pembelian']);
        $this->db->or_like('barang', $data['keyword_pembelian']);
        $this->db->or_like('total_harga', $data['keyword_pembelian']);
        $this->db->or_like('total_bayar', $data['keyword_pembelian']);
        $this->db->or_like('satuan', $data['keyword_pembelian']);
        $this->db->or_like('status', $data['keyword_pembelian']);
        $this->db->or_like('tgl_beli', $data['keyword_pembelian']);
        $this->db->from('pembelian');
        $config['base_url'] = "http://" . $_SERVER['HTTP_HOST'];
        $config['base_url'] .= preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/pembelian/index';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['title'] = "Data Pembelian";
        $data['pembelian'] = $this->m_pembelian->getPembelian($config['per_page'], $data['start'], $data['keyword_pembelian']);
        $this->load->view('pembelian/v_data_pembelian', $data);
    }
    public function view_add_pembelian()
    {
        $data['title'] = "Tambah Pembelian";
        $data['supplier'] = $this->db->get('supplier')->result();
        $this->load->view('pembelian/v_add_pembelian', $data);
    }
    public function add_pembelian()
    {
        $quantitas = $this->input->post('quantitas');
        $satuan = $this->input->post('satuan');
        $total_harga = $quantitas * $satuan;
        $total_bayar = $this->input->post('total_bayar');
        if ($total_harga == $total_bayar) {
            $status = "Lunas";
        } else {
            $status = "Belum Lunas";
        }
        $data = array(
            'id_supplier' => $this->input->post('id_supplier', true),
            'barang' => $this->input->post('barang', true),
            'tgl_beli' => $this->input->post('tgl_beli', true),
            'quantitas' => $this->input->post('quantitas', true),
            'satuan' => $this->input->post('satuan', true),
            'total_harga' => $total_harga,
            'total_bayar' => $this->input->post('total_bayar', true),
            'status' => $status
        );
        $this->m_pembelian->add_pembelian($data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible ml-3 fade show mt-3 text-center" role="alert">
        Data Telah Di Tambahkan
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div><br>');
        redirect(base_url('pembelian'));
    }
    public function delete_pembelian()
    {
        $id_pembelian = $this->uri->segment(3);
        $this->m_pembelian->delete_pembelian($id_pembelian);
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible ml-3 fade show mt-3 text-center" role="alert">
        Data Telah Di Hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div><br>');
        redirect(base_url('pembelian'));
    }
    public function view_edit_pembelian()
    {
        $id_pembelian = $this->uri->segment('3');
        $data['title'] = "Edit pembelian";
        $this->db->join('supplier', 'supplier.id_supplier=pembelian.id_supplier');
        $query = $this->db->get_where("pembelian", array("id_pembelian" => $id_pembelian));
        $data['pembelian'] = $query->result();
        $data['supplier'] = $this->db->get('supplier')->result();
        $data['old_id_pembelian'] = $id_pembelian;
        $this->load->view('pembelian/v_edit_pembelian', $data);
    }
    public function edit_pembelian()
    {
        $quantitas = $this->input->post('quantitas');
        $satuan = $this->input->post('satuan');
        $total_harga = $quantitas * $satuan;
        $total_bayar = $this->input->post('total_bayar');
        if ($total_harga == $total_bayar) {
            $status = "Lunas";
        } else {
            $status = "Belum Lunas";
        }
        $data = array(
            'id_supplier' => $this->input->post('id_supplier', true),
            'barang' => $this->input->post('barang', true),
            'tgl_beli' => $this->input->post('tgl_beli', true),
            'quantitas' => $this->input->post('quantitas', true),
            'satuan' => $this->input->post('satuan', true),
            'total_harga' => $total_harga,
            'total_bayar' => $this->input->post('total_bayar', true),
            'status' => $status
        );
        $old_id_pembelian = $this->input->post('id_pembelian');
        $this->m_pembelian->edit_pembelian($data, $old_id_pembelian);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible ml-3 fade show mt-3 text-center" role="alert">
        Data Telah Di Edit
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div><br>');
        redirect(base_url('pembelian'));
    }
    public function nota_pembelian()
    {
        $data['title'] = "Nota Pembelian";
        $id_pembelian = $this->uri->segment('3');
        $this->db->join('supplier', 'supplier.id_supplier=pembelian.id_supplier');
        $query = $this->db->get_where("pembelian", array("id_pembelian" => $id_pembelian));
        $data['pembelian'] = $query->result();
        $this->load->view('pembelian/nota_pembelian', $data);
    }
    public function view_cetak_pembelian()
    {
        $data['title'] = 'Cetak Data Pembelian';
        $data['supplier'] = $this->db->get('supplier')->result();
        $this->load->view('cetak/view_cetak_pembelian', $data);
    }
    public function cetak_pembelian()
    {
        $data['title'] = "Laporan Pembelian";
        $id_supplier = $this->input->post('id_supplier');
        $tgl_beli = $this->input->post('tgl_beli');
        $barang = $this->input->post('barang');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        if ($this->input->post('submit')) {
            if ($barang == null && $id_supplier != null && $tgl_beli != null) {
                $query = $this->db->get_where("pembelian", array("id_supplier" => $id_supplier, "tgl_beli" => $tgl_beli));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("tgl_beli" => $tgl_beli, "id_supplier" => $id_supplier))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null && $id_supplier != null && $tgl_beli == null) {
                $query = $this->db->get_where("pembelian", array("id_supplier" => $id_supplier));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("id_supplier" => $id_supplier))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null && $id_supplier == null && $tgl_beli != null) {
                $query = $this->db->get_where("pembelian", array("tgl_beli" => $tgl_beli));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("tgl_beli" => $tgl_beli))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $id_supplier != null && $tgl_beli != null) {
                $query = $this->db->get_where("pembelian", array("id_supplier" => $id_supplier, "tgl_beli" => $tgl_beli, 'barang' => $barang));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("tgl_beli" => $tgl_beli, "id_supplier" => $id_supplier, 'barang' => $barang))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $id_supplier == null && $tgl_beli == null) {
                $query = $this->db->get_where("pembelian", array("barang" => $barang));
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
                    $data['pembelian'] = $this->db->get_where("pembelian", array("barang" => $barang))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else {
                $this->db->order_by('tgl_beli', 'ASC');
                $query = $this->db->get("pembelian");
                $data['pembelian'] = $query->result();
            }
        }
        if ($this->input->post('range')) {
            if ($barang == null && $start != null && $end != null) {
                $this->db->where('tgl_beli >=', $start);
                $this->db->where('tgl_beli <=', $end);
                $query = $this->db->get('pembelian');
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
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
            } else if ($barang != null && $start != null && $end != null) {
                $this->db->where('barang', $barang);
                $this->db->where('tgl_beli >=', $start);
                $this->db->where('tgl_beli <=', $end);
                $query = $this->db->get('pembelian');
                $data['pembelian'] = $query->num_rows();
                if ($data['pembelian'] > 0) {
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
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                Anda tidak mengisi semua form cetak! 
                </div>');
            }
        }
        if ($this->input->post('supplier_range')) {
            if ($barang == null && $id_supplier != null && $start != null && $end != null) {
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
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $id_supplier != null && $start != null && $end != null) {
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
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Anda tidak mengisi semua form cetak! 
                    </div>');
            }
        }
        $this->load->view('cetak/cetak_pembelian', $data);
    }
}
