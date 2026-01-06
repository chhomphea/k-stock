<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Branches extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (! $this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('branches_model');
    }
    public function index () {
        $this->checkRule('branchs_view', false);
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('branches'), 'page' => lang('setup')], ['link' => '#', 'page' => lang('list_branchs')]];
        $meta                     = ['page_title' => lang('list_branchs'), 'bc' => $bc];
        $this->page_construct('branches/index', $this->data, $meta);
    }
    public function get_branches() {
        $this->load->library('datatables');
        $actions =  '<div class="btn-group">
                        <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-list-ul"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.site_url('branches/edit/$1').'">
                                <i class="fa fa-edit text-primary"></i> '.lang('update').'
                            </a>
                            <a class="dropdown-item delete-confirm" href="'.site_url('branches/delete/$1').'">
                                <i class="fa fa-trash text-danger"></i> '.lang('delete').'
                            </a>
                        </div>
                    </div>';
        $this->datatables->select('id, image, code, branch_kh, branch_en, address_kh, address_en, phone, active, order_display');
        $this->datatables->from('branches');
        $this->datatables->where('delete',0);
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function create() {
        $this->checkRule('branch_add', false);
        $this->form_validation->set_rules('code', lang('code'), 'required');
        $this->form_validation->set_rules('branch_en', lang('branch_en'), 'required');
        $this->form_validation->set_rules('branch_kh', lang('branch_kh'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'                  => $this->input->post('code'),
                'branch_en'             => $this->input->post('branch_en'),
                'branch_kh'             => $this->input->post('branch_kh'),
                'address_kh'            => $this->input->post('address_kh'),
                'address_en'            => $this->input->post('address_en'),
                'phone'                 => $this->input->post('phone'),
                'active'                => $this->input->post('display'),
                'order_display'         => $this->input->post('order_display'),
                'image'                 => 'no_image.png',
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $data['image']  = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->insertTable($data, 'branches')) {
            $this->session->set_flashdata('message', lang('branch_created'));
            redirect('branches');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('branches'), 'page' => lang('settings')], ['link' => '#', 'page' => lang('create_branch')]];
            $meta                     = ['page_title' => lang('create_branch'), 'bc' => $bc];
            $this->page_construct('branches/add', $this->data, $meta);
        }
    }
    public function edit($id=null) {
        $this->checkRule('branch_add', false);
        $this->form_validation->set_rules('code', lang('code'), 'required');
        $this->form_validation->set_rules('branch_en', lang('branch_en'), 'required');
        $this->form_validation->set_rules('branch_kh', lang('branch_kh'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'                  => $this->input->post('code'),
                'branch_en'             => $this->input->post('branch_en'),
                'branch_kh'             => $this->input->post('branch_kh'),
                'address_kh'            => $this->input->post('address_kh'),
                'address_en'            => $this->input->post('address_en'),
                'phone'                 => $this->input->post('phone'),
                'active'                => $this->input->post('display'),
                'order_display'         => $this->input->post('order_display'),
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $this->tec->uploadFile();
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->updateTable($id,$data, 'branches')) {
            $this->session->set_flashdata('message', lang('branch_updated'));
            redirect('branches');
        } else {
            $this->data["rowData"]    = $this->site->getDataID($id,'branches');
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('branches'), 'page' => lang('branches')], ['link' => '#', 'page' => lang('update_branch')]];
            $meta                     = ['page_title' => lang('update_branch'), 'bc' => $bc];
            $this->page_construct('branches/edit', $this->data, $meta);
        }
    }
    public function delete($id = null) {
        $this->checkRule('branch_delete', false);
        if ($this->branches_model->deleteBranch($id)) {
            $this->session->set_flashdata('message', lang('branch_deleted'));
            redirect('branches');
        }
    }
}
