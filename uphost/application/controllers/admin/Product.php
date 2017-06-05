<?php

/**
 * Created by PhpStorm.
 * flash: Administrator
 * Date: 29-Dec-16
 * Time: 8:08 PM
 */
class Product extends MY_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');

    }

    function index()
    {
        //kiem tra co loc du lieu hay ko
        $input = array();
        $id = intval($this->input->get('id'));
        $input['where'] = array();
        if ($id > 0) {
            $input_temp['where']['id'] = $id;
        }
        $name = $this->input->get('name');
        if ($name) {
            $input['like'] = array('name', $name);
        }
        $catalog_id = intval($this->input->get('catalog'));
        if ($catalog_id) {
            $input['where']['catalog_id'] = $catalog_id;
        }
        //sau khi loc thi tong so du lieu thay doi, dan toi so trang bi thay doi theo

        $this->data['total_rows'] = $this->product_model->get_total($input);
        // thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $this->data['total_rows'];
        // neu ko search thi de link phan trang nhu binh thuong
        // if(!isset($id) || !isset($name) || !isset($catalog_id) )
        //{
        $config['base_url'] = admin_url('product/index'); // link hien thi du lieu	
        // }
        $config['per_page'] = 2;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $segment = intval($this->uri->segment(4));

        $input['limit'] = array($config['per_page'], $segment);

        $this->data['list'] = $this->product_model->get_list($input);

        // load filter list
        $this->load->model('catalog_model');
        // dat la input_catalog de tranh bi trung voi input cua product
        $input_catalog['where'] = array('parent_id' => 0);
        $catalog = $this->catalog_model->get_list($input_catalog);
        foreach ($catalog as $row) {
            $input_catalog['where'] = array('parent_id' => $row->id);
            $subs = $this->catalog_model->get_list($input_catalog);
            $row->subs = $subs;
        }
        $this->data['catalog'] = $catalog;
        // gan thong bao loi de truyen vao view
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['temp'] = 'admin/product/index';
        $this->load->view('admin/main', $this->data);
    }

    function search()
    {

        $this->load->library('form_validation');
        $this->load->helper('form');
        //neu co gui form tim kiem
        if ($this->input->post()) {
            $this->session->unset_userdata('id');
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('catalog');
            $input['where'] = array();
            $this->session->set_userdata('id', $this->input->post('id'));
            if ($this->session->userdata('id')) {
                $input['where']['id'] = $this->session->userdata('id');

            }
            $this->session->set_userdata('name', $this->input->post('name'));
            if ($this->session->userdata('name')) {
                $input['like'] = array('name', $this->session->userdata('name'));

            }
            $this->session->set_userdata('catalog', $this->input->post('catalog'));
            if ($this->session->userdata('catalog')) {
                $input['where']['catalog_id'] = $this->session->userdata('catalog');
            }
        }
        // cu tim theo session da gui trc do
        if (($this->session->userdata('id') || $this->session->userdata('name') || $this->session->userdata('catalog'))) {
            $input['where'] = array();
            if ($this->session->userdata('id')) {
                $input['where']['id'] = $this->session->userdata('id');

            }
            if ($this->session->userdata('name')) {
                $input['like'] = array('name', $this->session->userdata('name'));

            }
            if ($this->session->userdata('catalog')) {
                $input['where']['catalog_id'] = $this->session->userdata('catalog');
            }
        }


////////////////////////////////
        $this->data['total_rows'] = $this->product_model->get_total($input);
        // thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $this->data['total_rows'];
        // neu ko search thi de link phan trang nhu binh thuong
        // if(!isset($id) || !isset($name) || !isset($catalog_id) )
        //{
        $config['base_url'] = admin_url('product/search'); // link hien thi du lieu
        // }
        $config['per_page'] = 2;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $segment = intval($this->uri->segment(4));

        $input['limit'] = array($config['per_page'], $segment);

        $this->data['list'] = $this->product_model->get_list($input);

        // load filter list
        $this->load->model('catalog_model');
        // dat la input_catalog de tranh bi trung voi input cua product
        $input_catalog['where'] = array('parent_id' => 0);
        $catalog = $this->catalog_model->get_list($input_catalog);
        foreach ($catalog as $row) {
            $input_catalog['where'] = array('parent_id' => $row->id);
            $subs = $this->catalog_model->get_list($input_catalog);
            $row->subs = $subs;
        }
        $this->data['catalog'] = $catalog;
        // gan thong bao loi de truyen vao view
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['temp'] = 'admin/product/index';
        $this->load->view('admin/main', $this->data);
    }

    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required');
            $this->form_validation->set_rules('catalog', 'the loai', 'required');
            $this->form_validation->set_rules('price', 'gia', 'required');

            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                $data['catalog_id'] = $this->input->post('catalog');
                $data['price'] = $this->input->post('price');
                // xoa dau phay khi nhap tu jquery
                $data['price'] = str_replace(',', '', $data['price']);
                //lay ten file anh dai dien
                $upload_path = './upload/product/';
                $this->load->library('upload_library');
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $data['image_link'] = '';
                if (isset($upload_data['file_name'])) {
                    $data['image_link'] = $upload_data['file_name'];
                }
                // upload cac anh kem theo
                $data['image_list'] = array();
                $data['image_list'] = $this->upload_library->upload_file($upload_path, 'image_list');
                $data['image_list'] = json_encode($data['image_list']);
                // khac
                $data['discount'] = $this->input->post('discount');
                $data['warranty'] = $this->input->post('warranty');
                $data['gifts'] = $this->input->post('sale');
                $data['created'] = now();
                if ($this->product_model->create($data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                // chuyen sang trang danh sach
                redirect(admin_url('product'));

            }
        }
        // load catalog
        $this->load->model('catalog_model');
        $input_catalog['where'] = array('parent_id' => 0);
        $catalog = $this->catalog_model->get_list($input_catalog);
        foreach ($catalog as $row) {
            $input_catalog['where'] = array('parent_id' => $row->id);
            $subs = $this->catalog_model->get_list($input_catalog);
            $row->subs = $subs;
        }
        $this->data['catalog'] = $catalog;

        $this->data['temp'] = 'admin/product/add';
        $this->load->view('admin/main', $this->data);
    }

    // chinh sua
    function edit()
    {
        $id = intval($this->uri->rsegment(3));
        $product = $this->product_model->get_info($id);
        if (!$product) {
            $this->session->set_flashdata('message', 'Can not edited');
            redirect(admin_url('product'));
        }
        $this->data['product'] = $product;
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tên', 'required');
            $this->form_validation->set_rules('catalog', 'the loai', 'required');
            $this->form_validation->set_rules('price', 'gia', 'required');

            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                $data['catalog_id'] = $this->input->post('catalog');
                $data['price'] = $this->input->post('price');
                // xoa dau phay khi nhap tu jquery
                $data['price'] = str_replace(',', '', $data['price']);
                //lay ten file anh dai dien

                $upload_path = './upload/product/';
                $this->load->library('upload_library');
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                // neu co post thi moi co data, ko co data ko cap nhat cot day nua
                if (isset($upload_data['file_name'])) {
                    $data['image_link'] = $upload_data['file_name'];
                }
                // upload cac anh kem theo
                $image_list = array();
                $image_list = $this->upload_library->upload_file($upload_path, 'image_list');
                $image_list_json = json_encode($image_list);
                if (!empty($image_list)) {
                    $data['image_list'] = $image_list_json;
                }
                // khac
                $data['discount'] = $this->input->post('discount');
                $data['warranty'] = $this->input->post('warranty');
                $data['gifts'] = $this->input->post('sale');
                if ($this->product_model->update($product->id, $data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                // chuyen sang trang danh sach
                redirect(admin_url('product'));

            }
        }
        // load catalog
        $this->load->model('catalog_model');
        $input_catalog['where'] = array('parent_id' => 0);
        $catalog = $this->catalog_model->get_list($input_catalog);
        foreach ($catalog as $row) {
            $input_catalog['where'] = array('parent_id' => $row->id);
            $subs = $this->catalog_model->get_list($input_catalog);
            $row->subs = $subs;
        }
        $this->data['catalog'] = $catalog;

        $this->data['temp'] = 'admin/product/edit';
        $this->load->view('admin/main', $this->data);

    }

    function del()
    {
        $id = intval($this->uri->rsegment(3));
        $this->__delete($id);
        $this->session->set_flashdata('message', 'Successs delete');
        redirect(admin_url('product'));
    }

    // xoa nhieu san pham
    function del_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
            $this->__delete($id);

    }

    // ham ho tro xoa nhieu
    private
    function __delete($id)
    {
        $product = $this->product_model->get_info($id);
        if (!$product) {
            $this->session->set_flashdata('message', 'Can not edited');
            redirect(admin_url('product'));
        }
        // xoa
        $this->product_model->delete($id);
        // xoa anh
        $image_link = './upload/product/' . $product->image_link;
        if (file_exists($image_link)) {
            unlink($image_link);
        }
        //xoa anh kem theo
        $image_list = json_decode($product->image_list);
        if (is_array($image_list)) {
            foreach ($image_list as $img) {
                $image_link = './upload/product/' . $img;
                if (file_exists($image_link)) {
                    unlink($image_link);
                }
            }
        }
    }
}