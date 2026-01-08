<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sales extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('bookings_model');
    }
    public function create() {
        $this->checkRule('customer_add', false);
        $this->form_validation->set_rules('date', lang('date'), 'required');
        $this->form_validation->set_rules('branch', lang('branches'), 'required');
        $this->form_validation->set_rules('customer', lang('customer'), 'required');
        $this->form_validation->set_rules('phone', lang('phone'), 'required');
        if ($this->form_validation->run() == true) {
            $countRoom = sizeof($_POST['roomId']);
            for ($i=0; $i < $countRoom; $i++) { 
                $rooms[] = array(
                    'room_id'           => $_POST['roomId'][$i],
                    'check_in_date'     => $_POST['checkin_date'][$i],
                    'check_out_date'    => $_POST['check_out_date'][$i],
                    'monthly_rate'      => $_POST['roomPrice'][$i],
                    'duration_months'   => $_POST['duration_months'][$i],
                    'subtotal'          => $_POST['duration_months'][$i] * $_POST['roomPrice'][$i],
                );
            }
            $countProducts = sizeof($_POST['otherFee']);
            for ($i=0; $i < $countProducts; $i++) { 
                $bookingProducts[] = array(
                    'room_id'           => $_POST['service_room'][$i],
                    'product_id'        => $_POST['otherFee'][$i],
                    'quantity'          => $_POST['product_quantity'][$i],
                    'price'             => $_POST['product_price'][$i],
                    'subtotal'          => $_POST['product_subtotal'][$i],
                );
            }
            $data = [
                'branch_id'             => $this->input->post('branch'),
                'name'                  => $this->input->post('customer'),
                'phone'                 => $this->input->post('phone'),
                'booking_date'          => $this->input->post('date'),
                'deposit'               => $this->input->post('deposit'),
                'image'                 => 'no_image.png',
            ];
            if ($this->input->post('deposit')) {
                $invoiceNumber      = $this->site->getreference('deposit');
                $deposit            = array(
                    'date'          => $this->input->post('date'),
                    'amount'        => $this->input->post('deposit'),
                    'type'          => 'deposit',
                    'payment_status'=> 'unpaid',
                    'no'            => $invoiceNumber->no,
                    'invoice_no'    => $invoiceNumber->number,
                    'created_by'    => $this->session->userdata('user_id'),
                    'created_at'    => date("Y-m-d H:i:s"),
                );
            }
            if ($_FILES['userfile']['size'] > 0) {
                $this->tec->uploadFile();
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->bookings_model->saveBookings($data,$rooms,$bookingProducts,$deposit)) {
            $this->session->set_flashdata('message', lang('customer_added'));
            redirect('bookings');
        } else {
            $this->data['branches']   = $this->site->getAllBranches();
            $products                 = $this->site->getAllProducts();
            $options                  = "<option>".lang("please_select")."</option>";
            foreach ($products as $key => $row) {
                $options .= '<option value="'.$row->id.'">'.$row->name.'</option>';
            }
            $this->data['options']    = $options;
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['page_title'] = lang('bookings');
            $this->data['banks']      = $this->site->getAllBanks();
            $bc                       = [['link' => site_url('bookings'), 'page' => lang('bookings')], ['link' => '#', 'page' => lang('bookings')]];
            $meta                     = ['page_title' => lang('new_booking'), 'bc' => $bc];
            $this->page_construct('bookings/add', $this->data, $meta);
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
    public function getbookings() {
        $viewbooking=   '<a class="dropdown-item" href="'.site_url('bookings/view/$1').'"><i class="fa fa-print text-primary"></i> '.lang('print').'</a>';
        $update     =   '<a class="dropdown-item" href="'.site_url('customers/edit/$1').'"><i class="fa fa-edit text-primary"></i> '.lang('update').'</a>';
        $delete     =   '<a class="dropdown-item delete-confirm" href="'.site_url('customers/delete/$1').'"><i class="fa fa-trash text-danger"></i> '.lang('delete').'</a>';
        $actions    =   '<div class="dropdown">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-list"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>'.$viewbooking.'</li>
                                <li>'.$update.'</li>
                                <li>'.$delete.'</li>
                            </ul>
                        </div>';
        $this->load->library('datatables');
        $this->datatables->select('bookings.id, bookings.image, bookings.phone, bookings.name,DATE(booking_date) as booking_date,bookings.status,bookings.created_at,branches.branch_kh as branch_name');
        $this->datatables->from('bookings');
        $this->datatables->join('branches','branches.id=bookings.branch_id');
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function index() {
        $this->checkRule('customer_view', false);
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                  = [['link' => site_url('bookings'), 'page' => lang('list_bookings')]];
        $meta                = ['page_title' => lang('list_bookings'), 'bc' => $bc];
        $this->page_construct('sales/index', $this->data, $meta);
    }
    function getRoomsBybranchs () {
        $branch     = $this->input->get('branch');
        $this->db->where('branch_id', $branch);
        $this->db->where('deleted', 0);
        $this->db->where('id NOT IN(SELECT room_id FROM booking_details JOIN bookings ON bookings.id=booking_details.booking_id WHERE status <> "checked_out")');
        $rooms      = $this->db->get('rooms')->result();
        $options    = "<option>".lang("please_select")."</option>";
        foreach ($rooms as $key => $row) {
            $options .= "<option value='".$row->id."'>".$row->name."</option>";
        }
        echo json_encode($options);
    }
    function getRoombookings () {
        $roomId     = $this->input->get('room');
        $rowNumber  = $this->input->get('row');
        $this->db->select('rooms.*,floors.name as floor');
        $this->db->from('rooms');
        $this->db->join('floors', 'floors.id = rooms.floor_id');
        $this->db->where('rooms.id', $roomId);
        $roomInfo = $this->db->get()->row();
        $html   = "<tr>";
        $html   .= "<td class='text-center room-bg'>".$rowNumber."</td>";
        $html   .= '<td class="rowDate room-bg"><input type="text" name="checkin_date[]" class="form-control input-sm ç" value=""></td>';
        $html   .= '<td class="rowFloor room-bg">
                    <input type="hidden" name="floorId[]" value="'.$roomInfo->floor_id.'">'.$roomInfo->floor.'</td>';
        $html   .= '<td class="rowName room-bg"><input type="hidden" name="roomId[]" value="'.$roomInfo->id.'">'.$roomInfo->name.'</td>';
        $html   .= '<td class="rowMonths room-bg"><input type="text" name="duration_months[]" class="form-control input-sm" value=""></td>';
        $html   .= '<td class="rowCheckout room-bg"><input type="text" name="check_out_date[]" class="form-control input-sm datepicker" value=""></td>';
        $html   .= '<td class="rowPrice room-bg"><input type="text" name="roomPrice[]" class="form-control input-sm subtotal" value="'.($roomInfo->price * 1).'"></td>';
        $html   .= '<td class="text-center room-bg"><i class="fa fa-plus-circle fa-2x newRoom"></i></td>';
        $html   .= "</tr>";
        echo json_encode($html);
    }
    function getServicesId() {
        $serviceId = $this->input->get('serviceId');
        $row       = $this->bookings_model->getServiceDetail($serviceId);
        echo  json_encode($row);
    }
    function view ($id=null) {
        $this->data['page_title'] = lang('login');
        $this->page_construct('bookings/invoice', $this->data, $meta);
    }
    function deposit ($id=null) {
        $bc                       = [['link' => site_url('bookings'), 'page' => lang('list_bookings')]];
        $meta                     = ['page_title' => lang('list_bookings'), 'bc' => $bc];
        $this->page_construct('invoices/deposit', $this->data, $meta);
    }
}
