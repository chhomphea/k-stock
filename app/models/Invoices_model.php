<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Invoices_model extends CI_Model {
    function getAllUtitlities($branch=null) {
        $this->db->where('branch_id', $branch);
        return $this->db->get('utilities')->result();
    }
    public function getAllBooking($branchId = null, $floorId = null) {
        $this->db->select('
            r.name,
            r.id AS id,
            rur.old_reading,
            rur.new_reading,
            rur.used_units,
            rur.utility_id
        ');
        $this->db->from('bookings b');
        $this->db->join('booking_details bt', 'bt.booking_id = b.id');
        $this->db->join('rooms r', 'r.id = bt.room_id');
        $this->db->join('room_utilities_reading rur', 'rur.room_id = r.id', 'left');
        $this->db->where('r.branch_id', $branchId);
        $this->db->where('r.floor_id', $floorId);
        $this->db->group_by('r.id');
        return $this->db->get()->result();
    }
}
