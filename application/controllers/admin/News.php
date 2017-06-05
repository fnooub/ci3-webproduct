<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06-Jan-17
 * Time: 8:21 PM
 */
class News extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('news_model');
    }

    function index()
    {
     
        $input = array();
        $id = intval($this->input->get('id'));
        $input['where'] = array();
        if ($id > 0) {
            $input['where']['id'] = $id;
        }
        $title = $this->input->get('title');
        if ($title) {
            $input['like'] = array('title', $title);
        }
        //sau khi loc thi tong so du lieu thay doi, dan toi so trang bi thay doi theo

        $this->data['total_rows'] = $this->news_model->get_total($input);
        // thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $this->data['total_rows'];
        $config['base_url'] = admin_url('news/index'); // link hien thi du lieu
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $segment = intval($this->uri->segment(4));

        $input['limit'] = array($config['per_page'], $segment);

        $this->data['list'] = $this->news_model->get_list($input);

        // gan thong bao loi de truyen vao view
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['temp'] = 'admin/news/index';
        $this->load->view('admin/main', $this->data);
    }

    function add()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Tieu de', 'required');
            $this->form_validation->set_rules('content', 'noi dung', 'required');
            if ($this->form_validation->run()) {
                //insert to db
                $data = array();
                $data['title'] = $this->input->post('title');
                $data['content'] = $this->input->post('content');

                //lay ten file anh dai dien
                $upload_path = './upload/news/';
                $this->load->library('upload_library');
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                $data['image_link'] = '';
                if (isset($upload_data['file_name']))
                {
                    $data['image_link'] = $upload_data['file_name'];
                }
                // khac
                $data['created'] = now();
                if ($this->news_model->create($data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                // chuyen sang trang danh sach
                redirect(admin_url('news'));

            }
        }

        $this->data['temp'] = 'admin/news/add';
        $this->load->view('admin/main', $this->data);
    }

    // chinh sua
    function edit()
    {
        $id = intval($this->uri->rsegment(3));
        $news = $this->news_model->get_info($id);
        if (!$news) {
            $this->session->set_flashdata('message', 'Can not edited');
            redirect(admin_url('news'));
        }
        $this->data['news'] = $news;
        $this->load->library('form_validation');
        $this->load->helper('form');
        // neu co gui post
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Tieu de', 'required');
            $this->form_validation->set_rules('content', 'noi dung', 'required');

            if ($this->form_validation->run()) {
                //insert to db
                //insert to db
                $data = array();
                $data['title'] = $this->input->post('title');
                $data['content'] = $this->input->post('content');
                //lay ten file anh dai dien

                $upload_path = './upload/news/';
                $this->load->library('upload_library');
                $upload_data = $this->upload_library->upload($upload_path, 'image');
                // neu co post thi moi co data, ko co data ko cap nhat cot day nua
                if (isset($upload_data['file_name'])) {
                    $data['image_link'] = $upload_data['file_name'];
                }
                // khac
                $data['created'] = now();
                if ($this->news_model->update($news->id, $data)) {
                    $this->session->set_flashdata('message', 'Inserted Succeed');
                } else $this->session->set_flashdata('message', 'Can not inserted');
                // chuyen sang trang danh sach
                redirect(admin_url('news'));

            }
        }

        $this->data['temp'] = 'admin/news/edit';
        $this->load->view('admin/main', $this->data);

    }

    function del()
    {
        $id = intval($this->uri->rsegment(3));
        $this->__delete($id);
        $this->session->set_flashdata('message', 'Successs delete');
        redirect(admin_url('news'));
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
        $news = $this->news_model->get_info($id);
        if (!$news) {
            $this->session->set_flashdata('message', 'Can not delete');
            redirect(admin_url('news'));
        }
        // xoa
        $this->news_model->delete($id);
        // xoa anh
        $image_link = './upload/news/' . $news->image_link;
        if (file_exists($image_link)) {
            unlink($image_link);
        }
    }
}