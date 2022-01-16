<?php
class m_supplier extends  CI_Model
{
    public function delete_supplier($id_supplier)
    {
        if ($this->db->delete('supplier', 'id_supplier =' . $id_supplier)) {
            return true;
        }
    }
    public function add_supplier($data)
    {
        if ($this->db->insert("supplier", $data)) {
            return true;
        }
    }
    public function edit_supplier($data, $old_id_supplier)
    {
        $this->db->set($data);
        $this->db->where("id_supplier", $old_id_supplier);
        $this->db->update("supplier", $data);
    }
}
