<?php
defined ('BASEPATH') or exit (Warning);
class MainModel extends CI_Model
{
 //customer signin for the first time...........!!!
 public function signin($phonenumber)
  {
      if( $phonenumber!=null)
      { $this->db->trans_start();
        $query=$this->db->query(" SELECT id FROM customertable WHERE customer_mobile = '$phonenumber'")->row();
        $this->db->trans_complete();
        if($query==null)
        {
          $salt="adastratechnologiesprivatelimited";
          $mob=$_POST['phonenumber'].$salt;
          $enc=sha1($mob);
                
          if($enc!=null)
          {
            $insert= array('salt'=>$enc);
            $this->db->trans_start();
            $this->db->insert('api_table',$insert);
            $this->db->trans_complete();
            if($this->db->trans_status()==true)
            {
              $insert= array('customer_mobile'=>$phonenumber);
              $this->db->trans_start();
              $this->db->insert('customertable',$insert);
              $this->db->trans_complete();
                      
              if($this->db->trans_status()==true)
              {
                $this->db->trans_start();
                $check_query=$this->db->query("SELECT id FROM customertable where 
                                              customer_mobile='$phonenumber'")->row();
                $this->db->trans_complete();                              
                if($check_query!=null)
                {
                  $id=$check_query->id;
                  
                  if($id!=null)
                  {
                    $insert=array('customer_id'=>$id);
                    $this->db->trans_start();
                    $this->db->insert('verificationtable',$insert);
                    $this->db->trans_complete();
                    $array = array('phonenumber'=>$phonenumber,
                                   'id'         =>$id);
                    return $array;
                    }
                  }
                }
              }
            }
          }
          else
          {
           $this->db->trans_start();
           $check_query=$this->db->query("SELECT id FROM customertable where 
                                          customer_mobile='$phonenumber'")->row();
           $this->db->trans_complete();                              
           $id=$query->id;
           $array = array('phonenumber'=>$phonenumber,
                          'id'           =>$id);
           return $array;
          }
      }
  }
  ////login  where user exist only..
  public function login($phonenumber)
  {
        $this->db->trans_start();
        $flag1=$this->db->query(" SELECT count(*) as count from customertable
                               where customer_mobile='$phonenumber'")->row();
        $this->db->trans_complete();                       
        if($flag1->count!=1)
        {
          return 1;
        }
        else
        {
            $this->db->trans_start();
            $result = $this->db->query("SELECT id FROM customertable WHERE
                                        customer_mobile = '$phonenumber'")->row();
            $this->db->trans_complete();                            
            $id=$result->id;
            $array = array('phonenumber'=>$phonenumber,
                            'id'        =>$id);
            return $array;
        }
    }
  //sends the data to pusher....!!
  public function send($id)
  {
      if($id!=null)
      {
          $Generator = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
          $otp = substr(str_shuffle($Generator),0,5);
          $insert=array(
                        'otp_code'      =>$otp ,
                        'verify_expiry' => strtotime('+40 seconds')
                        );
          $this->db->trans_start();              
          $this->db->where('customer_id',$id);
          $this->db->update('verificationtable',$insert);
          $this->db->trans_complete();
          $array = array('otp' =>$otp,
                         'id'  =>$id);
          return $array;
      }
  }

  //verification for login,signup...
 //need to get the otp and id,otp willl expires after40seconds...
  public function verification($array)
    {
        $myid=$array['id'];
        $otp=$array['otp'];
        $current = time();
        $this->db->trans_start();
        $flag=$this->db->query("SELECT count(*) as count from Verificationtable
                                where customer_id='$myid' and otp_code='$otp' and 
                                verify_expiry > '$current'")->row();
        $this->db->trans_complete();                        
        if($flag->count!=1)
        {
            $result='not-verified';
            $insert=array(
                           'verified_status'=>$result,
                         );
            $this->db->trans_start();             
            $this->db->where('customer_id',$myid);             
            $this->db->update('verificationtable',$insert);
            $this->db->trans_complete();
            return 2;
        }
        else
        {
            $result='verified';
            $insert=array(
                            'verified_status'=>$result,
                         );
            $this->db->trans_start();             
            $this->db->where('customer_id',$myid);
            $this->db->update('verificationtable',$insert);
            $this->db->trans_complete();
            return 1;
        }
    }
    // for delivery address ... if phone number is given by user use it, otherwise use regisered number
    public function retrieveNumber($id)
    {
        if($id != null)
        {
            $mobile = $this->db->query("select customer_mobile from customer where id = '$id'")->result();
            if($this->db->affected_rows()>0)
            {
                return $mobile;
            }
            else
            {
                return ["error"=>true, "reason"=>"mobile error"];
            }
        }
        else
        {
            return ["error"=>true, "reason"=>"user error"];
        }
    }



    //get all the coupons..
    public function getCoupon()
    {
        $getCoupon = $this->db->query('select * from coupon')->result_array();
        return ["error"=>false, "reason"=>$getCoupon];
    }

    //coupon activate..
    public function CouponActivate($arr)
    {
        $couponCode = $arr['couponCode'];
        $userid     = $arr['userid'];
        
        //coupon code validation ie, whether the coupon code exists in coupon table
        $couponInfo = $this->db->query("select id,MaxusePC from coupon where coupon_code = '$couponCode'")->row();

        if($this->db->affected_rows()>0)
        { 
                    $couponCount = $this->db->query("select UseCount from couponsubscription where customer_id = '$userid' AND coupon_id = '$couponInfo->id'")->row();
                    $useCount =  $couponCount->UseCount;
                    $maxCount = $couponInfo->MaxusePC;
                    if($this->db->affected_rows() > 0)
                    {
                        if($useCount < $maxCount)
                        {
                            $useCount = $useCount+1;
                            $this->db->trans_start();
                                $this->db->set('Usecount', $useCount);
                                $this->db->set('time_stamp', Date('Y-m-d h:i:s'));
                                $this->db->update('couponsubscription');
                            $this->db->trans_complete();
                            return ["error"=>false,"reason"=>"coupon subscribed"];
                        }
                        else
                        {
                            return ["error"=>true, "reason"=>"max limit reached"];
                        }
                        
                    }
                    else
                    {
                        $insert = array('customer_id'=>$userid,
                                        'coupon_id'=>$couponInfo->id,
                                    'UseCount'=>1,
                                'time_stamp'=>Date('Y-m-d h:i:s'));

                        $this->db->trans_start();
                            $this->db->insert('couponsubscription',$insert);
                        $this->db->trans_complete();
                        return ["error"=>false, "reason"=>"coupon subscribed for first time"];
                    }
        }
        else
        {
            return ["error"=>true, "reason"=>"Invalid Coupon"];
        }
    }
    //get the order 
    public function PlaceOrder($userid)
    {
        if($userid)
        {
            $getData = $this->db->query("select * from cart_table where customer_id = '$userid'")->result_array();
            return ["error"=>false, "reason"=>$getData];
        }
        else
        {
            return ["error"=>true, "reason"=>"invalid user"];
        }
        
    }
    //insert order to database
    public function InsertOrder($userid,$items,$cartId)
    {
    
        $deliveryBoyId = 1;
        $orderArray = array('time_stamp'=>Date('Y-m-d h:i:s'),
                        'customer_id'=>$userid,
                        'getItems'=>json_encode($items),
                        'deliveryBoyId'=>$deliveryBoyId);
        
        $orderId = $this->db->query("select * from customer_order where customer_id = '$userid'")->row();
        if($this->db->affected_rows()>0)
        {
            $this->db->trans_start();
            $this->db->where('customer_id',$userid);
                $this->db->update('customer_order',$orderArray);
            $this->db->trans_complete();
        }
        else
        {
            $this->db->trans_start();
                $this->db->insert('customer_order',$orderArray);
            $this->db->trans_complete();
        
        }
            $this->db->trans_start();
                $this->db->where('id',$cartId);
                $this->db->set('items_added',"");
                    $this->db->update('cart_table');
            $this->db->trans_complete();
        return ["error"=>false, "reason"=>"order placed"];
       
    }
    //insert address
    public function InsertAddress($id,$insertAddress)
    {
        $insert =  json_encode($insertAddress);
        
        
        $deliverTo = $this->input->post('deliverTo');

        if($this->input->post('mobileNumber')!=null)
        {
            $rows = $this->db->query("select * from deliveryinfo where customer_id = '$id'")->row();
            if($this->db->affected_rows()<0)
            {
                $idInput = array('customer_id'=>$id);
                $this->db->trans_start();
                    $this->db->insert('deliveryinfo',$idInput);
                $this->db->trans_complete();
            }
           
            if($deliverTo == 'Workplace')
            {
                $insertArray = array('customer_id'=>$id,
                            'WorkAddress'=>$insert);
                $this->db->trans_start();
                    $this->db->where('customer_id',$id);
                        $this->db->update('deliveryinfo',$insertArray);
                $this->db->trans_complete();
                if($this->db->trans_status() === TRUE)
                {
                    return ["error"=>false, "reason"=>"success"];
                }
                else
                {
                    return ["error"=>true, "reason"=>"update failed"];
                }
            }
            else if($deliverTo == 'Home')
            {
                $insertArray = array('customer_id'=>$id,
                            'HomeAddress'=>$insert);
                $this->db->trans_start();
                    $this->db->where('customer_id',$id);
                        $this->db->update('deliveryinfo',$insertArray);
                $this->db->trans_complete();
                if($this->db->trans_status() === TRUE)
                {
                    return ["error"=>false, "reason"=>"success"];
                }
                else
                {
                    return ["error"=>true, "reason"=>"update failed"];
                }
            }
            else
            {
                $insertArray = array('customer_id'=>$id,
                            'Other'=>$insert);
                $this->db->trans_start();
                    $this->db->where('customer_id',$id);
                        $this->db->update('deliveryinfo',$insertArray);
                $this->db->trans_complete();
                if($this->db->trans_status() === TRUE)
                {
                    return ["error"=>false, "reason"=>"success"];
                }
                else
                {
                    return ["error"=>true, "reason"=>"update failed"];
                }
            }
        }
        else
        {
            return ["error"=>true, "reason"=>"empty"];
        }       
    }
    //Add cart....database
    public function addCart($iduser)
    {
        $source_id = 1;
         
        $this->db->query("select * from customer where id = '$iduser'")->result_array();
        if($this->db->affected_rows()>0)
        {
            $items = $this->db->query("select items_added from cart_table where customer_id = '$iduser'")->result_array();
            
            //if customer id and shop id already exists
            if($this->db->affected_rows()>0)
            {
                
                    $insert = json_decode(file_get_contents("php://input"), true);
                    $this->db->trans_start();
                        $this->db->where('customer_id',$iduser);
                        $this->db->where('source_id',$source_id);
                        $this->db->set('items_added',json_encode($insert));
                        $this->db->set('time_stamp',Date('Y-m-d h:i:s'));
                        $this->db->update('cart_table');
                    $this->db->trans_complete();
                    if($this->db->trans_status() === TRUE)
                    {
                        return ["error"=>false, "reason"=>"item inserted"];
                    }
                    else
                    {
                        return ["error"=>true, "reason"=>"insert failed"];
                    }

                }
                else
                {
                    $jsonArray = json_decode(file_get_contents("php://input"), true);
                    $addCart = array('customer_id'=>$iduser,
                                    'items_added'=>json_encode($jsonArray),
                                    'source_id'=>$source_id,
                                    'time_stamp'=>Date('Y-m-d h:i:s'));
                    $this->db->trans_start();
                        $this->db->insert('cart_table',$addCart);
                    $this->db->trans_complete();
                    if($this->db->trans_status() === TRUE)
                    {
                        return ["error"=>false, "reason"=>"item inserted"];
                    }
                    else
                    {
                        return ["error"=>true, "reason"=>"insert failed"];
                    }
                }
        }
        else
        {
            return ["error"=>true, "reason"=>"invalid user"];
        }
    //    return json_decode(file_get_contents("php://input"), true);
    }
    //Retrieve cart..
    public function RetrieveCart($userid)
    {
            if($userid)
            {
                $RetrieveData = $this->db->query("select * from cart_table where customer_id = '$userid'")->result_array();
                return ["error"=>false, "reason"=>$RetrieveData];
            }
            
    }
    //get inserted product..
    public function insertProduct()
    {
        $insertProduct = $this->db->query("select * from product")->result_array();
        return ["error"=>false, "reason"=>$insertProduct];
    }
    //get all the shops with the items while passing the shopid as parameter
    public function shopInformation($key)
    {
            $this->db->trans_start();
            $result = $this->db->query("SELECT id FROM distributor_table WHERE dist_id = '$key'")->row();
            $this->db->trans_complete();
            if($result!=null)
            {
                $id=$result->id;
                $this->db->trans_start();
                $query=$this->db->query("SELECT category_id,dist_id,product_name,product_price,max_discount ,min_discount,product_tags
                                        from product where dist_id = '$id'")->result_array();
                $this->db->trans_complete();
                return $query;
            }
            else
            {
                return 1;
            }
    }
    public function GetAllShopsWithinLimit()
    {
        $lat=10.050317;
        $lng=76.329552; 
        $radius=10;
        $this->db->trans_start();
        $query = $this->db->query("SELECT id,dist_name,rating,  (6371 * acos(cos( radians('".$lat."')) * 
                                  cos(radians( JSON_EXTRACT(coordinates,'$.latitude') )) * 
                                  cos(radians(JSON_EXTRACT(coordinates,'$.longitude')) - radians('".$lng."')) 
                                  + sin(radians('".$lat."')) * sin(radians(JSON_EXTRACT(coordinates,'$.latitude') ))))
                                  AS distance FROM distributor_table HAVING distance < '".$radius."' ORDER BY
                                  distance LIMIT 0,20")->result_array();
        $this->db->trans_complete();                          
        $shops = $query;                         
        $i=0;
        foreach($shops as $value)
        {
            // $shops[$i]['offer'] = $this->db->query('SELECT  offer_name, offer_image_thumbnail from offer where offer_id = '.$value['id'])->result_array();
            $category = $this->db->query('SELECT  Category_name from category where cat_id = '.$value['id'])->result_array();
            $shops[$i]['category'] = $category[0]['Category_name'];
            $i++;
        }
        return $shops;
  }
  //search with keyword
  public function searchResult($searchItem)
  {
								//number of shops related to search
        $searchShop = $this->db->query("select count(*) as count from distributor_hub where hub_name like '%$searchItem%'")->result_array();
        $shopSearchCount = $searchShop[0]['count'];
								//total no. of shops in database
        $totalShop = $this->db->query("select count(*) as count from distributor_hub")->result_array();
        $totalShopCount = $totalShop[0]['count'];

								//number of products related to search
        $searchProduct = $this->db->query("select count(*) as count from product where product_name like '%$searchItem%'")->result_array();
        $productSearchCount = $searchProduct[0]['count'];
								//total no. products in database
        $totalProduct = $this->db->query("select count(*) as count from product")->result_array();
        $totalProductCount = $totalProduct[0]['count'];

								//number of tags in products table related to search keyword
        $searchProductTag = $this->db->query("select count(*) as count from product where MATCH (product_tags) AGAINST ('".$searchItem."')")->result_array();
        $ProductTagcount = $searchProductTag[0]['count'];
        
								//check probability
        $shopProbability = $shopSearchCount/$totalShopCount;
        $productProbability = $productSearchCount/$totalProductCount;
        $tagProbability = $ProductTagcount/$totalProductCount;

        $highestProbability = max($shopProbability,$productProbability,$tagProbability);

        if($highestProbability == $shopProbability)
        {
            $shopLists = $this->db->query("select id,hub_name as name,pickup_address,image from distributor_hub where hub_name like '%$searchItem%'")->result_array();
            return $shopLists;
        }
       else if($highestProbability == $productProbability)
       {
            $productLists = $this->db->query("select id,hub_id,product_name as name,product_image as image,product_price as price from product where product_name like '%$searchItem%'")->result_array();
            return $productLists;
       }
       else 
       {
           $tagLists = $this->db->query("select id,hub_id,product_name as name,product_image as image,product_price as price,product_tags as tags from product where MATCH(product_tags) AGAINST('$searchItem')")->result_array();
           return $tagLists;
       }
    }
    //shop search within radius..
    public function shopsWithinRadius($coor, $keyword)
    {
        $lat = $coor['lat'];
        $lng = $coor['lng'];
        $radius = 10;
        $start = 0;
        $end = 20;
        $distanceQuery = $this->db->query("SELECT id,(6371 * acos(cos( radians('".$lat."')) * 
                              cos(radians( JSON_EXTRACT(location_coordinate,'$.latitude') )) * 
                              cos(radians(JSON_EXTRACT(location_coordinate,'$.longitude')) - radians('".$lng."')) 
                              + sin(radians('".$lat."')) * sin(radians(JSON_EXTRACT(location_coordinate,'$.latitude') ))))
                              AS distance FROM distributor_hub HAVING distance < '".$radius."' ORDER BY
                              distance LIMIT $start,$end")->result_array();
    
        for($i = 0;$i < count($distanceQuery); $i++)
        {
            $nearShopId[$i] = json_decode($distanceQuery[$i]['id']);            
        }
        $productHub = $this->db->query("select hub_id from product where product_name = '$keyword'")->result_array();
        if($this->db->affected_rows()>0)
        {
            for($i = 0;$i < count($productHub); $i++)
            {
                $hubIdArray[$i] = $productHub[$i]['hub_id'];
            }
            $this->db->where_in('id',$nearShopId);
            $this->db->where_in('id',$hubIdArray);
                $availableShops = $this->db->get('distributor_hub')->result_array();
            if($availableShops){
                foreach($availableShops as &$val)
                {
                    $val['distance'] = $distanceQuery[array_search($val['id'],array_column($distanceQuery, 'id'))]['distance'];
                }
                return ["error"=>false, "reason"=>$availableShops];
            }
            else
            {
                return ["error"=>true, "reason"=>"product is not available near you"];
            }
        }
        else
        {
            $this->db->where_in('hub_name',$keyword);
            $this->db->where_in('id',$nearShopId);
            $searchedShop = $this->db->get('distributor_hub')->result_array();
            if($searchedShop)
            {
                foreach($searchedShop as &$val)
                {
                    $val['distance'] = $distanceQuery[array_search($val['id'],array_column($distanceQuery, 'id'))]['distance'];
                }
                return ["error"=>false, "reason"=>$searchedShop];
            }
            else
            {
                return ["error"=>true, "reason"=>"no shops near you"];
            }
        }
    }
}
