<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Categories extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('categories_model');
    }
    public function create() {
        $this->checkRule('category_add', false);
        $this->form_validation->set_rules('name', lang('category_name'), 'required');
        $this->form_validation->set_rules('code', lang('category_code'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'display'       => $this->input->post('display'),
                'order_display' => $this->input->post('order_display'),
                'image'         => 'no_image.png',
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $this->tec->uploadFile();
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->insertTable($data, 'categories')) {
            $this->session->set_flashdata('message', lang('category_added'));
            redirect('categories');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('categories'), 'page' => lang('setup')], ['link' => '#', 'page' => lang('create_category')]];
            $meta                     = ['page_title' => lang('create_category'), 'bc' => $bc];
            $this->page_construct('categories/add', $this->data, $meta);
        }
    }
    public function delete($id = null) {
        $this->checkRule('category_delete', true);
        if ($this->categories_model->deleteCategory($id)) {
            $this->session->set_flashdata('message', lang('category_deleted'));
            redirect('categories');
        }
    }
    public function edit($id = null) {
        $this->checkRule('category_edit', false);
        $this->form_validation->set_rules('name', lang('category_name'), 'required');
        $this->form_validation->set_rules('code', lang('category_code'), 'required');
        if ($this->form_validation->run() == true) {
            $data = [
                'code'          => $this->input->post('code'),
                'name'          => $this->input->post('name'),
                'display'       => $this->input->post('display'),
                'order_display' => $this->input->post('order_display'),
            ];
            if ($_FILES['userfile']['size'] > 0) {
                $this->tec->uploadFile();
                $data['image'] = $this->tec->uploadFile();
            }
        }
        if ($this->form_validation->run() == true && $this->site->updateTable($id, $data, 'categories')) {
            $this->session->set_flashdata('message', lang('category_added'));
            redirect('categories');
        } else {
            $this->data['rowData']    = $this->site->getDataID($id, 'categories');
            $this->data['error']      = (validation_errors()?validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('categories'), 'page' => lang('setup')], ['link' => '#', 'page' => lang('update_category')]];
            $meta                     = ['page_title' => lang('update_category'), 'bc' => $bc];
            $this->page_construct('categories/edit', $this->data, $meta);
        }
    }
    public function get_categories() {
        $actions           =  '<div class="btn-group">
                                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="las la-list-ul"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="'.site_url('categories/edit/$1').'">
                                            <i class="fa fa-edit text-primary"></i> '.lang('update').'
                                        </a>
                                        <a class="dropdown-item delete-confirm" href="'.site_url('bracategoriesnches/delete/$1').'">
                                            <i class="fa fa-trash text-danger"></i> '.lang('delete').'
                                        </a>
                                    </div>
                                </div>';
        $this->load->library('datatables');
        $this->datatables->select('id, image, code, name, display as display,order_display');
        $this->datatables->from('categories');
        $this->datatables->add_column('Actions',$actions, 'id');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }
    public function import() {
        $this->load->helper('security');
        $this->form_validation->set_rules('userfile', lang('upload_file'), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if (isset($_FILES['userfile'])) {
                $this->load->library('upload');
                $config['upload_path']   = 'uploads/';
                $config['allowed_types'] = 'csv';
                $config['max_size']      = '500';
                $config['overwrite']     = true;
                $this->upload->initialize($config);
                if (! $this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('categories/import');
                }
                $csv       = $this->upload->file_name;
                $arrResult = [];
                $handle    = fopen('uploads/' . $csv, 'r');
                if ($handle) {
                    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                array_shift($arrResult);
                $keys  = ['code', 'name', '', '', '', '', ''];
                $final = [];
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                if (sizeof($final) > 1001) {
                    $this->session->set_flashdata('error', lang('more_than_allowed'));
                    redirect('categories/import');
                }
                foreach ($final as $csv_pr) {
                    if ($this->site->getCategoryByCode($csv_pr['code'])) {
                        $this->session->set_flashdata('error', lang('check_category') . ' (' . $csv_pr['code'] . '). ' . lang('category_already_exist'));
                        redirect('categories/import');
                    }
                    $data[] = ['code' => $csv_pr['code'], 'name' => $csv_pr['name']];
                }
            }
        }
        if ($this->form_validation->run() == true && $this->categories_model->add_categories($data)) {
            $this->session->set_flashdata('message', lang('categories_added'));
            redirect('categories');
        } else {
            $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $bc                       = [['link' => site_url('categories'), 'page' => lang('item_setup')], ['link' => '#', 'page' => lang('import_categories')]];
            $meta                     = ['page_title' => lang('import_categories'), 'bc' => $bc];
            $this->page_construct('categories/import', $this->data, $meta);
        }
    }
    public function index() {
        $this->checkRule('category_view', false);
        $this->data['error']      = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $bc                       = [['link' => site_url('categories'), 'page' => lang('list_categories')]];
        $meta                     = ['page_title' => lang('list_categories'), 'bc' => $bc];
        $this->page_construct('categories/index', $this->data, $meta);
    }
}
