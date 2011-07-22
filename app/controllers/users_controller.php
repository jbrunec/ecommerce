<?php
class UsersController extends AppController{
	
	var $name = 'Users';
	/**
	 * User Model
	 * @var User
	 */
	var $User;
	
	
	function beforeFilter(){
		parent::beforeFilter();		
			
		
		$this->Auth->autoRedirect = false;
		//doseg za neregistrirane osebe
		$this->Auth->allow('login','logout','register','admin_login');
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
		if($this->action == 'register'){
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
	
	function login(){
		if($this->Auth->user()){
			
			$this->User->updateLastLogin($this->Auth->user('id'));
			$this->redirect(array('controller' => 'carts', 'action' => 'index'));
		}
	}
	
	function logout(){
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
				$this->Session->setFlash('For christ\'s sake, would you at least care to login in the right place, puny human!!!');
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
	
	function admin_reset_password($userId){
	    if(!$id){
	        $this->Session->setFlash('Wrong user ID!');
	    }
	}
	
	
	
}

?>