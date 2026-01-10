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
        // Dropdown Action Menu Template
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

        $this->load->library('datatables');
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
            ->where("sales.is_deleted", 0) // Exclude soft-deleted records
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

    // 3. Create Sale
    public function create() {
        $this->form_validation->set_rules('customer_id', lang('customer'), 'required');
        if ($this->form_validation->run() == true) {
            $data   = $this->_prepare_data();
            $items  = $this->_prepare_items();
            if ($this->sales_model->addSale($data, $items)) {
                $this->session->set_flashdata('message', "Sale created successfully");
                redirect('sales');
            }
        } else {
            $this->data['customers'] = $this->site->getAllCustomers();
            $this->data['branches'] = $this->sales_model->getAllBranches();
            $this->page_construct('sales/create', $this->data, ['page_title' => 'Create Sale']);
        }
    }

    // 4. Update Sale
    public function edit($id = NULL) {
        if ($this->form_validation->run('customer_id') == true) {
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
            echo json_encode([]);
            return;
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
            $result[]   = [
                'id'    => $row->id,
                'text'  => $row->code . ' - ' . $row->name, 
                'price' => (float)$row->price,
                'unit'  => $row->unit_name ? $row->unit_name : 'Unit'
            ];
        }

        echo json_encode($result);
    }
    private function _prepare_data() {
        $input_date     = $this->input->post('date');
        $ref_data       = $this->site->get_next_reference('sales', $input_date);
        return [
            'date'              => $this->input->post('date'),
            'no'                => $ref_data->no,
            'invoice_no'        => $ref_data->reference,
            'customer_id'       => $this->input->post('customer_id'),
            'branch_id'         => $this->input->post('branch_id'),
            'total_price'       => $this->input->post('total_price'),
            'order_discount'    => $this->input->post('order_discount'),
            'order_discount_id' => $this->input->post('order_discount_id'),
            'grand_total'       => $this->input->post('grand_total'),
            'payment_status'    => $this->input->post('payment_status'),
            'created_by'        => $this->session->userdata('user_id')
        ];
    }
    private function _prepare_items() {
        $items = [];
        foreach ($this->input->post('product_id') as $k => $v) {
            $items[] = [
                'product_id'    => $v, 
                'unit_name'     => $_POST['unit_name'][$k],
                'quantity'      => $_POST['quantity'][$k], 
                'unit_price'    => $_POST['unit_price'][$k],
                'discount_type' => $_POST['item_discount_type'][$k],
                'item_discount' => $_POST['item_discount'][$k], 
                'subtotal'      => $_POST['subtotal'][$k]
            ];
        }
        return $items;
    }
}