<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-Jan-17
 * Time: 7:31 PM
 */
class Cart extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

    }

    //them san pham vao gio
    function add()
    {
        //lay rs id san pham can them vao gio
        $id = intval($this->uri->rsegment(3));
        $this->load->model('product_model');
        $product = $this->product_model->get_info($id);
        if (!$product) {
            redirect();
        }
        //tong so san pham
        $qty = 1;
        if ($product->discount > 0) {
            $price = $product->price - $product->discount;
        } else {
            $price = $product->price;
        }
        // thong tin them vao gio
        $data = array('id' => $product->id,
            'qty' => $qty,
            'name' => url_title($product->name), // do cart trong ci ko ho tro utf-8
            'image_link' => $product->image_link,
            'price' => $price
        );
        //them
        $this->cart->insert($data);
        // sang gio hang
        redirect(base_url('cart'));

    }

    // hien thi danh sach sp trong gio
    function index()
    {
        //thong tin gio hang
        $carts = $this->cart->contents();
        // tong so san pham
        $total_items = $this->cart->total_items();

        $this->data['carts'] = $carts;
        $this->data['total_items'] = $total_items;

        //load view
        $this->data['temp'] = 'site/cart/index';
        $this->load->view('site/layout', $this->data);

    }

    // cap nhat gio hang
    function update()
    {
        //thong tin gio hang
        $carts = $this->cart->contents();
        foreach ($carts as $key => $row) {
            //tong so san pham
            $total_qty = $this->input->post('qty_' . $row['id']);
            $data = array();
            $data['rowid'] = $key;
            $data['qty'] = $total_qty;
            $this->cart->update($data);
        }
        redirect(base_url('cart/index'));
    }

    // xoa cac san pham trong gio
    function del()
    {
        $id = intval($this->uri->rsegment(3));
        if ($id > 0) // xoa 1 san pham
        {
            //thong tin gio hang
            $carts = $this->cart->contents();
            foreach ($carts as $key => $row) {
                if ($row['id'] == $id)
                {
                    $data = array();
                    $data['rowid'] = $key;
                    $data['qty'] = 0;
                    $this->cart->update($data);
                }
            }
        } else {
            //xoa toan bo gio hang
            $this->cart->destroy();
        }
        redirect(base_url('cart/index'));

    }
}