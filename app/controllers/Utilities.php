<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Utilities extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('utilities_model');
    }
    public function setup($id = null) {
        $this->checkRule('utilities_setup', false);
        $this->form_validation->set_rules('code', lang('code'), 'required');
        $this->form_validation->set_rules('name', lang('name'), 'required');
        $this->form_validation->set_rules('branch', lang('branches'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'branch_id'     => $_POST['branch'],
                'code'          => $_POST['code'],
                'name'          => $_POST['name'],
            ];
            $rowCount   = sizeof($this->input->post('from'));
            for ($i=0; $i < $rowCount; $i++) { 
                $utilitiPrice [] = array(
                    'utility_id' => $id,
                    'from'       => $_POST['from'][$i],
                    'to'         => $_POST['to'][$i],
                    'price'      => $_POST['price'][$i],
                );
            }
        }
        if ($this->form_validation->run() == true && $this->utilities_model->setUpprice($id, $data,$utilitiPrice)) {
            $this->session->set_flashdata('message', lang('utilities_setup'));
            redirect('utilities');
        } else {
            $this->data['rowData']    = $this->site->getDataID($id, 'utilities');
            $this->data['rows']       = $this->utilities_model->utilitiesPrice($id);
            $this->data['branches']   = $this->site->getAllBranches();
            $this->data['error']      = (validation_errors()?validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('rooms'), 'page' => lang('rooms')], ['link' => '#', 'page' => lang('update_room')]];
            $meta                     = ['page_title' => lang('update_room'), 'bc' => $bc];
            $this->page_construct('utilities/edit', $this->data, $meta);
        }
    }
    public function get_utilities() {
        $actions    ='<div class="dropdown">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-list"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="'.site_url('utilities/view/$1').'"><i class="fa fa-eye text-primary"></i> '.lang('view_price').'</a></li>
                            <li><a class="dropdown-item" href="'.site_url('utilities/setup/$1').'"><i class="fa fa-edit text-primary"></i> '.lang('update').'</a></li>
                            <li><a class="dropdown-item delete-confirm" href="'.site_url('utilities/delete/$1').'"><i class="fa fa-trash text-danger"></i> '.lang('delete').'</a></li>
                        </ul>
                    </div>';
        $this->load->library('datatables');
        $this->datatables->select('utilities.id,utilities.code,utilities.name,branches.branch_kh as branch');
        $this->datatables->from('utilities');
        $this->datatables->join('branches','branches.id=utilities.branch_id');
        $this->datatables->where('utilities.deleted',0);
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
     public function utility_prices ($id=null) {
        $actions    ='<div class="dropdown">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-list"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item delete-confirm" href="'.site_url('utilities/delete/$1').'"><i class="fa fa-trash text-danger"></i> '.lang('delete').'</a></li>
                        </ul>
                    </div>';
        $this->load->library('datatables');
        $this->datatables->select('utilities_prices.id,utilities.name,branches.branch_kh as branch,utilities_prices.from,utilities_prices.to,utilities_prices.price');
        $this->datatables->from('utilities');
        $this->datatables->join('branches','branches.id=utilities.branch_id');
        $this->datatables->join('utilities_prices','utilities.id=utilities_prices.utility_id');
        $this->datatables->where('utilities.deleted',0);
        $this->datatables->where('utilities.id',$id);
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function index() {
        $this->checkRule('utilities_view', false);
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('utilities'), 'page' => lang('utilities')]];
        $meta                     = ['page_title' => lang('utilities'), 'bc' => $bc];
        $this->page_construct('utilities/index', $this->data, $meta);
    }
    public function view ($id=null) {
        $this->data['id']         = $id;
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('utilities'), 'page' => lang('utilities')]];
        $meta                     = ['page_title' => lang('utilities'), 'bc' => $bc];
        $this->page_construct('utilities/views', $this->data, $meta);
    }
    public function delete($id = null) {
        $this->checkRule('utilities_delete', true);
        if ($this->utilities_model->deleteUtilities($id)) {
            $this->session->set_flashdata('message', lang('utilities_deleted'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
