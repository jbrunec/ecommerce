<?php
App::import('Core','Controller');
class MyEmailComponent extends Object{
    var $name = 'MyEmail';
    var $components = array('Session','Email');
    
    function sendEmail(){
        $this->Email->to = 'user@ecommerce.com';
        $this->Email->subject = 'pass reset';
        $this->Email->from = 'ecommerce Test Account <noreply@example.com>'; 
        $this->Email->sendAs = 'html';
        $this->Email->delivery = 'debug';
        $this->Email->template = 'password_change';
        //Set the body of the mail as we send it. 
        //Note: the text can be an array, each element will appear as a 
        //seperate line in the message body. 
        
        if ( $this->Email->send() ) { 
            $this->Session->setFlash('Simple email sent'); 
        } else { 
            $this->Session->setFlash('Simple email not sent'); 
        } 
        //$this->redirect('/'); 
    }
    
    //ko user sam odpre ticket se mu poslje ta mail
    function sendResetPasswordEmail($to){
        $this->Email->to = $to;
        $this->Email->subject = 'Lost password - DO NOT REPLY';
        $this->Email->from = 'ecommerce Test Account <noreply@example.com>'; 
        $this->Email->sendAs = 'html';
        $this->Email->delivery = 'debug';
        $this->Email->template = 'lost_password_notification';
        //Set the body of the mail as we send it. 
        //Note: the text can be an array, each element will appear as a 
        //seperate line in the message body. 
        
        if ( $this->Email->send() ) { 
            $this->Session->setFlash('Password reset email sent'); 
        } else { 
            $this->Session->setFlash('Email not sent'); 
        }  
    }
    
    
    function sendOrderReceivedEmail($to){
        $this->Email->to = $to;
        $this->Email->subject = 'Your order has been received and is now being processed!';
        $this->Email->from = 'ecommerce Test Account <noreply@example.com>'; 
        $this->Email->sendAs = 'html';
        $this->Email->delivery = 'debug';
        $this->Email->template = 'order_received';
        //Set the body of the mail as we send it. 
        //Note: the text can be an array, each element will appear as a 
        //seperate line in the message body. 
        
        if ( $this->Email->send() ) { 
            $this->Session->setFlash('Email with your order receipt has been sent!'); 
        } else { 
            $this->Session->setFlash('Email not sent'); 
        }
    }
    
    function sendOrderStatusEmail($to){
        $this->Email->to = $to;
        $this->Email->subject = 'Your order status update';
        $this->Email->from = 'ecommerce Test Account <noreply@example.com>'; 
        $this->Email->sendAs = 'html';
        $this->Email->delivery = 'debug';
        $this->Email->template = 'order_status';
        //Set the body of the mail as we send it. 
        //Note: the text can be an array, each element will appear as a 
        //seperate line in the message body. 
        
        if ( $this->Email->send() ) { 
            $this->Session->setFlash('Email with your order status has been sent!'); 
        } else { 
            $this->Session->setFlash('Email not sent'); 
        }
    }
}
?>