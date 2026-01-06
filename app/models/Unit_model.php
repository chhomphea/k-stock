<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Unit_model extends CI_Model {
    public function deletUnit ($id=null) {
        if ($id) {
            $this->db->where('id', $id)->update('units',['delete'=>1,'deleted_by'=>$this->session->userdata('user_id')]);
            return true;
        }
        return false;
    }
}
