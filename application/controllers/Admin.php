<?php
class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    public function index()
    {
        $data['title'] = "Admin Page";
        $data['penjualan'] = $this->db->get('penjualan')->num_rows();
        $data['pembelian'] = $this->db->get('pembelian')->num_rows();
        $data['supplier'] = $this->db->get('supplier')->num_rows();
        $data['bandar'] = $this->db->get('bandar')->num_rows();
        $this->load->view('page/v_admin', $data);
    }
}
