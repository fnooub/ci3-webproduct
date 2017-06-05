<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 01-Mar-17
 * Time: 10:45 AM
 */
class CV extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $this->load->view('cv/cv');
    }
}