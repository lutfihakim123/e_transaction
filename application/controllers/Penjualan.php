<?php
class penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('m_penjualan');
        $this->load->library('pagination');
    }
    public function index()
    {
        if ($this->input->post('penjualan')) {
            $data['keyword_penjualan'] = $this->input->post('keyword_penjualan');
            $this->session->set_userdata('keyword_penjualan', $data['keyword_penjualan']);
        } else {
            $data['keyword_penjualan'] = $this->session->userdata('keyword_penjualan');
        }

        $this->db->join('bandar', 'bandar.id_bandar=penjualan.id_bandar');

        // query number
        $this->db->like('nama', $data['keyword_penjualan']);
        $this->db->or_like('barang', $data['keyword_penjualan']);
        $this->db->or_like('status', $data['keyword_penjualan']);
        $this->db->or_like('quantitas', $data['keyword_penjualan']);
        $this->db->or_like('total_harga', $data['keyword_penjualan']);
        $this->db->or_like('total_bayar', $data['keyword_penjualan']);
        $this->db->or_like('satuan', $data['keyword_penjualan']);
        $this->db->or_like('tgl_jual', $data['keyword_penjualan']);
        $this->db->from('penjualan');
        $config['base_url'] = "http://" . $_SERVER['HTTP_HOST'];
        $config['base_url'] .= preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/penjualan/index';
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 5;

        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(3);
        $data['title'] = "Data Penjualan";
        $data['penjualan'] = $this->m_penjualan->getPenjualan($config['per_page'], $data['start'], $data['keyword_penjualan']);
        $this->load->view('penjualan/v_data_penjualan', $data);
    }
    public function nota_penjualan()
    {
        $data['title'] = "Nota penjualan";
        $id_penjualan = $this->uri->segment('3');
        $this->db->join('bandar', 'bandar.id_bandar=penjualan.id_bandar');
        $query = $this->db->get_where("penjualan", array("id_penjualan" => $id_penjualan));
        $data['penjualan'] = $query->result();
        $this->load->view('penjualan/nota_penjualan', $data);
    }
    public function delete_penjualan()
    {
        $id_penjualan = $this->uri->segment(3);
        $this->m_penjualan->delete_penjualan($id_penjualan);
        $this->session->set_flashdata('message', '<div class="alert alert-danger ml-3 alert-dismissible fade show mt-3 text-center" role="alert">
        Data Telah Di Hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <br>');
        redirect(base_url('penjualan'));
    }
    public function view_add_penjualan()
    {
        $data['title'] = "Tambah Penjualan";
        $data['bandar'] = $this->db->get('bandar')->result();
        $this->load->view('penjualan/v_add_penjualan', $data);
    }
    public function add_penjualan()
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
            'id_bandar' => $this->input->post('id_bandar', true),
            'barang' => $this->input->post('barang', true),
            'tgl_jual' => $this->input->post('tgl_jual', true),
            'quantitas' => $this->input->post('quantitas', true),
            'satuan' => $this->input->post('satuan', true),
            'total_harga' => $total_harga,
            'total_bayar' => $this->input->post('total_bayar', true),
            'status' => $status
        );
        $this->m_penjualan->add_penjualan($data);
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible ml-3 fade show mt-3 text-center" role="alert">
        Data Telah Di Tambahkan
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div><br>');
        redirect(base_url('penjualan'));
    }
    public function view_edit_penjualan()
    {
        $id_penjualan = $this->uri->segment('3');
        $data['title'] = "Edit penjualan";
        $this->db->join('bandar', 'bandar.id_bandar=penjualan.id_bandar');
        $query = $this->db->get_where("penjualan", array("id_penjualan" => $id_penjualan));
        $data['penjualan'] = $query->result();
        $data['bandar'] = $this->db->get('bandar')->result();
        $data['old_id_penjualan'] = $id_penjualan;
        $this->load->view('penjualan/v_edit_penjualan', $data);
    }
    public function edit_penjualan()
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
            'id_bandar' => $this->input->post('id_bandar', true),
            'barang' => $this->input->post('barang', true),
            'tgl_jual' => $this->input->post('tgl_jual', true),
            'quantitas' => $this->input->post('quantitas', true),
            'satuan' => $this->input->post('satuan', true),
            'total_harga' => $total_harga,
            'total_bayar' => $this->input->post('total_bayar', true),
            'status' => $status
        );
        $old_id_penjualan = $this->input->post('id_penjualan');
        $this->m_penjualan->edit_penjualan($data, $old_id_penjualan);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible ml-3 fade show mt-3 text-center" role="alert">
        Data Telah Di Edit
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div><br>');
        redirect(base_url('penjualan'));
    }
    public function view_cetak_penjualan()
    {
        $data['title'] = 'Cetak Data Penjualan';
        $data['bandar'] = $this->db->get('bandar')->result();
        $this->load->view('cetak/view_cetak_penjualan', $data);
    }
    public function cetak_penjualan()
    {
        $data['title'] = "Laporan Penjualan";
        $id_bandar = $this->input->post('id_bandar');
        $tgl_jual = $this->input->post('tgl_jual');
        $barang = $this->input->post('barang');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        if ($this->input->post('submit')) {
            if ($barang == null && $id_bandar != null && $tgl_jual != null) {
                $query = $this->db->get_where("penjualan", array("id_bandar" => $id_bandar, "tgl_jual" => $tgl_jual));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("tgl_jual" => $tgl_jual, "id_bandar" => $id_bandar))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert text-center alert-danger mt-3" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null && $id_bandar != null && $tgl_jual == null) {
                $query = $this->db->get_where("penjualan", array("id_bandar" => $id_bandar));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("id_bandar" => $id_bandar))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert text-center alert-danger mt-3" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang == null  && $id_bandar == null && $tgl_jual != null) {
                $query = $this->db->get_where("penjualan", array("tgl_jual" => $tgl_jual));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("tgl_jual" => $tgl_jual))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null  && $id_bandar != null && $tgl_jual != null) {
                $query = $this->db->get_where("penjualan", array("tgl_jual" => $tgl_jual, "id_bandar" => $id_bandar, "barang" => $barang));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("tgl_jual" => $tgl_jual, "id_bandar" => $id_bandar, "barang" => $barang))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null  && $id_bandar == null && $tgl_jual == null) {
                $query = $this->db->get_where("penjualan", array("barang" => $barang));
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $data['penjualan'] = $this->db->get_where("penjualan", array("barang" => $barang))->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger mt-3 text-center" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else {
                $this->db->order_by('tgl_jual', 'ASC');
                $query = $this->db->get("penjualan");
                $data['penjualan'] = $query->result();
            }
        }
        if ($this->input->post('range')) {
            if ($barang == null && $start != null && $end != null) {
                $this->db->where('tgl_jual >=', $start);
                $this->db->where('tgl_jual <=', $end);
                $query = $this->db->get('penjualan');
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $this->db->where('tgl_jual >=', $start);
                    $this->db->where('tgl_jual <=', $end);
                    $this->db->order_by('tgl_jual', 'ASC');
                    $query = $this->db->get('penjualan');
                    $data['penjualan'] = $query->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert text-center alert-danger mt-3" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else if ($barang != null && $start != null && $end != null) {
                $this->db->where('barang', $barang);
                $this->db->where('tgl_jual >=', $start);
                $this->db->where('tgl_jual <=', $end);
                $query = $this->db->get('penjualan');
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $this->db->where('barang', $barang);
                    $this->db->where('tgl_jual >=', $start);
                    $this->db->where('tgl_jual <=', $end);
                    $this->db->order_by('tgl_jual', 'ASC');
                    $query = $this->db->get('penjualan');
                    $data['penjualan'] = $query->result();
                } else {
                    $this->session->set_flashdata('message', '<div class="alert text-center alert-danger mt-3" role="alert">
                    Data Yang anda Cari Tidak Ditemukan 
                    </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center mt-3" role="alert">
                Anda tidak mengisi semua form cetak! 
                </div>');
            }
        }
        if ($this->input->post('bandar_range')) {
            if ($barang == null && $id_bandar != null && $start != null && $end != null) {
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
            } else if ($barang != null && $id_bandar != null && $start != null && $end != null) {
                $this->db->where('barang', $barang);
                $this->db->where('id_bandar', $id_bandar);
                $this->db->where('tgl_jual >=', $start);
                $this->db->where('tgl_jual <=', $end);
                $query = $this->db->get('penjualan');
                $data['penjualan'] = $query->num_rows();
                if ($data['penjualan'] > 0) {
                    $this->db->where('barang', $barang);
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
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center mt-3" role="alert">
                    Anda tidak mengisi semua form cetak! 
                    </div>');
            }
        }
        $this->load->view('cetak/cetak_penjualan', $data);
    }
}
