<?php
class m_admin extends  CI_Model
{
    public function delete_admin($id_admin)
    {
        if ($this->db->delete('admin', 'id_admin =' . $id_admin)) {
            return true;
        }
    }
    public function add_admin($data)
    {
        if ($this->db->insert("admin", $data)) {
            return true;
        }
    }
    public function edit_admin($data, $old_id_admin)
    {
        $this->db->set($data);
        $this->db->where("id_admin", $old_id_admin);
        $this->db->update("admin", $data);
    }
}
