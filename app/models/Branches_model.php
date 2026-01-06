<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Branches_model extends CI_Model {
    public function deleteBranch ($id=null) {
        if ($id) {
            $this->db->where('id', $id)->update('branches',['delete'=>1,'deleted_by'=>$this->session->userdata('user_id')]);
            return true;
        }
        return false;
    }
}
