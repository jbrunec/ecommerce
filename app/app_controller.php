<?php
class AppController extends Controller{
	
	var $helpers = array('Form','Html','Session','Js','Paginator','Time');
	var $components = array('Session','RequestHandler','Email','Auth');
	
	//id kategorije v parametru
	var $c;
	//id produkta 
	var $p;
	//id seje usera
	var $sid;
	
	function beforeFilter(){
		
		/*
		 * Nastavitve Auth componente
		 */
		$this->Auth->authorize = 'controller';
		$this->Auth->authError = 'You have to be logged in to access this page!';
		//debug($this->params['requested']);
		
		//omogoca klic akcij, ki jih zahtevajo elementi, drugace se aplikacija obesi na redirect loop >.<
		if (isset($this->params['requested'])) {
			$this->Auth->allow($this->action);
		}
		
		
		//nastavitev login parametrov za komponento
		$this->Auth->fields = array(
			'username' => 'email',
			'password' => 'password'	
			);
		//$this->Auth->autoRedirect = false;
		//$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		
		//$this->Auth->allow('display');
		//$this->Auth->authorize = 'action';
		
		
		//$this->set('user',$this->Auth->user());
		/*
		 * Nastavljanje parametrov za view elemente (kategorije, produkti)
		 */
		if(isset($this->passedArgs['c'])){
			$this->c = (int)$this->passedArgs['c'];
		}else{
			$this->c = 0;
		}
		
		
		if(isset($this->passedArgs['p'])){
			$this->p = (int)$this->passedArgs['p'];
		}else{
			$this->p = 0;
		}
		
		if($this->params['controller'] == 'carts' && $this->params['action'] == 'view'){
			$this->layout = 'defaultCollapse';
		}
		if($this->params['controller'] == 'orders' && $this->params['action'] == 'index'){
			$this->layout = 'defaultCollapse';
		}
		if(isset($this->params['admin']) && $this->params['admin']){
			$this->layout = 'defaultCake';
		}
		
		$sessionUser = $this->Session->read('Config.userAgent');
		$this->sid = $sessionUser;
		$this->set('c',$this->c);
		$this->set('p', $this->p);
		$this->set('sid', $this->sid);
	}
	
	
}
?>