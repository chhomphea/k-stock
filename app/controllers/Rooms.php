<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Rooms extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('rooms_model');
    }
    public function create() {
        $this->checkRule('room_add', false);
        $this->form_validation->set_rules('branch', lang('branches'), 'required');
        if ($this->form_validation->run() == true) {
            $countRoom = sizeof($this->input->post('branchId'));
            for ($i=0; $i < $countRoom; $i++) { 
                $roomDatas [] = [
                    'branch_id'     => $_POST['branchId'][$i],
                    'floor_id'      => $_POST['floorId'][$i],
                    'name'          => $_POST['roomName'][$i],
                    'price'         => $_POST['roomPrice'][$i],
                    'order_display' => $_POST['orderDisplay'][$i],
                ];
            }
        }
        if ($this->form_validation->run() == true && $this->rooms_model->CreateRooms($roomDatas)) {
            $this->session->set_flashdata('message', lang('room_added'));
            redirect('rooms');
        } else {
            $this->data['branches'] = $this->site->getAllBranches();
            $this->data['floors']   = $this->site->getAllFloors();
            $this->data['error']    = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                     = [['link' => site_url('rooms'), 'page' => lang('rooms')], ['link' => '#', 'page' => lang('create_room')]];
            $meta                   = ['page_title' => lang('update_room'), 'bc' => $bc];
            $this->page_construct('rooms/add', $this->data, $meta);
        }
    }
    public function delete($id = null) {
        $this->checkRule('room_delete', true);
        if ($this->rooms_model->deleteRooms($id)) {
            $this->session->set_flashdata('message', lang('room_deleted'));
            redirect('rooms');
        }
    }
    public function edit($id = null) {
        $this->checkRule('room_edit', false);
        $this->form_validation->set_rules('branch', lang('branch'), 'required');
        $this->form_validation->set_rules('floor', lang('floor'), 'required');
        $this->form_validation->set_rules('name', lang('name'), 'required');
        $this->form_validation->set_rules('price', lang('price'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'branch_id'     => $_POST['branch'],
                'floor_id'      => $_POST['floor'],
                'name'          => $_POST['name'],
                'price'         => $_POST['price'],
                'order_display' => $_POST['order_display'],
                'active'        => $_POST['display'],
            ];
        }
        if ($this->form_validation->run() == true && $this->site->updateTable($id, $data, 'rooms')) {
            $this->session->set_flashdata('message', lang('room_updated'));
            redirect('rooms');
        } else {
            $this->data['rowData']    = $this->site->getDataID($id, 'rooms');
            $this->data['branches']   = $this->site->getAllBranches();
            $this->data['floors']     = $this->site->getAllFloors($this->data['rowData']->branch_id);
            $this->data['error']      = (validation_errors()?validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('rooms'), 'page' => lang('rooms')], ['link' => '#', 'page' => lang('update_room')]];
            $meta                     = ['page_title' => lang('update_room'), 'bc' => $bc];
            $this->page_construct('rooms/edit', $this->data, $meta);
        }
    }
    public function get_rooms() {
        $actions            ='<div class="dropdown">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="fas fa-list"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="'.site_url('rooms/edit/$1').'"><i class="fa fa-edit text-primary"></i> '.lang('update').'</a></li>
                                    <li><a class="dropdown-item delete-confirm" href="'.site_url('rooms/delete/$1').'"><i class="fa fa-trash text-danger"></i> '.lang('delete').'</a></li>
                                </ul>
                            </div>';
        $this->load->library('datatables');
        $this->datatables->select('rooms.id, branch.branch_kh as branch, floors.name as floor,rooms.name as room,rooms.price,rooms.active,rooms.order_display');
        $this->datatables->from('rooms');
        $this->datatables->join('branches branch','branch.id=rooms.branch_id');
        $this->datatables->join('floors','floors.id=rooms.floor_id');
        $this->datatables->where('rooms.deleted',0);
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function index() {
        $this->checkRule('room_view', false);
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('rooms'), 'page' => lang('rooms')]];
        $meta                     = ['page_title' => lang('rooms'), 'bc' => $bc];
        $this->page_construct('rooms/index', $this->data, $meta);
    }
    public function getFloorBranch () {
        $branchId = $this->input->get('branchId');
        $floors   = $this->site->getAllFloors($branchId);
        $options  = '<option value="">'.lang("please_select").'</option>';
        foreach ($floors as $key => $floor) {
            $options .= '<option value="'.$floor->id.'">'.$floor->name.'</option>';
        }
        echo json_encode($options);
    }
}
