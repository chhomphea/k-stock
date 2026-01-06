<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Customer_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function deleteCustomer($id) {
        if ($this->db->delete('customers', ['id' => $id])) {
            return true;
        }
        return false;
    }
}
