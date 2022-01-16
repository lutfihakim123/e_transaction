<?php
class v_m_penjualan extends  CI_Model
{
    public function getPenjualan($limit, $start)
    {
        $this->db->order_by('tgl_jual', 'DESC');
        $this->db->where('id_bandar', $_SESSION['id_bandar']);
        return $this->db->get('penjualan', $limit, $start)->result();
    }
}
