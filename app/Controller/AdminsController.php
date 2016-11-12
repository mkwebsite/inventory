<?php
/**
 * Admins Controller
 *
 * PHP version 5.4
 *
 */
class AdminsController extends AppController {
	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var	$name		= 'Admins';
	public $uses 	= array('User');
	var $components	= array('Upload') ;
	
	
	/*
	* beforeFilter
	* @return void
	*/
    public function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allow(array('a','admin_forgot_password', 'admin_reset'));
    }
	
	
	
	
	public function admin_forgot_password() {
		
		$this->layout = 'admin_login';
		$this->set('title_for_layout', __('Forgot Password', true));
		if($this->Session->read('Auth.User')){
			$this->redirect(array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard'));
		 	exit();
		}
		
		if ($this->request->is('post')) {
			if(!empty($this->request->data)) {					
				$this->User->set($this->request->data);
				$this->User->setValidation('forgot_password');
				if($this->User->validates()){
					$username 		 = $this->request->data['User']['username'];
					$user_pass_reset = $this->User->find('first',array('conditions'=>array('User.status'=>Configure::read('App.Status.active'), 'User.username'=>$username)));
					$this->loadModel('Template');
					if(!empty($user_pass_reset)){
						$forgotMail = $this->Template->find('first', array('conditions' => array('Template.slug' => 'forgot_password')));
						$email_subject = $forgotMail['Template']['subject'];
						$subject = __('[' . Configure::read('APP.SITE_NAME') . '] ' . 
						$email_subject . '', true);
						$email = Security::hash($user_pass_reset['User']['username'], null, true) ;
						
						$reset_link = Router::url(array('admin'=>true, 'controller'=>'admins', 'action'=>'reset', $email));
						$this->User->updateAll(array('User.varify_hash'=>'"'.$email.'"'),array('User.id'=>$user_pass_reset["User"]["id"])) ; 
						
						$activation_link = '<a href="'. $reset_link .'">Reset Now</a>';	
						$mailMessage = str_replace(array('{NAME}','{ACTIVATION_LINK}','{SITE}'), array($user_pass_reset['User']['first_name'].' '.$user_pass_reset['User']['last_name'],"$activation_link",Configure::read('APP.SITE_NAME')), $forgotMail['Template']['content']);
						//echo $mailMessage; die;
						
						if($this->sendMail($user_pass_reset["User"]["username"],$subject,$mailMessage,array(Configure::read('APP.SITE_EMAIL')=>Configure::read('APP.SITE_NAME')),$forgotMail['Template']['id'])){
							$this->Session->setFlash(__('Your new password link has been sent to your email address.', true),'admin_flash_success');
						 
						}else{
							$this->Session->setFlash(__('Your Password has been changed. Your New Password detail has not been sent to your email address.',true),'admin_flash_error');
						} 
					}else{
						$this->Session->setFlash(__('Your email does not exists.',true),'admin_flash_error');
					} 	
				}
			}
		} 
	}
	
	
	/* user password chang*/
    function admin_reset($email=null){
        $user_pass_reset = $this->User->find('first',array('conditions'=>array('User.varify_hash'=>$email)));  
        
		if($user_pass_reset and $email){
			$this->Session->write('Auth', $user_pass_reset); 
			$this->User->id = $this->Auth->user('id'); 
			$this->User->saveField('varify_hash', NULL);
			$this->Auth->_loggedIn = true; 
			
			$this->Session->delete('UserInfo');
			
			$this->Session->setFlash(__('Please set your new password.', true), 'admin_flash_success');
			$this->redirect(array('admin'=>true, 'controller'=>'admins', 'action'=>'change_password'));
		}else{
			
			//*********** LOGOUT ****************//
			$this->Cookie->delete('User');
			$this->Cookie->delete('username');
			$this->Cookie->delete('user_id');
			$this->Cookie->delete('remember_me');
			$this->Auth->logout();		
			
			$this->Session->setFlash(__('Your link has been expired. Please try again.',true), 'admin_flash_error'); 			
			$this->redirect(array('admin'=>true, 'controller'=>'admins', 'action'=>'forgot_password'));
		}	
		
    }
	
	
	
	/*
	* Admin Login
	* auth magic
	*/
	public function admin_login() {
		
		//echo Security::hash(123456, null, true); die;
		
		if($this->Auth->login()){
			$remember_me = isset($this->request->data['User']['remember_me'])?$this->request->data['User']['remember_me']:'';
			$number_of_days = 30;
			$date_of_expiry = time() + 60 * 60 * 24 * $number_of_days; 
		
			if($remember_me) {
				$this->Cookie->write('username', $this->Session->read('Auth.User.username'), $date_of_expiry);
				$this->Cookie->write('user_id', $this->Session->read('Auth.User.id'), $date_of_expiry);
				$this->Cookie->write('remember_me', $remember_me, $date_of_expiry);
			} else {
				$this->Cookie->delete('username');
				$this->Cookie->delete('user_id');
				$this->Cookie->delete('remember_me');
			}
			
			
			$this->redirect($this->Auth->redirect());
		}else {
			if($this->request->is('post')){
				$this->Session->setFlash(__('Invalid username or password, try again'));
			}
		}
		$this->layout = 'admin_login';
	}
	
	
	
	/*
	* Admin Logout
	* auth magic
	*/	
	public function admin_logout() {
		
		$this->Cookie->delete('User');
		$this->Cookie->delete('username');
		$this->Cookie->delete('user_id');
		$this->Cookie->delete('remember_me');
		
		$this->redirect($this->Auth->logout());		
	}
	
	
	/*
	* Dashboard
	*/
	public function admin_dashboard(){
		$this->set('title_for_layout',  __('Dashboard', true)); 
		$this->loadModel('Country');
		$this->loadModel('SaleTax');
		$this->loadModel('Product');
	
		$customers 			= $this->User->find('count',array('conditions'=>array('User.role_id'=>2)));
		$vendors 			= $this->User->find('count',array('conditions'=>array('User.role_id'=>3)));	
		$active_products 	= $this->Product->find('count',array('conditions'=>array('Product.status'=>1)));
		$inactive_products 	= $this->Product->find('count',array('conditions'=>array('Product.status'=>2)));
		$categories 		= 2; //$this->Category->find('count');
		$countries 			= $this->Country->find('count');
		$sale_taxes 		= $this->SaleTax->find('count');
		
		$this->set(compact('customers', 'vendors', 'active_products', 'inactive_products', 'categories', 'countries', 'sale_taxes'));
	} 
	
	
	/**
	* Change Password
	*/
    public function admin_change_password() {
		$id = $this->Session->read('Auth.User.id');
		$this->set('title_for_layout',  __('Change your password', true));
		
        $this->User->id = $id;
        if (!$this->User->exists()){
            throw new NotFoundException(__('Invalid user'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')){
			if(!empty($this->request->data)) {
				if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
					$blackHoleCallback = $this->Security->blackHoleCallback;
					$this->$blackHoleCallback();
				}
				
				//validate user data
				$this->User->set($this->request->data);
				$this->User->setValidation('change_password');
				if ($this->User->validates()) { 
					$this->request->data['User']['password'] = Security::hash($this->request->data['User']['new_password'], null, true);
					if ($this->User->saveAll($this->request->data)) {
						$this->Session->setFlash(__('Password has been changed successfully.',true), 'admin_flash_success');
						$this->redirect(array('action'=>'change_password', $id)) ;
					} else {
						$this->Session->setFlash(__('Password could not be changed. Please try again.',true), 'admin_flash_error');
					}
				}else {
					$this->Session->setFlash(__('Password could not be changed. Please correct errors.', true), 'admin_flash_error');
				}
			}	
        }else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        } 
    }
	
	
	
	/**
	* Change Email Address
	*/
    public function admin_edit(){
		$id = $this->Session->read('Auth.User.id');
		$this->set('title_for_layout',  __('Change your profile information', true)) ;
		
        $this->User->id = $id;
        if (!$this->User->exists()) { 
            throw new NotFoundException(__('Invalid User'));
        }
		
        if ($this->request->is('post') || $this->request->is('put')) {			
			if(!empty($this->request->data)) {
				if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
					$blackHoleCallback = $this->Security->blackHoleCallback;
					$this->$blackHoleCallback();
				}
				
				//validate user data
				$this->User->set($this->request->data);
				$this->User->setValidation('admin_edit');
				if ($this->User->validates()) { 
					$current_password 	= Security::hash($this->request->data['User']['current_password'], null, true);
					$result_data		= $this->User->find('all', array('conditions'=>array('User.id'=>$id, 'User.password'=>$current_password)));
					
					if($result_data){
						$userdata = array();
						$this->request->data['User']['id'] 			= $id;
						$this->request->data['User']['username'] 	= $userdata['username'] 	= $this->request->data['User']['new_email'];
						$this->request->data['User']['first_name'] 	= $userdata['first_name'] 	= $this->request->data['User']['new_first_name'];
						$this->request->data['User']['last_name'] 	= $userdata['last_name'] 	= $this->request->data['User']['new_last_name'];
						
						$this->Session->write('Auth.User.username', $userdata['username']);
						$this->Session->write('Auth.User.first_name', $userdata['first_name']);
						$this->Session->write('Auth.User.last_name', $userdata['last_name']);
						if ($this->User->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Profile information has been changed successfully.', true), 'admin_flash_success');
							$this->redirect(array('action'=>'edit')) ;
						} else {
							$this->Session->setFlash(__('Profile information could not be changed. Please try again.', true), 'admin_flash_error');
						}
					}else{
						$this->Session->setFlash(__('Please enter correct password.', true), 'admin_flash_error');
					}
				}else {
					$this->Session->setFlash(__('Profile information could not be changed. Please correct errors.', true), 'admin_flash_error');
				}
			}	
        }else {
            $this->request->data = $this->User->read(null, $id);
			
			$this->request->data['User']['new_email'] 		= $this->request->data['User']['username'];
			$this->request->data['User']['new_first_name'] 	= $this->request->data['User']['first_name'];
			$this->request->data['User']['new_last_name'] 	= $this->request->data['User']['last_name'];
            unset($this->request->data['User']['password']);
        } 
    }
	
	
	
	
	
	
	

	function referer($default = NULL, $local = false){
		$defaultTab = $this->Session->read('Url.defaultTab');
		$page = $this->Session->read('Url.page');
		$sort = $this->Session->read('Url.sort');
		$direction = $this->Session->read('Url.direction');
		
		return Router::url(array('action'=>'index', $defaultTab,'page'=>$page,'sort'=>$sort,'direction'=>$direction),true);
	}
	
	
	
}