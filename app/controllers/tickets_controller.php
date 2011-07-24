<?php
class TicketsController extends AppController{
    var $name = 'Tickets';
    /**
     * 
     * Ticket model
     * @var Ticket
     */
    var $Ticket;
    
    function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
    }
    
    
    function isAuthorized(){
            
    }
    
    function reset_user_password($key = null){
        
        
        if(!empty($this->data)){
            $user = $this->Ticket->findUser($this->data['Ticket']['email']);
            $hasTicket = $this->Ticket->find('first', array('conditions' => array('Ticket.email' => $user['User']['email'])));
            //pr($hasTicket);
            //die;
            if(!empty($user) && empty($hasTicket)){              
                App::import('Helper','Time');
                $time = new TimeHelper();
                
    	        $key = Security::hash(String::uuid(),'sha1',true);
    	        $this->data['Ticket']['key'] = $key;
    	        $this->data['Ticket']['creation_date'] = $time->format('Y-m-d H:i:s', time());
    	        $url = Router::url(array('controller' => 'tickets', 'action' => 'reset_user_password'),true).'/'.$key;
    	        //pr($url);
    	        //die;
    	        
    	        //ko se ticket shrani v bazo se poslje email (email element: lost_password_notification.ctp) useru, ki je ticket odprl
    	        if($this->Ticket->save($this->data)){
    	            $this->set('url', $url);
    	            $this->MyEmail->sendResetPasswordEmail($user['User']['email']);
    	            $this->Session->setFlash('notification email has been sent to you with reset data');
    	        }
            }elseif(!empty($hasTicket)){
                if($this->Ticket->checkTicketDateValidity($hasTicket)){
                    $this->Session->setFlash('We had already sent you a link to your email address! Go get it, lazy ass!');
                }else{
                    $this->Session->setFlash('Your ticket regarding lost password has been deleted due to expiration! Try submitting again');
                }
                
            } 
    	//se prozi kadar user klikne link, ki vsebuje generiran key, v svojem mailu in ga redirecta sem
    	}elseif(isset($key) && !empty($key)){
	        $result = $this->Ticket->find('first', array('conditions' => array('Ticket.key' => $key)));
	        $this->Ticket->checkTicketDateValidity($result);
	        if(!empty($result)){
	            $user = $this->Ticket->findUser($result['Ticket']['email']);
	            $this->set('userId',$user['User']['id']);
	            $this->set('key', $key);
	            
	            $this->Ticket->delete($result['Ticket']['id']);
	            //$this->redirect(array('controller' => 'users', 'action' => 'changeUserPassword/uid:'.$user['User']['id']));
	        }
	    }else{
	        
    	    $this->Session->setFlash('Please provide your email!');
	    }
	    
	    
	    
    }
}
?>