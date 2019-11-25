<?php
defined ('BASEPATH') or exit (Warning);
class CustomerLoginApi extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MainModel');
    }
    public function  index()
    {

    }
    //customer signin for the first time..if customer exist or not it sends the otp
    
    public function signin()
    {   
        $phonenumber=$this->input->post('phonenumber');
        $data=$this->MainModel->signin($phonenumber);
        $push=$this->send($data);
    }
    ///login if the customer exist only,if exist only it send otp
    public function login()
    {
        $phonenumber=$this->input->post('phonenumber');
        $check=$this->MainModel->login($phonenumber);
        if($check==1)
        {
            $response['items']=array('message'=>'No user');
        }  
        else
        { 
            $push=$this->send($check);
            $response['items']=array('id'=>$check['id']);
        }
        $this->load->view('Api/Json_output',$response);
    }
    //send function pushes the data when it get input....
    public function send($data)
    {
            $id=$data['id'];
            $data=$this->MainModel->send($id);
            $id1=$data['id'];
            echo $id1;
            $otp=$data['otp'];
            $myotp=$otp;   
            $this->load->library('Pusher');
            $this->pusher->push($myotp);
    }
    ///loading pusher......!!
    public function pusher()
    {   
        $this->load->view('pushme');
    }
    //verification for login,signup...
    //need to get the otp and id,otp willl expires after40seconds... 
    public function verification()
    {
        $array = array( 'id'=>$this->input->get('id'),
                        'otp' =>$this->input->get('otp')
                      ); 
        $check=$this->MainModel->verification($array);
        if($check!=1)
        {
            $response['items']=array('message'=>'failed');
        }
        else
        {
            $response['items']=array('message'=>' success'); 
        }
        $this->load->view('Api/Json_output',$response);
           
    }
     /// retrieve phonenumber..
    public function retrieveNumber()
    {      
		$id = $this->input->get('q');
		$data['items'] = $this->MainModel->retrieveNumber($id);
        $this->load->view('API/Json_output',$data);
	}





}
