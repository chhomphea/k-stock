<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Rooms_model extends CI_Model {
    public function deleteRooms ($id=null) {
        if ($id) {
            $this->db->where('id', $id)->update('rooms',['deleted'=>1,'deleted_by'=>$this->session->userdata('user_id')]);
            return true;
        }
        return false;
    }
    function CreateRooms ($rows) {
        if ($rows) {
            $this->db->insert_batch('rooms', $rows);
            return true;
        }
        return false;
    }
}
