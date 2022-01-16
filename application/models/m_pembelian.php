<?php
class M_pembelian extends CI_Model
{
    public function getPembelian($limit, $start, $keyword_pembelian = null)
    {
        $this->db->join('supplier', 'supplier.id_supplier=pembelian.id_supplier');
        if ($keyword_pembelian) {
            $this->db->like('nama', $keyword_pembelian);
            $this->db->or_like('status', $keyword_pembelian);
            $this->db->or_like('barang', $keyword_pembelian);
            $this->db->or_like('quantitas', $keyword_pembelian);
            $this->db->or_like('total_harga', $keyword_pembelian);
            $this->db->or_like('total_bayar', $keyword_pembelian);
            $this->db->or_like('tgl_beli', $keyword_pembelian);
            $this->db->or_like('status', $keyword_pembelian);
        }
        $this->db->order_by('tgl_beli', 'DESC');
        return $this->db->get('pembelian', $limit, $start)->result();
    }
    public function add_pembelian($data)
    {
        if ($this->db->insert("pembelian", $data)) {
            return true;
        }
    }
    public function delete_pembelian($id_pembelian)
    {
        if ($this->db->delete('pembelian', 'id_pembelian =' . $id_pembelian)) {
            return true;
        }
    }
    public function edit_pembelian($data, $old_id_pembelian)
    {
        $this->db->set($data);
        $this->db->where("id_pembelian", $old_id_pembelian);
        $this->db->update("pembelian", $data);
    }
}
