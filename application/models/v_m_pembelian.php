<?php
class v_m_pembelian extends  CI_Model
{
    public function getPembelian($limit, $start)
    {
        $this->db->order_by('tgl_beli', 'DESC');
        $this->db->where('id_supplier', $_SESSION['id_supp']);
        return $this->db->get('pembelian', $limit, $start)->result();
    }
}
