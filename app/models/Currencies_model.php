<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Currencies_model extends CI_Model {
    public function deleteCurrency ($id=null) {
        if ($id) {
            $this->db->where('id', $id)->update('currencies',['deleted'=>1,'deleted_by'=>$this->session->userdata('user_id')]);
            return true;
        }
        return false;
    }
}
