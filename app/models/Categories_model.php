<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Categories_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function add_categories($data = [])
    {
        if ($this->db->insert_batch('categories', $data)) {
            return true;
        }
        return false;
    }
    public function deleteCategory($id)
    {
        if ($this->db->delete('categories', ['id' => $id])) {
            return true;
        }
        return false;
    }
    public function add_subcategory($data)
    {
        if ($this->db->insert('subcategory', $data)) {
            return true;
        }
        return false;
    }

    public function deleteSubCategory($id)
    {
        if ($this->db->delete('subcategory', ['id' => $id])) {
            return true;
        }
        return false;
    }
    public function updateSubCategory($id, $data = null)
    {
        if ($this->db->update('subcategory', $data, ['id' => $id])) {
            return true;
        }
        return false;
    }
}
