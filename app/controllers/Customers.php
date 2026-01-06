<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Customers extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('customer_model');
    }
    public function create() {
        $this->checkRule('customer_add', false);
        $this->form_validation->set_rules('name', lang('name'), 'required');
        $this->form_validation->set_rules('branch', lang('branches'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'branch_id'         => $this->input->post('branch'),
                'name'              => $this->input->post('name'),
                'phone'             => $this->input->post('phone'),
                'address'           => $this->input->post('address'),
                'image'             => 'no_image.png',
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $this->tec->uploadFile();
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->insertTable($data, 'customers')) {
            $this->session->set_flashdata('message', lang('customer_added'));
            redirect('customers');
        } else {
            $this->data['branches']   = $this->site->getAllBranches();
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('create_customer');
            $bc                       = [['link' => site_url('customers'), 'page' => lang('customers')], ['link' => '#', 'page' => lang('create_customer')]];
            $meta                     = ['page_title' => lang('create_customer'), 'bc' => $bc];
            $this->page_construct('customers/add', $this->data, $meta);
        }
    }
    public function delete($id = null) {
        $this->checkRule('customer_delete', true);
        if ($this->customer_model->deleteCustomer($id)) {
            $this->session->set_flashdata('message', lang('customer_deleted'));
            redirect('customers');
        }
    }
    public function edit($id = null) {
        $this->checkRule('customer_edit', false);
        $this->form_validation->set_rules('name', lang('name'), 'required');
        $this->form_validation->set_rules('branch', lang('branches'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'branch_id'         => $this->input->post('branch'),
                'name'              => $this->input->post('name'),
                'phone'             => $this->input->post('phone'),
                'address'           => $this->input->post('address'),
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $this->tec->uploadFile();
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->updateTable($id, $data, 'customers')) {
            $this->session->set_flashdata('message', lang('customer_added'));
            redirect('customers');
        } else {
            $this->data['rowData']    = $this->site->getDataID($id, 'customers');
            $this->data['branches']   = $this->site->getAllBranches();
            $this->data['error']      = (validation_errors()?validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('edit_customer');
            $bc                       = [['link' => site_url('customers'), 'page' => lang('customers')], ['link' => '#', 'page' => lang('update_customer')]];
            $meta                     = ['page_title' => lang('update_customer'), 'bc' => $bc];
            $this->page_construct('customers/edit', $this->data, $meta);
        }
    }
    public function getcustomer() {
        $actions = '<a href="'.site_url('customers/edit/$1').'"><button type="button" class="btn btn-warning btn-sm btn-icon waves-effect waves-light"><i class="ri-pencil-fill"></i></button></a>
                    <a href="'.site_url('customers/delete/$1').'"><button type="button" class="btn btn-danger btn-sm btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button></a>';
        $this->load->library('datatables');
        $this->datatables->select('customers.id, customers.image, customers.phone, name,address,branches.branch_kh as branch');
        $this->datatables->from('customers');
        $this->datatables->join('branches','branches.id=customers.branch_id');
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function index() {
        $this->checkRule('customer_view', false);
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('customers'), 'page' => lang('list_customers')]];
        $meta                     = ['page_title' => lang('list_customers'), 'bc' => $bc];
        $this->page_construct('customers/index', $this->data, $meta);
    }
    function test () {
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('customers'), 'page' => lang('list_customers')]];
        $meta                     = ['page_title' => lang('list_customers'), 'bc' => $bc];
        $this->page_construct('customers/test', $this->data, $meta);
    }
}
