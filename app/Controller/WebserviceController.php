<?php
	/**
	*
	* Webservice Controller
	* PHP version 5.4
	*
	*/
	
	class WebserviceController extends AppController {
		/**
		* Controller name
		* @var string
		* @access public
		*/
		
		public	$name	= 'Webservice';
		public $uses 	= array('User');
		var $helpers 	= array('Session');
		
		
			
		public function beforeFilter() {  	
		$this->layout = false;

	        $this->autoRender = false;
	        $this->Auth->allow();
	        header('Access-Control-Allow-Origin: *');
		//$this->Security->config('unlockedActions', 'user_login');
		}
	
		
		public function user_login(){
			
			$this->request->data['password'] = Security::hash($this->request->data['password'], null, true);
			$users = $this->User->find('first',array('conditions'=>array('User.username'=>$this->request->data['username'], 'User.password'=>$this->request->data['password'], 'User.status'=>1)));
			if(!empty($users)){
				$response['status'] = 1;
				$response['message'] = "Success!";
				$response['data'] = $users;
			}else{
				$response['status'] = 0;
				$response['message'] = "Either username or password wrong!";
			}
			echo json_encode($response);
			die;
		}
		
		public function user_add_product(){
			
			$this->loadModel('Product');
			if($this->Product->save($this->request->data)){
				$response['status'] = 1;
				$response['message'] = "Success!";
			}else{
				$response['status'] = 0;
				$response['message'] = "Can not add product!";
			}
			echo json_encode($response);
			die;
		}
		
		public function user_search_product(){
			$this->loadModel('Product');
			$products = $this->Product->find('first',array('conditions'=>array('Product.sku'=>$this->request->data['keyword'])));
			if(!empty($products)){
				$response['status'] = 1;
				$response['message'] = "Success!";
				$response['data'] = $products;
			}else{
				$response['status'] = 0;
				$response['message'] = "Product can not found!";
			}
			echo json_encode($response);
			die;
		}
		
	}		