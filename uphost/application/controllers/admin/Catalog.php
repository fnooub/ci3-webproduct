<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 28-Dec-16
 * Time: 9:06 PM
 */
class Catalog extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('catalog_model');
    }

    function index()
    {
        $list = $this->catalog_model->get_list();
        $total = $this->catalog_model->get_total();
        $this->data['list'] = $list;
        $this->data['total'] = $total;
        // gan thong bao loi de truyen vao view
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['temp'] = 'admin/catalog/index';
        $this->load->view('admin/main', $this->data);
    }

    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required');
            // test nhap vao
            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                $data['parent_id'] = $this->input->post('parent_id');
                $data['sort_order'] = intval($this->input->post('sort_order'));
                if ($this->catalog_model->create($data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                //chuyen sang trang danh sach
                redirect(admin_url('catalog'));
            }

        }
        // lay danh sach danh muc cha
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $this->data['list'] = $this->catalog_model->get_list($input);

        $this->data['temp'] = 'admin/catalog/add';
        $this->load->view('admin/main', $this->data);
    }

    function edit()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $id = $this->uri->rsegment(3);
        $info = $this->catalog_model->get_info($id);
        if (!$info) {
            $this->session->set_flashdata('message', 'Can not edited');
            redirect(admin_url('catalog'));
        }
        $this->data['info'] = $info;
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required');
            // test nhap vao
            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                $data['parent_id'] = $this->input->post('parent_id');
                $data['sort_order'] = intval($this->input->post('sort_order'));
                if ($this->catalog_model->update($id, $data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                //chuyen sang trang danh sach
                redirect(admin_url('catalog'));
            }

        }
        // lay danh sach danh muc cha
        $input = array();
        $input['where'] = array('parent_id' => 0);
        $this->data['list'] = $this->catalog_model->get_list($input);

        $this->data['temp'] = 'admin/catalog/edit';
        $this->load->view('admin/main', $this->data);
    }

    function delete()
    {
        $id = $this->uri->rsegment(3);
        $info = $this->catalog_model->get_info($id);
        if (!$info) {
            $this->session->set_flashdata('message', 'Can not delete');
            redirect(admin_url('catalog'));
        }
        // kiem tra xem danh muc nay co san pham ko
        $this->load->model('product_model');
        $product = $this->product_model->get_info_rule(array('catalog_id'=>$id), 'id');
        if($product)
        {
            $this->session->set_flashdata('message', 'Cpo san pham r, xoa san pham truoc moi xoa duoc');
            redirect(admin_url('catalog'));
        }
        $this->catalog_model->delete($id);
        $this->session->set_flashdata('message', 'Delete Success');
        redirect(admin_url('catalog'));

    }

    // xoa danh muc da duoc danh dau
    function delete_check()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        $list = $this->catalog_model->get_list();
        foreach ($list as $row)
        {
            // lay ra tat ca cac checkbox co name la id.$row->id da duoc post
            // roi cu cai nao dc post thi ta xoa no trong db
            if ($this->input->post('id' . $row->id)) {
                $this->catalog_model->delete($row->id);
            }
        }


        $this->session->set_flashdata('message', 'Delete Success');
        redirect(admin_url('catalog'));
    }
}