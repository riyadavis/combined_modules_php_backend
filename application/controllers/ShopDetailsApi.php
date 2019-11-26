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
    public function shopInformation()
    {
       $key = $this->input->get('shopid');
        $checkSearch=$this->MainModel->shopInformation($key);
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
    public function GetAllShopsWithinLimit()
    {
      $check['items']= $this->MainModel->GetAllShopsWithinLimit();
      $this->load->view('Api/Json_output',$check);
    }
    //search......
    public function searchResult()
	{
		$searchItem = $this->input->get('q');
		$data['items'] = $this->MainModel->searchResult($searchItem);
		$this->load->view('API/Json_output',$data);
    }
    //shop search within radius..
    public function shopsWithinRadius()
	{
		$coor = array('lat'=> $this->input->post('lat'),
					'lng' => $this->input->post('long'));
		$keyword = $this->input->post('keyword');//keyword can be shop or product
		$data['items'] = $this->MainModel->shopsWithinRadius($coor,$keyword);
		$this->load->view('API/Json_output',$data);
	}
}