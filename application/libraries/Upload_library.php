<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 02-Jan-17
 * Time: 8:29 PM
 */
class Upload_library
{
    //$this trả về chính class đó, v nên ta phải get_instance để trả về self::controller,
    //hay chính là trả về đói tượng CI, vì $this bt của các controller hay views đề thừa kế từ CI,
    // nó chính đã là đói tượng CI r nên ko cần phải get_instance
    // http://stackoverflow.com/questions/4740430/explain-ci-get-instance
    protected $CI;
    public $config;

    function __construct()
    {
        $this->CI =& get_instance();
        $this->config = array();
        $this->config['allowed_types'] = 'gif|jpg|png';
        $this->config['max_size'] = 5000;
        $this->config['max_width'] = 1024;
        $this->config['max_height'] = 1024;
    }

    // upload
    function upload($upload_path = '', $file_name = '')
    {
        $this->config['upload_path'] = $upload_path;
        $this->CI->load->library('upload', $this->config);
        //success
        if ($this->CI->upload->do_upload($file_name)) {
            return $this->CI->upload->data();
        } else // up failed
        {
            return $this->CI->upload->display_errors();
        }
    }

    // upload nhieu file mot luc
    function upload_file($upload_path = '', $file_name = '')
    {
        $this->config['upload_path'] = $upload_path;
        //lưu biến môi trường khi thực hiện upload
        $file = $_FILES[$file_name];
        $count = count($file['name']);//lấy tổng số file được upload
        // lay ra ten nhung file da upload thanh cong de insert vao db
        $image_list = array();
        for ($i = 0; $i < $count ; $i++) {

            $_FILES['userfile']['name'] = $file['name'][$i];  //khai báo tên của file thứ i
            $_FILES['userfile']['type'] = $file['type'][$i]; //khai báo kiểu của file thứ i
            $_FILES['userfile']['tmp_name'] = $file['tmp_name'][$i]; //khai báo đường dẫn tạm của file thứ i
            $_FILES['userfile']['error'] = $file['error'][$i]; //khai báo lỗi của file thứ i
            $_FILES['userfile']['size'] = $file['size'][$i]; //khai báo kích cỡ của file thứ i
            //load thư viện upload và cấu hình
            $this->CI->load->library('upload', $this->config);
            //thực hiện upload từng file
            if ($this->CI->upload->do_upload()) {
                //nếu upload thành công thì lưu toàn bộ dữ liệu
                $data = $this->CI->upload->data();
                $image_list[] = $data['file_name'];
            }
        }
        return $image_list;
    }


    // cau hinh
    /*function config()
    {
        $config = array();
        $config['upload_path'] = './upload/product';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 1000;
        $config['max_width'] = 1024;
        $config['max_height'] = 1024;
        return $config;
    }*/
}