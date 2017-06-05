<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06-Jan-17
 * Time: 9:50 PM
 */
class Slide extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('slide_model');
    }

    function index()
    {
        $this->data['total_rows'] = $this->slide_model->get_total();

        $this->data['list'] = $this->slide_model->get_list();

        // gan thong bao loi de truyen vao view
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['temp'] = 'admin/slide/index';
        $this->load->view('admin/main', $this->data);
    }

    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Ten slide', 'required');
            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');

                //lay ten file anh dai dien
                $upload_path = './upload/slide/';
                $this->load->library('upload_library');
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $data['image_link'] = '';
                if (isset($upload_data['file_name']))
                {
                    $data['image_link'] = $upload_data['file_name'];
                }
                // khac
                $data['link'] = $this->input->post('link');
                $data['info'] = $this->input->post('info');
                $data['sort_order'] = $this->input->post('sort_order');
                if ($this->slide_model->create($data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                // chuyen sang trang danh sach
                redirect(admin_url('slide'));

            }
        }

        $this->data['temp'] = 'admin/slide/add';
        $this->load->view('admin/main', $this->data);
    }

    // chinh sua
    function edit()
    {
        $id = intval($this->uri->rsegment(3));
        $slide = $this->slide_model->get_info($id);
        if (!$slide) {
            $this->session->set_flashdata('message', 'Can not edited');
            redirect(admin_url('slide'));
        }
        $this->data['slide'] = $slide;
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Ten slide', 'required');

            if ($this->form_validation->run()) {
                //insert to db
                //insert to db
                $data = array();
                $data['name'] = $this->input->post('name');
                //lay ten file anh dai dien

                $upload_path = './upload/slide/';
                $this->load->library('upload_library');
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                // neu co post thi moi co data, ko co data ko cap nhat cot day nua
                if (isset($upload_data['file_name'])) {
                    $data['image_link'] = $upload_data['file_name'];
                }
                // khac
                $data['link'] = $this->input->post('link');
                $data['info'] = $this->input->post('info');
                $data['sort_order'] = $this->input->post('sort_order');
                if ($this->slide_model->update($slide->id, $data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                // chuyen sang trang danh sach
                redirect(admin_url('slide'));

            }
        }

        $this->data['temp'] = 'admin/slide/edit';
        $this->load->view('admin/main', $this->data);

    }

    function del()
    {
        $id = intval($this->uri->rsegment(3));
        $this->__delete($id);
        $this->session->set_flashdata('message', 'Successs delete');
        redirect(admin_url('slide'));
    }
    // xoa nhieu san pham
    function del_all()
    {
        $ids = $this->input->post('ids');
        foreach ($ids as $id)
            $this->__delete($id);

    }
    // ham ho tro xoa nhieu
    private function __delete($id)
    {
        $slide = $this->slide_model->get_info($id);
        if (!$slide) {
            $this->session->set_flashdata('message', 'Can not delete');
            redirect(admin_url('slide'));
        }
        // xoa
        $this->slide_model->delete($id);
        // xoa anh
        $image_link = './upload/slide/' . $slide->image_link;
        if (file_exists($image_link)) {
            unlink($image_link);
        }
    }
}