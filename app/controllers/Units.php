<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Units extends MY_Controller {
	public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('unit_model');
    }
	public function index() {
		$this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
		$this->data['page_title'] = lang('units');
		$this->data['units']      = $this->site->getAllUnits();
		$bc                       = [['link' => site_url('units'), 'page' => lang('units')]];
        $meta                     = ['page_title' => lang('units'), 'bc' => $bc];
		$this->page_construct('units/index', $this->data, $meta);
	}
	public function create() {
        $this->checkRule('unit_add', false);
        $this->form_validation->set_rules('name', lang('unit_name'), 'required');
        $this->form_validation->set_rules('code', lang('unit_code'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'sort'       	=> $this->input->post('order_display'),
                'active' 		=> $this->input->post('display'),
                'created_at' 	=> date("Y-m-d H:i:s"),
            ];
        }
        if ($this->form_validation->run() == true && $this->site->insertTable($data, 'units')) {
            $this->session->set_flashdata('message', lang('unit_created'));
            redirect('units');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('units'), 'page' => lang('units')], ['link' => '#', 'page' => lang('create_unit')]];
            $meta                     = ['page_title' => lang('units'), 'bc' => $bc];
            $this->page_construct('units/create', $this->data, $meta);
        }
    }
    public function edit($id=null) {
        $this->checkRule('unit_edit', false);
        $this->form_validation->set_rules('name', lang('unit_name'), 'required');
        $this->form_validation->set_rules('code', lang('unit_code'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'sort'       	=> $this->input->post('order_display'),
                'active' 		=> $this->input->post('display'),
                'created_at' 	=> date("Y-m-d H:i:s"),
            ];
        }
        if ($this->form_validation->run() == true && $this->site->updateTable($id,$data, 'units')) {
            $this->session->set_flashdata('message', lang('unit_updated'));
            redirect('units');
        } else {
        	$this->data['unit']		  = $this->site->getDataID($id,'units');
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('units'), 'page' => lang('units')], ['link' => '#', 'page' => lang('update_unit')]];
            $meta                     = ['page_title' => lang('units'), 'bc' => $bc];
            $this->page_construct('units/edit', $this->data, $meta);
        }
    }
	public function getUnit() {
		$this->load->library('datatables');
		$actions = '<div class="btn-group">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="las la-list-ul"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="'.site_url('units/edit/$1').'">
                                <i class="fa fa-edit text-primary"></i> '.lang('update').'
                            </a>
                            <a class="dropdown-item delete-confirm" href="'.site_url('units/delete/$1').'">
                                <i class="fa fa-trash text-danger"></i> '.lang('delete').'
                            </a>
                        </div>
                    </div>';
		$this->datatables->select('id,name,code,sort,active,created_at');
		$this->datatables->from('units');
        $this->datatables->where('delete',0);
		$this->datatables->add_column('action',$actions, 'id');
		$this->datatables->unset_column('id');
		echo $this->datatables->generate();
	}
    public function delete($id = null) {
        $this->checkRule('unit_delete', false);
        if ($this->unit_model->deletUnit($id)) {
            $this->session->set_flashdata('message', lang('unit_deleted'));
            redirect('units');
        }
    }
}
