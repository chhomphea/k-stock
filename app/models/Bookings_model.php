<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Bookings_model extends CI_Model {
    public function saveBookings ($data=array(),$rooms=array(),$products=array(),$deposit=array()) {
        $this->db->trans_start();
        $this->db->insert('bookings', $data);
        $booking_id = $this->db->insert_id();
        foreach ($rooms as &$room) {
            $room['booking_id'] = $booking_id;
        }
        foreach ($products as &$product) {
            $product['booking_id'] = $booking_id;
        }
        $this->db->insert_batch('booking_details', $rooms);
        $this->db->insert_batch('booking_products', $product);
        if ($deposit) {
            $deposit['booking_id'] = $booking_id;
            $this->db->insert('invoices', $deposit);
            $deposit['invoice_id']     = $this->db->insert_id();
            $payments = [
                'invoice_id'    => $this->db->insert_id(),
                'amount'        => $deposit['amount'],
                'amount'        => $deposit['amount'],
                'balance'       => 0,
                'created_by'    => $this->session->userdata('user_id'),
                'date'          => $data['booking_date'],
                'created_at'    => date("Y-m-d H:i:s"),
                'paid_by'       => $this->input->post('paid_by'),
            ];
            $this->db->insert('payments', $payments);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
    function getServiceDetail ($serviceId=null) {
        $this->db->select('products.*,units.name as unit,categories.name as category');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id');
        $this->db->join('units', 'units.id = products.unit_id');
        return $this->db->get()->row();
    }
}
