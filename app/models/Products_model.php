<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products_model extends CI_Model {
    public function deletFloor ($id=null) {
        if ($id) {
            $this->db->where('id', $id)->update('floors',['deleted'=>1,'deleted_by'=>$this->session->userdata('user_id')]);
            return true;
        }
        return false;
    }
}
