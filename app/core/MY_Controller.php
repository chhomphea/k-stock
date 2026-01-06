<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if ($this->db->dbdriver == 'mysqli') {
            $this->db->query('SET SESSION sql_mode = ""');
        }
        $this->Settings = $this->site->getSettings();
        if ($spos_language = $this->input->cookie('spos_language', true)) {
            $this->Settings->selected_language = $spos_language;
            $this->config->set_item('language', $spos_language);
            $this->lang->load('app', $spos_language);
        } else {
            $this->Settings->selected_language = $this->Settings->language;
            $this->config->set_item('language', $this->Settings->language);
            $this->lang->load('app', $this->Settings->language);
        }
        $this->user               = $this->session->userdata('user_id');
        $this->showall            = $this->db->get_where('users',['id'=>$this->user])->row()->show_all_record;
        $this->permission         = $this->permission($this->user);
        $this->Settings->pin_code = $this->Settings->pin_code ? md5($this->Settings->pin_code) : null;
        $this->theme              = $this->Settings->theme . '/views/';
        $this->data['assets']     = base_url() . 'themes/default/assets/';
        $this->data['settings']   = $this->Settings;
        $this->data['currencies'] = $this->db->get_where("currencies")->result();
        $this->loggedIn           = $this->tec->logged_in();
        $this->data['loggedIn']   = $this->loggedIn;
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['units']      = $this->site->getAllUnits();
        $this->Admin              = $this->tec->in_group('admin') ? true : null;
        $this->data['Admin']      = $this->Admin;
        $this->m                  = strtolower($this->router->fetch_class());
        $this->v                  = strtolower($this->router->fetch_method());
        $this->data['m']          = $this->m;
        $this->data['GP']         = (array) $this->permission;
        $this->data['v']          = $this->v;
        $this->price_edit         = !$this->data['Admin']?$this->db->get_where('users',['id'=>$this->user])->row()->edit_price_sell:1;
        $this->allow_discount     = !$this->data['Admin']?$this->db->get_where('users',['id'=>$this->user])->row()->allow_discount:1;
    }
    public function permission($user_id=null){
        $gp = $this->site->getDataID($user_id,'users')->group_id;
        return $this->db->get_where('permissions',['group_id'=>$gp])->row();
    }
    public function storeUser($user_id=null){
        $store = $this->site->getDataID($user_id,'users')->store_id;
        return $store;
    }
    public function page_construct($page, $data = [], $meta = []) {
        if (empty($meta)) {
            $meta['page_title']  = $data['page_title'];
        }
        $meta['message']         = $data['message'] ?? $this->session->flashdata('message');
        $meta['error']           = $data['error']   ?? $this->session->flashdata('error');
        $meta['warning']         = $data['warning'] ?? $this->session->flashdata('warning');
        $meta['ip_address']      = $this->input->ip_address();
        $meta['Admin']           = $data['Admin'];
        $meta['GP']              = $data['GP'];
        $meta['loggedIn']        = $data['loggedIn'];
        $meta['Settings']        = $this->Settings;
        $meta['assets']          = $data['assets'];
        $meta['store']           = $data['store'];
        $this->session->unset_userdata('error');
        $this->session->unset_userdata('message');
        $this->session->unset_userdata('warning');
        $this->load->view($this->theme . 'header', $meta);
        $this->load->view($this->theme . $page, $data);
        $this->load->view($this->theme . 'footer');
    }
    public function checkRule($module=null,$type=null){
        if (!$this->Admin) {
            $permission = (array) $this->permission($this->user);
            if ($type) {
                if (!$permission[$module]) {
                    $this->session->set_flashdata('warning', lang('access_denied'));
                    $this->tec->dd();
                }
            }else{
                if (!$permission[$module]) {
                    $this->session->set_flashdata('warning', lang('access_denied'));
                    redirect('welcome');
                }
            }
        }
        return true;
    }
}
