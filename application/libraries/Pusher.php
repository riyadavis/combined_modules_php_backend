<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pusher {

        public function push($message)
        {
            require(__DIR__.'/vendor/autoload.php');       
            $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
             );
            $pusher = new Pusher\Pusher('2778d2ac0fc0d4a099af','e3ceaf2ed1ad323f3e01','845983',$options);
                    
            $data['message'] = $message;
            $pusher->trigger('channelpush', 'my-event', $data);   
        }
}