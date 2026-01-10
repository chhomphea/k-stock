<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('categories_model');
    }
    public function create() {
        $this->checkRule('product_add', false);
        $this->form_validation->set_rules('name', lang('name'), 'required');
        $this->form_validation->set_rules('code', lang('code'), 'required');
        $this->form_validation->set_rules('category', lang('category'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'category_id'   => $this->input->post('category'),
                'unit_id'       => $this->input->post('unit'),
                'price'         => $this->input->post('price'),
                'cost'          => $this->input->post('cost'),
                'active'        => $this->input->post('display'),
                'created_by'    => $this->session->userdata('user_id'),
                'image'         => 'no_image.png',
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->insertTable($data, 'products')) {
            $this->session->set_flashdata('message', lang('product_added'));
            redirect('products');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('products'), 'page' => lang('setup')], ['link' => '#', 'page' => lang('create_product')]];
            $meta                     = ['page_title' => lang('create_product'), 'bc' => $bc];
            $this->page_construct('products/create', $this->data, $meta);
        }
    }
    public function delete($id = null) {
        $this->checkRule('category_delete', true);
        if ($this->categories_model->deleteCategory($id)) {
            $this->session->set_flashdata('message', lang('category_deleted'));
            redirect('products');
        }
    }
    public function edit($id = null) {
        $this->checkRule('category_edit', false);
        $this->form_validation->set_rules('name', lang('name'), 'required');
        $this->form_validation->set_rules('code', lang('code'), 'required');
        $this->form_validation->set_rules('unit', lang('unit'), 'required');
        $this->form_validation->set_rules('category', lang('category'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'category_id'   => $this->input->post('category'),
                'unit_id'       => $this->input->post('unit'),
                'cost'          => $this->input->post('cost'),
                'price'         => $this->input->post('price'),
                'cost'          => $this->input->post('cost'),
                'active'        => $this->input->post('display'),
                'order_display' => $this->input->post('order_display'),
                'updated_by'    => $this->session->userdata('user_id'),
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->updateTable($id, $data, 'products')) {
            $this->session->set_flashdata('message', lang('product_updated'));
            redirect('products');
        } else {
            $this->data['product']    = $this->site->getDataID($id, 'products');
            $this->data['error']      = (validation_errors()?validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('categories'), 'page' => lang('setup')], ['link' => '#', 'page' => lang('update_category')]];
            $meta                     = ['page_title' => lang('update_category'), 'bc' => $bc];
            $this->page_construct('products/index', $this->data, $meta);
        }
    }
    public function get_products() {
        $actions = '<div class="dropdown">
                        <button class="action-btn d-inline-flex align-items-center justify-content-center" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-icons-outlined">menu</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <a class="dropdown-item" href="' . site_url('products/edit/$1') .'">
                                    ' . lang('edit') . '
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger delete-confirm" href="' . site_url('products/delete/$1') . '">
                                    ' . lang('delete') . '
                                </a>
                            </li>
                        </ul>
                    </div>';
        $this->load->library('datatables');
        $this->datatables
            ->select('products.id, products.image, products.code, products.name, products.active, categories.name as category, units.name as unit, products.created_at, CONCAT(users.first_name, " ", users.last_name) as created_by, products.price')
            ->from('products')
            ->join('categories', 'categories.id = products.category_id')
            ->join('units', 'units.id = products.unit_id')
            ->join('users', 'users.id = products.created_by');

        // Add Action Column
        $this->datatables->add_column('Actions', $actions, 'id');
        
        // Hide ID Column if needed (optional based on your requirement)
        $this->datatables->unset_column('id');

        // Return JSON
        echo $this->datatables->generate();
    }
    public function index() {
        $this->checkRule('products_view', false);
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('products'), 'page' => lang('list_products')]];
        $meta                     = ['page_title' => lang('list_products'), 'bc' => $bc];
        $this->page_construct('products/index', $this->data, $meta);
    }
}
