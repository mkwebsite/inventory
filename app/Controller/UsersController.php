<?php
	/**
	*
	* Users Controller
	* PHP version 5.4
	*
	*/
	
	class UsersController extends AppController {
		/**
		* Controller name
		* @var string
		* @access public
		*/
		
		public	$name	= 'Users';
		public $uses 	= array('User', 'Template', 'UserShippingAddress', 'UserBillingAddress');
		var $components = array('Upload') ;	 
		var $helpers 	= array('Session');
		
		/*
			* beforeFilter
			* @return void
		*/
		function beforeRender(){
			$model = Inflector::singularize($this->name);
			foreach($this->{$model}->hasAndBelongsToMany as $k=>$v) {
				if(isset($this->{$model}->validationErrors[$k])){
					$this->{$model}->{$k}->validationErrors[$k] = $this->{$model}->validationErrors[$k];
				}
			} 
		}
			
		public function beforeFilter() {  		
			parent::beforeFilter();
			$this->loadModel('User');
		}
	
		/*
		*
		** Users Listing
		*
		*/		
		public function admin_index($role_id=2, $defaultTab=null){			
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$lable				= ($role_id==2)?"Customer":"Vendor";
			$title_for_layout 	= ($role_id==2)?"Customers Listing":"Vendors Listing";
			
			$filters = array('User.role_id'=>$role_id); 
			if($defaultTab){
				$filters[] = array('User.status'=>$defaultTab);
				$title_for_layout .= " (". Configure::read('Status.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			$this->set(compact('title_for_layout',  'lable')) ;
			
			if(!empty($this->request->data)){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['User']['first_name'])){				
					$name = Sanitize::escape($this->request->data['User']['first_name']);
					$this->Session->write('AdminSearch.first_name', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keywords  = $this->Session->read('AdminSearch');
				
				foreach($keywords as $key=>$values){
					if($key == 'first_name' ){					
						$filters[] = array('OR'=>array('User.first_name LIKE'=>$values."%", 'User.last_name LIKE'=>$values."%", 'User.city LIKE'=>$values."%", 'User.state LIKE'=>$values."%", 'User.username LIKE'=>$values."%"));
					} 
				}
			}					
			
			$this->paginate = array('User'=>array(	
				'limit' 	=> 2, //Configure::read('App.AdminPageLimit'),
				'conditions'=> $filters, 
				'order'		=> array('User.modified'=>'DESC')
			));
			$data = $this->paginate('User');
			
			$active 	= $this->User->find('count',array('conditions'=>array('User.status'=>1, 'User.role_id'=>$role_id)));
			$inactive 	= $this->User->find('count',array('conditions'=>array('User.status'=>2, 'User.role_id'=>$role_id)));
			$all_user	= (int)$active + (int)$inactive;
			
			$this->set(compact('data', 'active', 'inactive', 'all_user'));
		}
		
		
		
		
		
		
		
		/* 
			* View existing user
		*/
		public function admin_view($role_id=2, $id=null) {
			$lable				= ($role_id==2)?"Customer":"Vendor";
			$title_for_layout	= ($role_id==2)?"Customer Information":"Vendor Information";
			$this->set(compact('title_for_layout', 'lable'));
			
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			
			$this->User->bindModel(array('hasOne'=>array('UserBillingAddress', 'UserShippingAddress')), false);
			$this->set('user', $this->User->read(null, $id));
		}
		
		
		
		/*
			* Add new
		*/	
		public function admin_add($role_id=2){	
		
			$lable				= ($role_id==2)?"Customer":"Vendor";
			$title_for_layout	= ($role_id==2)?"Add new Customer":"Add new Vendor";
			$this->set(compact('title_for_layout',  'lable')) ;
			
			if ($this->request->is('post')) {
				//check empty
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate user data
					$this->User->set($this->request->data);
					$this->User->setValidation('admin_user');
					if($this->User->validates()){
						$this->request->data['User']['password'] = NULL;
						$this->request->data['User']['role_id']  = $role_id;
						if($role_id==2){
							$shipping_data['UserShippingAddress'] 	 = $this->request->data['UserShippingAddress'];
							$billing_data['UserBillingAddress'] 	 = $this->request->data['UserBillingAddress'];
							unset($this->request->data['UserShippingAddress']);
							unset($this->request->data['UserBillingAddress']);
						}
						
						if($this->User->saveAll($this->request->data)){
							if($role_id==2){
								$user_id = $this->User->id;
								$shipping_data['UserShippingAddress']['user_id'] = $user_id;
								$billing_data['UserBillingAddress']['user_id'] 	 = $user_id;
								$this->UserShippingAddress->saveAll($shipping_data);
								$this->UserBillingAddress->saveAll($billing_data);
							}
							
							$this->Session->setFlash(__($lable .' has been added successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index', $role_id));
						} else {
							$this->Session->setFlash(__($lable .' could not be added. Please try again.'), 'admin_flash_error');
						}
					}else{
						$this->Session->setFlash($lable .' could not be added. Please correct errors.', 'admin_flash_error');
					}	
				}
			}
			
			$this->loadModel('Country');
			$countries 	= $this->Country->find('list', array('fields'=>array('Country.name', 'Country.name'), 'conditions'=>array('Country.status'=>1), 'order'=>array('Country.name'=>'ASC')));
			$this->set(compact('countries')) ;
		}
		
		
		
		/**
			* edit existing user
		*/
		public function admin_edit($role_id=2, $id=null){
			
			$lable				= ($role_id==2)?"Customer":"Vendor";
			$title_for_layout	= ($role_id==2)?"Update Customer Information":"Update Vendor Information";
			$this->set(compact('title_for_layout',  'lable')) ;
			
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid '. $lable));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {				
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate user data
					$this->User->set($this->request->data);
					$this->User->setValidation('admin_user');
					if ($this->User->validates()){
						if($role_id==2){
							$shipping_data['UserShippingAddress'] 	 = $this->request->data['UserShippingAddress'];
							$billing_data['UserBillingAddress'] 	 = $this->request->data['UserBillingAddress'];
							unset($this->request->data['UserShippingAddress']);
							unset($this->request->data['UserBillingAddress']);
						}
						
						if ($this->User->saveAll($this->request->data)) {
							if($role_id==2){
								$this->UserShippingAddress->saveAll($shipping_data);
								$this->UserBillingAddress->saveAll($billing_data);
							}
							
							$this->Session->setFlash(__($lable .' information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index', $role_id)) ;
							} else {
							$this->Session->setFlash(__($lable .' information could not be updated. Please try again.',true), 'admin_flash_error');
						}
						}else {
						$this->Session->setFlash(__($lable .' information could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
			}else {

				$this->User->bindModel(array('hasOne'=>array('UserBillingAddress', 'UserShippingAddress')), false);				
				$this->request->data = $this->User->read(null, $id);				
				unset($this->request->data['User']['password']);
			}			
			
			$this->loadModel('Country');
			$countries 	= $this->Country->find('list', array('fields'=>array('Country.name', 'Country.name'), 'conditions'=>array('Country.status'=>1), 'order'=>array('Country.name'=>'ASC')));
			$this->set(compact('countries'));
		}
		
		
		
		
		
		
		/**
			* delete existing User
		*/
		public function admin_delete($role_id=2, $id=null) {
			$lable				= ($role_id==2)?"Customer":"Vendor";
			
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->User->delete()) {
				$this->Session->setFlash(__($lable .' has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'users', 'action' =>'index', $role_id));			
			}else{
				$this->Session->setFlash(__($lable .' could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'users', 'action' =>'index', $role_id));
			}
		}
		
		
		
		/**
			* toggle status existing User
		*/
		public function admin_status($role_id=2, $id=null) {
			$lable				= ($role_id==2)?"Customer":"Vendor";
			
			$this->User->id = $id;
			if (!$this->User->exists()) {
				throw new NotFoundException(__('Invalid user'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->User->toggleStatus($id)) {			
				$this->Session->setFlash(__($lable .' status has been changed.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'users', 'action' =>'index', $role_id));
			}
			$this->Session->setFlash(__($lable .' status could not be changed.', 'admin_flash_error'));
			$this->redirect(array('controller' => 'users', 'action' =>'index', $role_id));
		}
		
		
		
		
		
		
		function referer($default = NULL, $local = false) {
			$defaultTab = $this->Session->read('Url.defaultTab');
			$page = $this->Session->read('Url.page');
			$sort = $this->Session->read('Url.sort');
			$direction = $this->Session->read('Url.direction');
			$type = $this->Session->read('Url.type');
			
			return Router::url(array('action'=>'index',$type, $defaultTab,'page'=>$page,'sort'=>$sort,'direction'=>$direction),true);
		}
		
		
		
	}			