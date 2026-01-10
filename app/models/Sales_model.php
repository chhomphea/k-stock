<?php
class Sales_model extends CI_Model {

    public function addSale($data, $items) {
        $this->db->trans_start();
        $data['total_items'] = count($items);
        $this->db->insert('sales', $data);
        $sale_id = $this->db->insert_id();
        foreach ($items as $item) {
            $item['sale_id'] = $sale_id;
            $this->db->insert('sale_items', $item);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function updateSale($id, $data, $items) {
        $this->db->trans_start();
        $data['total_items'] = count($items);
        $this->db->update('sales', $data, ['id' => $id]);
        $this->db->delete('sale_items', ['sale_id' => $id]);
        foreach ($items as $item) {
            $item['sale_id'] = $id;
            $this->db->insert('sale_items', $item);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getSaleByID($id) { return $this->db->get_where('sales', ['id' => $id])->row(); }
    public function getSaleItems($id) {
        return $this->db->select('sale_items.*, products.name, products.code')
            ->join('products', 'products.id = sale_items.product_id')
            ->get_where('sale_items', ['sale_id' => $id])->result();
    }
    public function getAllBranches() { return $this->db->get_where('branches', ['delete' => 0])->result(); }
    public function deleteSale($id, $user) { 
        return $this->db->update('sales', ['is_deleted' => 1, 'updated_by' => $user], ['id' => $id]); }
}