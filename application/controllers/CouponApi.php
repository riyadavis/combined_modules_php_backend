<?php
defined ('BASEPATH') or exit (Warning);
class CouponApi extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MainModel');
    }
    public function  index()
    {

    }
    // to get all  coupons..
    public function getCoupon()
	{
		$data['items'] = $this->MainModel->getCoupon();
		$this->load->view('API/Json_output',$data);
    }
    //coupon activate...
    public function CouponActivate()
	{
		$arr = array('couponCode' => $this->input->post('couponCode'),
					 'userid'     => $this->input->post('userId'));
		$data['items'] = $this->MainModel->CouponActivate($arr);
		$this->load->view('API/Json_output',$data);
	}

}