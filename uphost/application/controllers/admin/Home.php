<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23-Dec-16
 * Time: 12:05 AM
 */
class Home extends MY_Controller
{
    function index()
    {
        $this->data['temp'] = 'admin/home/index';
        $this->load->view('admin/main',$this->data);
    }
    function logout()
    {
        if($this->session->userdata('login'))
        {
            $this->session->sess_destroy();
            //$this->session->unset_userdata('login');
            redirect(admin_url('login'));
        }
    }
}