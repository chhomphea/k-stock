<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) redirect('login');
        $this->load->model('sales_model');
        $this->load->library(['form_validation', 'datatables']);
    }

    // 1. Index List View
    public function index() {
        $bc = [['link' => site_url('sales'), 'page' => lang('sales')]];
        $meta = ['page_title' => lang('sales'), 'bc' => $bc];
        $this->page_construct('sales/index', $this->data, $meta);
    }

    public function get_sales() {
        $actions = '
        <div class="dropdown">
            <button class="action-btn d-inline-flex align-items-center justify-content-center" data-bs-toggle="dropdown">
                <span class="material-icons-outlined">menu</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                <li>
                    <a class="dropdown-item" href="' . site_url('sales/view_invoice/$1') . '" target="_blank">
                        <span class="material-icons-outlined fs-6 me-2 text-primary">description</span> ' . lang('invoice') . '
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="' . site_url('sales/edit/$1') . '">
                        <span class="material-icons-outlined fs-6 me-2 text-warning">edit</span> ' . lang('edit') . '
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger delete-confirm" href="' . site_url('sales/delete/$1') . '">
                        <span class="material-icons-outlined fs-6 me-2">delete</span> ' . lang('delete') . '
                    </a>
                </li>
            </ul>
        </div>';

        $this->datatables
            ->select("
                sales.id as id, 
                sales.date as date, 
                customers.name as customer, 
                branches.branch_kh as branch_name, 
                sales.total_items as total_items, 
                sales.grand_total as grand_total, 
                sales.paid_amount as paid_amount, 
                sales.payment_status as payment_status
            ")
            ->from("sales")
            ->join("customers", "customers.id = sales.customer_id", "left")
            ->join("branches", "branches.id = sales.branch_id", "left")
            ->where("sales.is_deleted", 0)
            ->add_column("Actions", $actions, "id");
        
        echo $this->datatables->generate();
    }

    public function view_invoice($id = null) {
        if (!$id) redirect('sales');
        
        $this->data['sale'] = $this->sales_model->getSaleByID($id);
        $this->data['items'] = $this->sales_model->getSaleItems($id);
        
        if (!$this->data['sale']) {
            $this->session->set_flashdata('error', lang('sale_not_found'));
            redirect('sales');
        }

        $this->load->view($this->theme . 'sales/invoice', $this->data);
    }

    // 3. Create Sale (Renamed back to create)
    public function create() {
        // Validation Rules
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('customer_id', 'Customer', 'required');
        $this->form_validation->set_rules('warehouse_id', 'Store', 'required');

        if ($this->form_validation->run() == true) {
            
            $data = $this->_prepare_data();
            $items = $this->_prepare_items();

            if ($this->sales_model->addSale($data, $items)) {
                $this->session->set_flashdata('message', "Sale created successfully");
                redirect('sales');
            } else {
                $this->session->set_flashdata('error', "Failed to create sale");
                redirect('sales/create');
            }

        } else {
            // Load View with Data
            $this->data['customers'] = $this->site->getAllCustomers();
            $this->data['branches'] = $this->sales_model->getAllBranches(); 
            $this->data['reference_no'] = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
            
            $this->page_construct('sales/create', $this->data, ['page_title' => 'Create Sale']);
        }
    }

    // 4. Update Sale
    public function edit($id = NULL) {
        $this->form_validation->set_rules('date', 'Date', 'required');
        
        if ($this->form_validation->run() == true) {
            $data = $this->_prepare_data();
            $items = $this->_prepare_items();
            
            if ($this->sales_model->updateSale($id, $data, $items)) {
                $this->session->set_flashdata('message', "Sale updated successfully");
                redirect('sales');
            }
        } else {
            $this->data['sale'] = $this->sales_model->getSaleByID($id);
            $this->data['items'] = $this->sales_model->getSaleItems($id);
            $this->data['customers'] = $this->site->getAllCustomers();
            $this->data['branches'] = $this->sales_model->getAllBranches();
            
            $this->page_construct('sales/edit', $this->data, ['page_title' => 'Edit Sale']);
        }
    }

    public function delete($id) {
        if ($this->sales_model->deleteSale($id, $this->session->userdata('user_id'))) {
            $this->session->set_flashdata('message', "Sale deleted");
        }
        redirect('sales');
    }

    public function suggestions() {
        $term = $this->input->get('term', TRUE);
        if (empty($term)) {
            echo json_encode([]); return;
        }

        $this->db->select('products.id, products.name, products.code, products.price, units.name as unit_name');
        $this->db->from('products');
        $this->db->join('units', 'units.id = products.unit_id', 'left');
        $this->db->group_start();
            $this->db->like('products.name', $term);
            $this->db->or_like('products.code', $term);
        $this->db->group_end();
        $this->db->where('products.active', 1);
        $this->db->where('products.deleted', 0);
        $this->db->limit(15);
        
        $query = $this->db->get();
        $rows = $query->result();

        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id'    => $row->id,
                'text'  => $row->code . ' - ' . $row->name, 
                'price' => (float)$row->price,
                'unit'  => $row->unit_name ? $row->unit_name : 'Unit'
            ];
        }

        echo json_encode($result);
    }

    // --- HELPER FUNCTIONS ---

    private function _prepare_data() {
        $date = $this->input->post('date');
        // Handle DateTime Local format (T) -> SQL Format
        $date = str_replace('T', ' ', $date);
        if(strlen($date) == 16) $date .= ':00'; // Append seconds if missing

        // Order Discount Calculation
        $subtotal = $this->input->post('total_price');
        $disc_val = $this->input->post('order_discount');
        $disc_type = $this->input->post('order_discount_type'); // 'amount' or 'percentage'
        
        $order_discount_amount = 0;
        if($disc_type == 'percentage') {
            $order_discount_amount = $subtotal * ($disc_val / 100);
        } else {
            $order_discount_amount = $disc_val;
        }

        return [
            'date'              => $date,
            'invoice_no'        => $this->input->post('reference_no') ? $this->input->post('reference_no') : 'INV-'.date('YmdHis'),
            'customer_id'       => $this->input->post('customer_id'),
            'branch_id'         => $this->input->post('warehouse_id'), // Map warehouse_id to branch_id
            'total_items'       => count($this->input->post('product_id')),
            'total_price'       => $subtotal,
            'order_discount'    => $order_discount_amount, // The actual money value
            'order_discount_id' => $disc_type, // Storing 'amount' or 'percentage' here
            'grand_total'       => $this->input->post('grand_total'),
            'paid_amount'       => 0,
            'payment_status'    => 'pending',
            'created_by'        => $this->session->userdata('user_id'),
            'updated_by'        => $this->session->userdata('user_id'),
            'updated_at'        => date('Y-m-d H:i:s')
        ];
    }

    private function _prepare_items() {
        $items = [];
        $product_ids = $this->input->post('product_id');
        $quantities  = $this->input->post('quantity');
        $prices      = $this->input->post('unit_price');
        
        if (!empty($product_ids)) {
            foreach ($product_ids as $k => $pid) {
                // Fetch Unit Name from DB (since we removed it from the Clean UI form)
                $product_info = $this->db->select('units.name as unit_name')
                                         ->from('products')
                                         ->join('units', 'units.id = products.unit_id', 'left')
                                         ->where('products.id', $pid)
                                         ->get()->row();
                                         
                $unit_name = ($product_info && $product_info->unit_name) ? $product_info->unit_name : 'Unit';

                $qty = $quantities[$k];
                $price = $prices[$k];
                $subtotal = $qty * $price;

                $items[] = [
                    'product_id'    => $pid,
                    'unit_name'     => $unit_name, 
                    'quantity'      => $qty,
                    'unit_price'    => $price,
                    // Default values for Clean UI (No item discounts)
                    'discount_type' => 'amount', 
                    'item_discount' => 0.00,
                    'subtotal'      => $subtotal
                ];
            }
        }
        return $items;
    }
}