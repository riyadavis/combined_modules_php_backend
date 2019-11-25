<?php
defined ('BASEPATH') or exit (Warning);
class ProductApi extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MainModel');
    }
    public function  index()
    {

    }
    //get inserted Product..
    public function insertProduct()
	{
		$data['items'] = $this->MainModel->insertProduct();
		$this->load->view('API/Json_output',$data);
	}
}