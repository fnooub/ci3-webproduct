<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21-Dec-16
 * Time: 2:06 PM
 */
class MY_Controller extends CI_Controller
{
    // bien gui du lieu
    public $data = array();

    function __construct()
    {
        // ke thua tu CI
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
        $controller = $this->uri->segment(1);
        switch ($controller) {
            case 'admin' : {
                $this->load->helper('admin');
                $this->_check_login();
                //xu li trang tren admin
                break;
            }
            default: {
                // xu li tren trang ngoai
                // lay danh sach danh muc catalog
                $this->load->model('catalog_model');
                $input = array();
                $input['where'] = array('parent_id' => 0);
                $catalog_list = $this->catalog_model->get_list($input);
                foreach ($catalog_list as $row) {
                    $input['where'] = array('parent_id' => $row->id);
                    $subs = $this->catalog_model->get_list($input);
                    $row->subs = $subs;
                }
                $this->data['catalog_list'] = $catalog_list;
                //lay tin tuc
                $this->load->model('news_model');
                $input = array();
                $input['limit'] = array(5, 0);
                $news_list = $this->news_model->get_list($input);
                $this->data['news_list'] = $news_list;
                // kiem tra xem thanh vien da dang nhap hay chua
                $user_id_login = $this->session->userdata('user_id_login');
                if ($user_id_login) {
                    $this->load->model('user_model');
                    $user_info = $this->user_model->get_info($user_id_login);
                    $this->data['user_info'] = $user_info;
                }
                // goi thu vien
                $this->load->library('cart');
                // tong so san pham
                $this->data['total_items'] = $this->cart->total_items();
            }
        }

    }

    private function _check_login()
    {
        $controller = $this->uri->rsegment(1);
        $controller = strtolower($controller);
        $login = $this->session->userdata('login');
        // chua dang nhap ma truy cap vao controller admin
        if (!$login && $controller != 'login') {
            redirect(admin_url('login'));
        }
        if ($login && $controller == 'login') {
            redirect(admin_url('home'));
        }
        if (!in_array($controller, array('login','home')))
        {
            //kiem tra quyen
            $admin_id = $this->session->userdata('admin_id');
            $admin_root = $this->config->item('root_admin');
            if ($admin_id != $admin_root) {
                $permissions_admin = $this->session->userdata('permissions');
                $action = strtolower($this->uri->rsegment(2));
                $check = true;
                if (!isset($permissions_admin->{$controller}))
                    $check = false;
                $permissions_actions = $permissions_admin->{$controller};
                if (!in_array($action, $permissions_actions))
                    $check = false;
                if ($check == false) {
                    $this->session->set_flashdata('message', 'Ban ko co quyen truy cap vao trang nay !!!');
                    redirect(admin_url('home'));
                }
            }
        }
    }
}