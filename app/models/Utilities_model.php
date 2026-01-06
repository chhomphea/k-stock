<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Utilities_model extends CI_Model {
    public function setUpprice ($id=null,$data=array(),$prices=array()) {
        if ($id) {
            $this->db->where('id', $id)->update('utilities',$data);
            $this->db->where('utility_id', $id)->delete('utilities_prices');
            foreach ($prices as $key => $row) {
                $row['utility_id'] = $id;
                $this->db->insert('utilities_prices', $row);
            }
            return true;
        } else {
            $this->db->insert('utilities', $data);
            $id     = $this->db->insert_id();
            foreach ($prices as $key => $row) {
                $row['utility_id'] = $id;
                $this->db->insert('utilities_prices', $row);
            }
            return true;
        }
        return false;
    }
    function deleteUtilities($id=null) {
        if ($id) {
            $this->db->where('id', $id)->delete('utilities_prices');
            return true;
        }
        return false;
    }
    function utilitiesPrice($id=null) {
        $this->db->select('utilities_prices.*,utilities.branch_id,branches.branch_kh');
        $this->db->from('utilities_prices');
        $this->db->join('utilities', 'utilities.id = utilities_prices.utility_id');
        $this->db->join('branches', 'branches.id = utilities.branch_id');
        $this->db->where('utility_id', $id);
        return $this->db->get()->result();
    }
}
