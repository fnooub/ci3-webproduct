<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 08-Jan-17
 * Time: 4:03 PM
 */
class Product extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
    }
    function catalog()
    {
        // lay ra loai catalog
        $id = intval($this->uri->rsegment(3));
        $this->load->model('catalog_model');
        $catalog = $this->catalog_model->get_info($id);
        if(!$catalog)
        {
            redirect();
        }
        $this->data['catalog']= $catalog;
        $input = array();
        // kiem tra la dnh muc cha hay danh muc con
        if($catalog->parent_id == 0)
        {
            $input_cat = array();
            $input_cat['where'] = array('parent_id'=>$id);
            $catalog_subs = $this->catalog_model->get_list($input_cat);
            if(isset($catalog_subs)) // neu co danh muc con
            {
                $catalog_subs_id = array();
                foreach ($catalog_subs as $sub)
                {
                    $catalog_subs_id[] = $sub->id;
                }
                $this->db->where_in('catalog_id',$catalog_subs_id); // lay ra cac san pham cua danh muc con
            }
            else
            {
                $input['where']['catalog_id'] = $id;
            }
        }
        else
        {
            $input['where']['catalog_id'] = $id;
        }


        // lay ra danh sach san pham thuoc danh muc do
        $this->data['total_rows'] = $this->product_model->get_total($input);
        // thu vien phan trang
        $this->load->library('pagination');
        $config = array();
        $config['total_rows'] = $this->data['total_rows'];
        $config['base_url'] = base_url('product/catalog/'.$id); // link hien thi du lieu
        $config['per_page'] = 3;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = False;
        $this->pagination->initialize($config);

        $segment = intval($this->uri->segment(4));
        $input['limit'] = array($config['per_page'], $segment);
        //neu ko co dong nay thi $input rong, ma rong la lay tat ca san pham nen se sai
        if(isset($catalog_subs_id))
        {
            $this->db->where_in('catalog_id', $catalog_subs_id);
        }
        $this->data['list'] = $this->product_model->get_list($input);
        // load view
        $this->data['temp'] = 'site/product/catalog';
        $this->load->view('site/layout',$this->data);
    }
    //xem chi tiet san pham
    function view()
    {
// lay ra loai catalog
        $id = intval($this->uri->rsegment(3));
        $product = $this->product_model->get_info($id);
        if(!$product)
        {
            redirect();
        }
        $this->data['product'] = $product;
        // lay ra danh sach anh di kem
        $image_list = json_decode($product->image_list);
        $this->data['image_list'] = $image_list;
        //lay ra danh muc tuong ung
        $this->load->model('catalog_model');
        $catalog = $this->catalog_model->get_info($product->catalog_id);
        $this->data['catalog'] = $catalog;
        //cap nhat lai luot xem, moi lan view thi tang mot luot
        $data = array();
        $data['view'] = $product->view + 1;
        $this->product_model->update($product->id,$data);
        // load view
        $this->data['temp'] = 'site/product/view';
        $this->load->view('site/layout',$this->data);
    }
    // tim kiem theo ten sp
    function search()
    {
        if($this->uri->rsegment(3) == 1)
        {
            $key = $this->input->get('term');
        }
        else {
            $key = $this->input->get('key-search');
        }
        $this->data['key'] = trim($key);
        $input = array();
        $input['like'] = array('name',$key);
        $list = $this->product_model->get_list($input);

        if($this->uri->rsegment(3) == 1)
        {
            // xu li autocomplete
            $result = array();
            foreach ($list as $row)
            {
                $item = array();
                $item['id'] = $row->id;
                $item['label'] = $row->name;
                $item['value'] = $row->name;
                $result[] = $item;
            }
            // du lieu tra ve duoi dang json
            die(json_encode($result));
        }
        else
            {


            $this->data['total_rows'] = count($list);
            // thu vien phan trang
            $this->load->library('pagination');
            $config = array();
            $config['total_rows'] = $this->data['total_rows'];
            $config['base_url'] = base_url('product/search/'); // link hien thi du lieu
            $config['per_page'] = 3;
            $config['uri_segment'] = 3;
            $config['use_page_numbers'] = False;
            $this->pagination->initialize($config);

            $segment = intval($this->uri->segment(3));
            $input['limit'] = array($config['per_page'], $segment);
            // lay ra danh sach theo tung trang
            $this->data['list'] = $this->product_model->get_list($input);

            // load view
            $this->data['temp'] = 'site/product/search';
            $this->load->view('site/layout', $this->data);
        }
    }
    // tim kiem theo gia chon vao
    function search_price()
    {
        $price_from = intval($this->input->get('price_from'));
        $price_to = intval($this->input->get('price_to'));
        $this->data['price_from'] = $price_from;
        $this->data['price_to'] = $price_to;
        //loc theo gia
        $input = array();
        $input['where'] = array('price >= ' => $price_from, 'price <= ' => $price_to );
        $list = $this->product_model->get_list($input);
        $this->data['list'] = $list;
        // load view
        $this->data['temp'] = 'site/product/search_price';
        $this->load->view('site/layout', $this->data);

    }
}