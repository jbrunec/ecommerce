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
    	        $key = Security::hash(String::uuid(),'sha1',true);
    	        $this->data['Ticket']['key'] = $key;
    	        
    	        $url = Router::url($this->here,true).'/'.$key;
    	        //pr($this->data);
    	        //die;
    	        if($this->Ticket->save($this->data)){
    	            //$this->MyEmail->send();
    	            $this->Session->setFlash('notification email has been sent to you with reset data');
    	        }
            }elseif(!empty($hasTicket)){
                $this->Session->setFlash('You have a pending email in your inbox already! Go get it lazy ass!');
            } 
    	        
    	}elseif(isset($key) && !empty($key)){
	        $result = $this->Ticket->find('first', array('conditions' => array('Ticket.key' => $key)));
	        
	        if(!empty($result)){
	            $user = $this->Ticket->findUser($result['Ticket']['email']);
	            //pr(urlencode('lolekbolek'));
	            //die;
	            $this->redirect(array('controller' => 'users', 'action' => 'changeUserPassword/uid:'.urlencode($user['User']['id'])));
	        }
	    }else{
    	    $this->Session->setFlash('Please provide your email!');
	    }
	    
	    
	    
    }
}
?>