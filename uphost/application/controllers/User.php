<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12-Jan-17
 * Time: 8:23 PM
 */
class User extends MY_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    // dang ki thanh vien
    function register()
    {
        if($this->session->userdata('user_id_login'))
        {
            redirect();
        }
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[2]');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('re_password', 'Re-password', 'required|matches[password]');
            // test nhap vao
            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                $data['email'] = $this->input->post('email');
                $data['password'] = md5($this->input->post('password'));
                $data['created'] = now();
                if ($this->user_model->create($data)) {
                    $this->session->set_flashdata('message', 'Register Succeed');
                } else $this->session->set_flashdata('message', 'Can not register');
                //chuyen sang trang danh sach
                redirect(site_url());
            }

        }
        // load view
        $this->data['temp'] = 'site/user/register';
        $this->load->view('site/layout', $this->data);
    }
    function login()
    {
        if($this->session->userdata('user_id_login'))
        {
            redirect();
        }
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        if ($this->input->post())
        {
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('login', 'login', 'callback_check_login');
            if($this->form_validation->run())
            {
                // lay thong tin thanh vien
                $user = $this->_get_user_info();
                $this->session->set_userdata('user_id_login', $user->id);
                redirect();
            }
        }
        // load view
        $this->data['temp'] = 'site/user/login';
        $this->load->view('site/layout', $this->data);
    }
    function check_login()
    {
        $user = $this->_get_user_info();
        if($user)
            return true;
        else {
            $this->form_validation->set_message(__FUNCTION__,'User name or password was wrong !');
            return false;
        }

    }
    private function _get_user_info()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $where =array('email'=>$email, 'password'=>$password);
        $user = $this->user_model->get_info_rule($where);
        return $user;
    }
    function logout()
    {
        if($this->session->userdata('user_id_login'))
        {
            $this->session->unset_userdata('user_id_login');
            redirect();
        }
    }
    // thong tin ca nhan thanh vien
    function index()
    {
        if(!$this->session->userdata('user_id_login'))
        {
            redirect(site_url('user/login'));
        }
        $user_id = $this->session->userdata('user_id_login');
        $user = $this->user_model->get_info($user_id);
        if(!$user)
        {
            redirect(site_url('user/login'));
        }
        $this->data['user'] = $user;
        // load view
        $this->data['temp'] = 'site/user/index';
        $this->load->view('site/layout', $this->data);
    }
    function edit()
    {
        if(!$this->session->userdata('user_id_login'))
        {
            redirect(site_url('user/login'));
        }
        $user_id = $this->session->userdata('user_id_login');
        $user = $this->user_model->get_info($user_id);
        if(!$user)
        {
            redirect(site_url('user/login'));
        }
        $this->data['user'] = $user;
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $password = $this->input->post('password');
            if($password)
            {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
                $this->form_validation->set_rules('re_password', 'Re-password', 'required|matches[password]');
            }
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[2]');
            // test nhap vao
            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                if($password)
                {
                    $data['password'] = md5($password);
                }
                if ($this->user_model->update($user->id,$data)) {
                    $this->session->set_flashdata('message', 'update Succeed');
                } else $this->session->set_flashdata('message', 'Can not update');
                //chuyen sang trang danh sach
                redirect(site_url('user'));
            }

        }
        // load view
        $this->data['temp'] = 'site/user/edit';
        $this->load->view('site/layout', $this->data);
    }
}