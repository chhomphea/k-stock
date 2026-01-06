<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Currencies extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('currencies_model');
    }
    public function create() {
        $this->checkRule('currency_add', false);
        $this->form_validation->set_rules('name', lang('code'), 'required');
        $this->form_validation->set_rules('code', lang('name'), 'required');
        $this->form_validation->set_rules('symbol', lang('symbol'), 'required');
        $this->form_validation->set_rules('rate', lang('rate'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'symbol'        => $this->input->post('symbol'),
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'operator'      => $this->input->post('operator'),
                'rate'          => $this->input->post('rate'),
            ];
        }
        if ($this->form_validation->run() == true && $this->site->insertTable($data, 'currencies')) {
            $this->session->set_flashdata('message', lang('currency_added'));
            redirect('currencies');
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                = [['link' => site_url('currencies'), 'page' => lang('currencies')], ['link' => '#', 'page' => lang('create_currency')]];
            $meta                     = ['page_title' => lang('update_currency'), 'bc' => $bc];
            $this->page_construct('currencies/add', $this->data, $meta);
        }
    }
    public function delete($id = null) {
        $this->checkRule('currency_delete', true);
        if ($this->currencies_model->deleteCurrency($id)) {
            $this->session->set_flashdata('message', lang('currency_deleted'));
            redirect('currencies');
        }
    }
    public function edit($id = null) {
        $this->checkRule('currency_edit', false);
        $this->form_validation->set_rules('name', lang('code'), 'required');
        $this->form_validation->set_rules('code', lang('name'), 'required');
        $this->form_validation->set_rules('symbol', lang('symbol'), 'required');
        $this->form_validation->set_rules('rate', lang('rate'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'symbol'        => $this->input->post('symbol'),
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'operator'      => $this->input->post('operator'),
                'rate'          => $this->input->post('rate'),
            ];
        }
        if ($this->form_validation->run() == true && $this->site->updateTable($id, $data, 'currencies')) {
            $this->session->set_flashdata('message', lang('currency_updated'));
            redirect('currencies');
        } else {
            $this->data['rowData']    = $this->site->getDataID($id, 'currencies');
            $this->data['error']      = (validation_errors()?validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('currencies'), 'page' => lang('currencies')], ['link' => '#', 'page' => lang('update_currency')]];
            $meta                     = ['page_title' => lang('update_currency'), 'bc' => $bc];
            $this->page_construct('currencies/edit', $this->data, $meta);
        }
    }
    public function get_currencies() {
        $actions            ='<div class="dropdown">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-list"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="'.site_url('currencies/edit/$1').'"><i class="fa fa-edit text-primary"></i> '.lang('update').'</a></li>
                                    <li><a class="dropdown-item delete-confirm" href="'.site_url('currencies/delete/$1').'"><i class="fa fa-trash text-danger"></i> '.lang('delete').'</a></li>
                                </ul>
                            </div>';
        $this->load->library('datatables');
        $this->datatables->select('id, code, name,operator,rate,symbol');
        $this->datatables->from('currencies');
        $this->datatables->where('deleted',0);
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function index() {
        $this->checkRule('currency_view', false);
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('currencies'), 'page' => lang('currencies')]];
        $meta                     = ['page_title' => lang('currencies'), 'bc' => $bc];
        $this->page_construct('currencies/index', $this->data, $meta);
    }
}
