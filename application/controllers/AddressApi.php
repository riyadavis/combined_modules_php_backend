<?php
defined ('BASEPATH') or exit (Warning);
class AddressApi extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MainModel');
    }
    public function  index()
    {

    }
    public function InsertAddress()
    {
		$id = $this->input->get('id');
        
		$insertAddress = array( 'customerName'=>$this->input->post('customerName'),
								'customerAddress'=>$this->input->post('customerAddress'),
                                'deliveryPincode'=>$this->input->post('deliveryPincode'),
                                'landmark'=>$this->input->post('landmark'),
                                'mobileNumber'=>$this->input->post('mobileNumber'),
                               );
		$data['items'] = $this->MainModel->InsertAddress($id,$insertAddress);
		$this->load->view('API/Json_output',$data);
	}
}