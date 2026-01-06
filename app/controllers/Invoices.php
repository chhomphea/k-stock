<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Invoices extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('invoices_model');
    }
    public function utilities() {
        $this->checkRule('customer_view', false);
        $this->data['branches']   = $this->site->getAllBranches();
        $this->data['branches']   = $this->site->getAllBranches();
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('bookings'), 'page' => lang('utility_input')]];
        $meta                     = ['page_title' => lang('utility_input'), 'bc' => $bc];
        $this->page_construct('invoices/utilityinput', $this->data, $meta);
    }
    function getAllroomsStaying () {
        $floorId    = $this->input->get('floorId');
        $branchId   = $this->input->get('branch');
        $utilities  = $this->invoices_model->getAllUtitlities($branchId);
        $roomBooking= $this->invoices_model->getAllBooking($branchId, $floorId);
        if (empty($utilities) || empty($roomBooking)) {
            echo json_encode(['dataHtml' => '', 'utility' => $utilities]);
            return;
        }
        $roomIds = array_column($roomBooking, 'id');
        $this->db->select('room_id, utility_id, old_reading, new_reading, used_units');
        $this->db->from('room_utilities_reading');
        $this->db->where_in('room_id', $roomIds);
        $readings = $this->db->get()->result();
        $readingMap = [];
        foreach ($readings as $r) {
            $readingMap[$r->room_id][$r->utility_id] = $r;
        }
        $tableHtml  = '<thead>';
        $tableHtml  .= '<tr>';
        $tableHtml  .= '<th rowspan="2">'.lang('n.o').'</th>';
        $tableHtml  .= '<th rowspan="2" width="80px">'.lang('room').'</th>';
        foreach ($utilities as $utility) {
            $tableHtml  .= '<th colspan="3">'.$utility->name.'</th>';
        }
        $tableHtml  .= '<th rowspan="2" width="50px"><span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span></th>';
        $tableHtml  .= '</tr>';
        $tableHtml  .= '<tr>';
        foreach ($utilities as $utility) {
            $tableHtml  .= '<th>'.lang('old_number').'</th>';
            $tableHtml  .= '<th>'.lang('new_number').'</th>';
            $tableHtml  .= '<th>'.lang('used').'</th>';
        }
        $tableHtml  .= '</tr>';
        $tableHtml  .= '</thead>';
        $i = 1;
        foreach ($roomBooking as $row) {
            $tableHtml      .= '<tr>';
            $tableHtml      .= '<td class="text-center">'.$i.'</td>';
            $tableHtml      .= '<td class="text-center"><input type="hidden" name="room_id[]" value="'.$row->id.'" />'.$row->name.'</td>';
            foreach ($utilities as $utility) {
                $oldVal     = isset($readingMap[$row->id][$utility->id]) ? $readingMap[$row->id][$utility->id]->old_reading : 0;
                $newVal     = isset($readingMap[$row->id][$utility->id]) ? $readingMap[$row->id][$utility->id]->new_reading : 0;
                $usedVal    = isset($readingMap[$row->id][$utility->id]) ? $readingMap[$row->id][$utility->id]->used_units : 0;
                $tableHtml  .= '<td><input type="text" name="old'.$utility->id.'[]" value="'.$oldVal.'" readonly class="form-control input-sm" /></td>';
                $tableHtml  .= '<td><input type="text" name="new'.$utility->id.'[]" value="'.$newVal.'" class="form-control input-sm" /></td>';
                $tableHtml  .= '<td><input type="text" name="used'.$utility->id.'[]" value="'.$usedVal.'" readonly class="form-control input-sm" /></td>';
            }
            $tableHtml      .= '<th width="50px" class="text-center"><span class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></span></th>';
            $tableHtml      .= '</tr>';
            $i++;
        }
        echo json_encode(['dataHtml' => $tableHtml, 'utility' => $utilities]);
    }
    public function saveUtilities() {
        $branchId  = $this->input->post('branch');
        $utilities = $this->invoices_model->getAllUtitlities($branchId);
        $roomIds   = $this->input->post('room_id');
        $this->db->trans_start();
        foreach ($utilities as $utility) {
            $utilityId   = $utility->id;
            $oldReadings = $this->input->post('old' . $utilityId);
            $newReadings = $this->input->post('new' . $utilityId);
            $usedReadings= $this->input->post('used' . $utilityId);
            if (!$oldReadings || !$newReadings || !$usedReadings) {
                continue;
            }
            foreach ($roomIds as $index => $roomId) {
                $data = [
                    'branch_id'   => $branchId,
                    'room_id'     => $roomId,
                    'utility_id'  => $utilityId,
                    'old_reading' => floatval($oldReadings[$index]),
                    'new_reading' => floatval($newReadings[$index]),
                    'used_units'  => floatval($usedReadings[$index]),
                ];
                $existing = $this->db->get_where('room_utilities_reading', [
                    'branch_id'  => $branchId,
                    'room_id'    => $roomId,
                    'utility_id' => $utilityId
                ])->row();
                if ($existing) {
                    $this->db->where('id', $existing->id);
                    $this->db->update('room_utilities_reading', $data);
                } else {
                    $this->db->insert('room_utilities_reading', $data);
                }
            }
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Failed to save utilities. Please try again.');
        } else {
            $this->session->set_flashdata('message', 'Utilities saved successfully.');
        }
        redirect('invoices/utilities');
    }

}

