<?php
defined ('BASEPATH') or exit (Warning);
class ShopDetailsApi extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MainModel');
    }
    public function  index()
    {

    }

    //get all the shops with the items while passing the shopid as parameter..
    public function shopInfo()
    {
       $key = $_GET['shopid'];
        $checkSearch=$this->MainModel->search($key);
        if($checkSearch!=1)
        {
            $data['items']=$checkSearch;
        }
        else
        {   
            $data['items']=array('message'=>'No Shops');
        }
        $this->load->view('Api/Json_output',$data);
    }
    //get all shops within the given radius.....

    public function GetItem()
    {
      $check['items']= $this->MainModel->input();
      $this->load->view('Api/Json_output',$check);
    }
}