<?php
defined ('BASEPATH') or exit (Warning);
class CartApi extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MainModel');
    }
    public function  index()
    {

    }
    //Add cart....
    public function addCart()
	{
        
		$iduser = $this->input->get('id'); 
		$data['items'] = $this->MainModel->addCart($iduser);
		$this->load->view('API/Json_output',$data);
    }
    //RetrieveCart..
    public function RetrieveCart()
	{
		$userid = $this->input->get('q');
		$data['items'] = $this->MainModel->RetrieveCart($userid);
		$this->load->view('API/Json_output',$data);
	}
}