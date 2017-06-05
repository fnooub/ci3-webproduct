<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 21-Dec-16
 * Time: 2:10 PM
 */
class Login extends MY_Controller
{
    function index()
    {
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url'));
        if ($this->input->post())
        {
            $this->form_validation->set_rules('login', 'login', 'callback_check_login');
            if($this->form_validation->run())
            {
                $this->session->set_userdata('login', true);
                redirect(admin_url('home'));
            }
        }
        $this->load->view('admin/login/index');
    }
    function check_login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        
        $this->load->model('admin_model');
        $where =array('username'=>$username, 'password'=>$password);
        $admin = $this->admin_model->get_info_rule($where);
        if($admin) {
            $this->session->set_userdata('permissions',json_decode($admin->permissions));
            $this->session->set_userdata('admin_id',json_decode($admin->id));
            return true;
        }
        else {
            $this->form_validation->set_message(__FUNCTION__,'User name or password was wrong !');
            return false;
        }

    }
}