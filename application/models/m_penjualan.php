<?php
class M_penjualan extends CI_Model
{
    public function getPenjualan($limit, $start, $keyword_penjualan = null)
    {
        $this->db->join('bandar', 'bandar.id_bandar=penjualan.id_bandar');
        if ($keyword_penjualan) {
            $this->db->like('nama', $keyword_penjualan);
            $this->db->or_like('status', $keyword_penjualan);
            $this->db->or_like('barang', $keyword_penjualan);
            $this->db->or_like('quantitas', $keyword_penjualan);
            $this->db->or_like('total_harga', $keyword_penjualan);
            $this->db->or_like('total_bayar', $keyword_penjualan);
            $this->db->or_like('tgl_jual', $keyword_penjualan);
            $this->db->or_like('satuan', $keyword_penjualan);
        }
        $this->db->order_by('tgl_jual', 'DESC');
        return $this->db->get('penjualan', $limit, $start)->result();
    }
    public function add_penjualan($data)
    {
        if ($this->db->insert("penjualan", $data)) {
            return true;
        }
    }
    public function delete_penjualan($id_penjualan)
    {
        if ($this->db->delete('penjualan', 'id_penjualan =' . $id_penjualan)) {
            return true;
        }
    }
    public function edit_penjualan($data, $old_id_penjualan)
    {
        $this->db->set($data);
        $this->db->where("id_penjualan", $old_id_penjualan);
        $this->db->update("penjualan", $data);
    }
}
