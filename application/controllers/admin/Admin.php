<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23-Dec-16
 * Time: 10:49 PM
 */
class Admin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
    }

    //lay danh sach admin
    function index()
    {
        $input = array();
        $list = $this->admin_model->get_list($input);
        $total = $this->admin_model->get_total();
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        // gan thong bao loi de truyen vao view
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['temp'] = 'admin/admin/index';
        $this->load->view('admin/main', $this->data);
    }

    function create()
    {
        $data = array();
        $data['username'] = 'admin1';
        $data['password'] = 'admin1';
        $data['name'] = 'hieu';
        If ($this->admin_model->create($data))
            echo 'Inserted Success';
        else echo 'Inserted Failed';
    }

    function update()
    {
        $id = '8';
        $data = array();
        $data['username'] = 'admin2';
        $data['password'] = 'admin2';
        $data['name'] = 'hieu';
        if ($this->admin_model->update($id, $data))
            echo 'Update Success';
        else echo 'Update Failed';
    }

    function delete()
    {
        $id = '8';
        if ($this->admin_model->delete($id))
            echo 'Delete Success';
        else echo 'Delee Failed';
    }

    function get_info()
    {
        $id = '1';
        $info = $this->admin_model->get_info($id);
        echo '<pre>';
        print_r($info);
    }

    function get_list()
    {
        $input = array();
        $input['where'] = array('id' => 1);
        $input['order'] = array('id', 'asc');
        $list = $this->admin_model->get_list($input);
        pre($list);
    }

    // kiem tra ton tai user name trong db hay chua
    function check_username()
    {
        $username = $this->input->post('username');
        $where = array('username' => $username);
        if ($this->admin_model->check_exist($where)) {
            $this->form_validation->set_message(__FUNCTION__, 'Tai khoan da ton tai, nhap tai khoan khac');
            return false;
        }
        return true;

    }

    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[8]');
            $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('re_password', 'Re-password', 'matches[password]');
            // test nhap vao
            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = md5($this->input->post('password'));

                $permissions = $this->input->post('permissions');
                $data['permissions'] = json_encode($permissions);
                if ($this->admin_model->create($data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                //chuyen sang trang danh sach
                redirect(admin_url('admin'));
            }

        }
        //phan quyen
        $this->config->load('permissions',true);
        $config_permissions = $this->config->item('permissions');
        $this->data['config_permissions']=$config_permissions;
        $this->data['temp'] = 'admin/admin/add';
        $this->load->view('admin/main', $this->data);
    }

    // chinh sua thong tin quan tri vien
    function edit()
    {
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        // cho bien data[] truoc de khoi mat du lieu khi khai bao lai

        // lay ra id quan tri vien can sua
        $id = intval($this->uri->rsegment('3'));
        // lay info quan tri vien
        $info = $this->admin_model->get_info($id);
        if (!$info) {
            $this->session->set_flashdata('message', 'Your admin not exist , check again');
            redirect(admin_url('admin'));
        }
        $info->permissions = json_decode($info->permissions);
        $this->data['info'] = $info;

        if ($this->input->post())
        {
            $this->form_validation->set_rules('name', 'name', 'required|min_length[8]');
            $username = $this->input->post('username');
            if ($username != $info->username) {
                $this->form_validation->set_rules('username', 'username', 'required|callback_check_username');
            } else {
                $this->form_validation->set_rules('username', 'username', 'required');
            }
            //co thay doi mat khau hay ko
            $password = $this->input->post('password');
            if ($password) {
                $this->form_validation->set_rules('password', 'password', 'required|min_length[6]');
                //ở trang update khi ngoài matches password thì re-password phải có thêm reqiured
                $this->form_validation->set_rules('re_password', 're-password', 'required|matches[password]');
                // neu thay doi mat khau thi moi thay doi mat khau

            }
            //Nếu cập nhập username thì kiểm tra có tồn tại username đó hay chưa


            if ($this->form_validation->run()) {
                //insert to db
                $dator = array();
                $dator['name'] = $this->input->post('name');
                if ($username)
                    $dator['username'] = $username;
                if ($password)
                    $dator['password'] = md5($password);
                $permissions = $this->input->post('permissions');
                $dator['permissions'] = json_encode($permissions);
                if ($this->admin_model->update($id, $dator)) {
                    // seesion dung dc o trang index vi session ton tai ca chuong trinh
                    $this->session->set_flashdata('message', 'Updated Succeed');
                } else $this->session->set_flashdata('message', 'Can not update');
                //chuyen sang trang danh sach
                redirect(admin_url('admin'));
            }
        }
        //phan quyen
        $this->config->load('permissions',true);
        $config_permissions = $this->config->item('permissions');
        $this->data['config_permissions']=$config_permissions;
        $this->data['temp'] = 'admin/admin/edit';
        $this->load->view('admin/main', $this->data);
    }

}