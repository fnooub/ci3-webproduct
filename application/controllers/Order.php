<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-Jan-17
 * Time: 1:15 PM
 */
class Order extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('transaction_model');
        $this->load->model('order_model');
    }
    // Nhap thong tin khach hang
    function checkout()
    {
        //thong tin gio hang
        $carts = $this->cart->contents();
        // tong so san pham
        $total_items = $this->cart->total_items();
        if($total_items <= 0)
        {
            redirect();
        }
        //tong so tien thanh toan
        $total_amount = 0;
        foreach ($carts as $row) {
            $total_amount += $row['subtotal'];
        }
        $this->data['amount'] = $total_amount;
        //mac dinh chua dang nhap thi la khach
        $user_id = 0;
        $user = '';
        //neu thanh vien da dang nhap
        if($this->session->userdata('user_id_login'))
        {
            $user_id = $this->session->userdata('user_id_login');
            $user = $this->user_model->get_info($user_id);
            if(!$user)
            {
                redirect(site_url('user/login'));
            }
        }

        $this->data['user'] = $user;
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post())
        {
            $this->form_validation->set_rules('name', 'Tên', 'required|min_length[2]');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('phone', 'so dien thoai', 'required|min_length[10]');
            $this->form_validation->set_rules('message', 'ghi chu', 'required');
            $this->form_validation->set_rules('payment', 'Cong thanh toan', 'required');

            // test nhap vao
            if ($this->form_validation->run()) {
                $payment = $this->input->post('payment');
                //insert to db
                $data = array();
                $data['user_name'] = $this->input->post('name');
                $data['user_email'] = $this->input->post('email');
                $data['user_phone'] = $this->input->post('phone');
                $data['message'] = $this->input->post('message');
                //mac dinh chua thanh toan
                $data['status'] = 0;
                $data['user_id'] =$user_id;
                $data['amount'] = $total_amount; ; // tong so tien thanh toan
                $data['payment'] = $payment; //cong thanh toan
                $data['created'] = now();
                //HOA DON, them du lieu vao transaction
                $this->transaction_model->create($data);
                //lay ra id cua hoa don vua roi
                $transaction_id = $this->db->insert_id();
                //CHI TIET HOA DON, them vao order
                foreach ($carts as $row)
                {
                    $data = array(
                        'transaction_id'=> $transaction_id,
                        'product_id'=> $row['id'],
                        'qty'=>$row['qty'],
                        'amount'=>$row['subtotal'],
                        'status'=>0
                    );
                    $this->order_model->create($data);
                }
                // xoa toan bo gio hang
                $this->cart->destroy();

                //neu thanh toan offline redirect
                if($payment == 'offline') {
                    $this->session->set_flashdata('message', 'Buy Succeed');
                    redirect();
                }
                //neu thanh toan bang bao kim thi mo cong thanh toan
                elseif (in_array($payment,array('nganluong','baokim')))
                {

                }
            }

        }
        //load view
        $this->data['temp'] = 'site/order/checkout';
        $this->load->view('site/layout', $this->data);
    }

}