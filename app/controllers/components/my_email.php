<?php
//App::import('Email', 'Session');
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
    
    
    function sendResetPasswordEmail(){
        
    }
}
?>