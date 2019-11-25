<?php
defined ('BASEPATH') or exit (Warning);
class OrderApi extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MainModel');
    }
    public function  index()
    {

    }
     //To place the order..
    public function PlaceOrder()
	{
		$userid = $this->input->get('q');
		$data['items'] = $this->MainModel->PlaceOrder($userid);
		$this->load->view('API/Json_output',$data);
    }
    //insert Order...
    public function InsertOrder()
	{
		$items = json_decode(file_get_contents("php://input"), true);
		$userid = $this->input->get('q');
		$cartId = $this->input->post('cartId');
		$data['items'] = $this->MainModel->InsertOrder($userid,$items,$cartId);
		$this->load->view('API/Json_output',$data);
    }
    //orderConfirmation..   
    public function confirmMessage()
	{
		$this->load->view('vendor/autoload.php');
		$options = array(
			'cluster' => 'ap2',
			'useTLS' => true
			);
			$pusher = new Pusher\Pusher(
			'e6256b34427ca9b29815',
			'e1a37e8c0910ae055d3b',
			'838370',
			$options
			);
	
			$data['message'] = 'Your Order is confirmed';
			$pusher->trigger('my-channel', 'my-event', $data);
	}

}