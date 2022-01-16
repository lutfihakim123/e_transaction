<?php
class m_bandar extends  CI_Model
{
    public function delete_bandar($id_bandar)
    {
        if ($this->db->delete('bandar', 'id_bandar =' . $id_bandar)) {
            return true;
        }
    }
    public function add_bandar($data)
    {
        if ($this->db->insert("bandar", $data)) {
            return true;
        }
    }
    public function edit_bandar($data, $old_id_bandar)
    {
        $this->db->set($data);
        $this->db->where("id_bandar", $old_id_bandar);
        $this->db->update("bandar", $data);
    }
}
