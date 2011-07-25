<?php
class UsersController extends AppController{
	
	var $name = 'Users';
	/**
	 * User Model
	 * @var User
	 */
	var $User;
	//var $Ticket;
	
	function beforeFilter(){
		parent::beforeFilter();		
			
		
		$this->Auth->autoRedirect = false;
		$this->Auth->loginRedirect = '/';
		//doseg za neregistrirane osebe
		$this->Auth->allow('login','logout','register','admin_login','reset_password','changeUserPassword');
		if($this->Auth->user()){
			//doseg za registrirane osebe
			$this->Auth->allow('login','logout','index','register','admin_login');
			
		}
		if($this->isAuthorized()){
			//doseg za admine
			$this->Auth->allow('*');
		}
		
		//$this->Auth->loginError = "false login credentials";
		//s tem overridamo Auth komponento za User model, da lahko uvedemo svoj hashing paswordov
		if($this->action == 'register' ){
			$this->Auth->authenticate = $this->User;
			
		}
	}
	
	function isAuthorized(){	
		if($this->Auth->user('admin')){
			pr('this user is admin');
			//exit;
			return true;
		}else{
			pr('this user is NOT admin');
			//exit;
			//$this->Session->setFlash('This area is for admins only!');
			return false;
		}
	}
	
	function index(){
		
	}
	
	function login($credentials = null){
	    pr($this->referer());
	    //die;
		if($this->Auth->user()){
			//$this->Session->write();
			$this->User->updateLastLogin($this->Auth->user('id'), $this->Session->read('Config.userAgent'));
			if($this->referer() != "/users/login"){
			    pr('in referer redirection');
			    //die;
			    $this->redirect($this->referer());
			}else{
			    pr('in regular redirection!');
			    //die;
			    $this->redirect(array('controller' => 'carts', 'action' => 'index'), null, true);
			}
			
			
			//$this->redirect($this->referer('/carts/index',false));
	    //se prozi v primeru ko stran usera sama prijavi ob spremembi passworda 
		}elseif(!empty($credentials)){
		    $this->Auth->login($credentials);
		    $this->User->updateLastLogin($this->Auth->user('id'));
		    $this->redirect(array('controller' => 'carts', 'action' => 'index'), null, true);
		}
		
		
		
	}
	
	function logout(){
	    $this->Session->delete('Auth.User');
		$this->Auth->logout();
		$this->redirect(array('controller' => 'carts', 'action' => 'index'));
	}
	
	
	function register(){
		if(!empty($this->data)){
				//$this->data['User']['reg_date'] = date("Y-m-d H:i:s", time());
				$this->User->create();
				if($this->User->save($this->data)){
					//$this->User->validates();
					$this->Auth->login($this->data);
					$this->Session->setFlash('Thank you for registering!'); 
					//$this->redirect(array('controller' => 'carts', 'action' => 'index'));
				}
			
		}
	}
	
	
	function changeUserPassword(){    
	    //argument userId pride iz ticket kontrolera ko user v mailu klikne na povezavo z appendanim unikatnim key-em
	    $this->set('userId', $this->data['User']['id']);
	    
	    if(!empty($this->data) && isset($this->data['User']['password'])){
	        //$password = $this->data['User']['password'];
	        //$sql = "UPDATE users SET users.password = '$password' WHERE users.id = $userId";
	        if($this->User->reset_password($this->data['User']['id'], $this->data)){
	            $this->Session->setFlash('Password changed successfully!');
	            $user = $this->User->find('first', array('conditions' => array('User.id' => $this->data['User']['id'])));
	            $this->login($user);
	        }else{
	            $this->Session->setFlash('Password change failed!');
	        }
	    }
	}
	

	
	/*
	 * Admin functions ***********************************************
	 */
	
	function admin_index(){
		
	
	}
	
	function admin_login(){
		if($this->Auth->user('admin')){
			$this->Session->setFlash('Hey Admin!');
			$this->redirect(array('controller' => 'users', 'action' => 'admin_index', 'admin' => true));
			exit();
		}elseif (!empty($this->data)){
			if($this->Auth->user('admin')){
				$this->redirect(array('controller' => 'users', 'action' => 'admin_index', 'admin' => true));
			}else{
				$this->data['User']['password'] = '';
				$this->Session->setFlash('For christ\'s sake, would you at least care to login at the right place, puny human!!!');
			}
			/*
			if($this->Auth->login($this->data)){
				//$this->admin_login();
			}*/			
			
		}else{
			$this->Session->setFlash('please login!');
		}
	}
	
	function admin_logout(){
		$this->Session->delete('Auth.User');
		$this->Auth->logout();
		$this->Session->setFlash('You have successfully logged off!');
		$this->redirect(array('controller' => 'carts', 'action' => 'index', 'admin' => false));
	}
	
	
	function admin_show_all_users(){
	    //$result = $this->User->find('all');
	    $this->set('users', $this->paginate());
	}
	
	function admin_reset_password(){
	    
	    $this->set('uid',$this->passedArgs['uid']);
	    
	    if(!empty($this->data)){
	        $changedPass = $this->data['User']['password'];
            
            
	        if($this->User->reset_password($this->passedArgs['uid'],$this->data)){
	            $this->Session->setFlash('Password changed successfully!');
	            
	            $this->set('changedPass',$changedPass);
	            $this->MyEmail->sendEmail();
	            $this->redirect(array('action' => 'admin_show_all_users','admin' => true));
	        }else{
	            $this->Session->setFlash('Password change error!');
	        }
	    }
	}
	
	
	
}

?>