<?php
/**
 * Application controller
 *
 * This file is the base controller of all other controllers
 *
 * PHP version 5
 *
 * @category Controllers
 * @version  1.0 
 */
class AppController extends Controller {

	/**
	 * Components
	 *
	 * @var array
	 * @access public
	 */    
    var $components = array(    
		//'Security',          
		'Auth',
		'RequestHandler',       
		'Email', 	
		'Session',
		'Cookie'
    );
   
	/**
	 * Models
	 *
	 * @var array
	 * @access public
	 */
	 var $uses	=	array('User', 'Setting');
	 /**
	 * Helpers
	 *
	 * @var array
	 * @access public
	 */
    var $helpers = array(
		'Html',
		'Form',
		'Session',
		'Text',
		'Js',			
		'Time',			
		'ExPaginator',
		'General'
    );	
	
	
	
	/**
	 * beforeFilter
	 *
	 * @return void
	 */
    public function beforeFilter() {  
		
		//$this->Security->blackHoleCallback = '__securityError'; 	
		$this->disableCache(); 
		
		$set_data = $this->Setting->find('all');
		
		foreach($set_data as $val){
			$this->Session->write('SiteValue.'. $val['Setting']['slug'], $val['Setting']['value']);
		}
		
		/*---- Enable SSL Settings ----*/
		$action 	 = $this->params['action'];
		$ssl_setting = strtolower($this->Session->read('SiteValue.ssl_setting')); 
		$ssl_setting = ($ssl_setting=='no')?'no':'yes';
		$protocol 	 = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
		
		if($ssl_setting=='yes'){
			if($protocol=="http"){
				$this->redirect('https://' . env('SERVER_NAME') . $this->here);
			}
		}else{
			if($protocol=="https"){
				$this->redirect('http://' . env('SERVER_NAME') . $this->here);
			}
		}
		
		/*----------- Direct login... If Cookie Found -----------*/ 		
		if($this->Cookie->read('user_id')) {
			$users=$this->User->find('first',array('conditions'=>array('User.id'=>$this->Cookie->read('user_id'))));
			$this->Session->write('Auth',  $users); 
		}
		
		 
        if(isset($this->request->params['admin'])) {
			
			if($this->Auth->user('role_id')!='' and $this->Auth->user('role_id')!=1){ 
				$this->Session->setFlash(__('Please login to access admin area.', true), 'front_flash_error');
				$this->redirect('/'); 
			}
			
			$this->layout = 'default';             	     
			$this->Auth->userModel = 'User';
			$this->Auth->authenticate = array('Form'=>array(
						'fields' => array('username'=>'username', 'password'=>'password'),
						'scope' => array('User.status'=>1, 'User.role_id'=>1)
			));	
			
			$this->Auth->loginError 	=	"Login failed. Invalid username or password";
			$this->Auth->loginAction 	=   array('admin' => true, 'controller' => 'admins', 'action' => 'login');	
			$this->Auth->loginRedirect 	=	array('admin' => true, 'controller' => 'admins', 'action' => 'dashboard');
			
			$this->Auth->authError 		= 	'You must login to view this information.';
			$this->Auth->autoRedirect 	= 	true;
			$this->Auth->allow('admin_login'); 
		}else{
			
			if($this->Auth->user('role_id')==1){ 
				$this->redirect(array('admin'=>true, 'controller'=>'admins', 'action'=>'dashboard')); 
			}
			
			$this->layout = 'default'; 
			$this->Auth->userModel 		=	array('User');	
 		
			$this->Auth->authenticate = array('Form'=>array( 'fields' =>array('email'=>'username', 'password'=>'password'),
				'scope' =>array('User.status'=>1, 'User.role_id'=>1)
			));  
			
			
			$this->Auth->loginError 	=	"Login failed. Invalid username or password";
			$this->Auth->loginAction 	=   array('admin' => true, 'controller' => 'admins', 'action' => 'login');	
			$this->Auth->loginRedirect 	=	array('admin' => true, 'controller' => 'admins', 'action' => 'dashboard');
			
			$this->Auth->authError 		= 	'You must login to view this information.';
			$this->Auth->autoRedirect 	= 	true;
			$this->Auth->allow('login'); 
		}        
 
		
		$this->Auth->authorize = array('Controller') ; 
		if($this->RequestHandler->isAjax()){
			$this->layout	=	'ajax';
			$this->autoRender	= false;
			//$this->Security->validatePost = false;
			Configure::write('debug', 2);
		}		
		$this->set('subtitle',''); 		
    }  

	
	/**
	 * isAuthorized
	 *
	 * @return void
	 */	  
    public function isAuthorized() { 		
      	return true;
    }
	
	
	
	/**
	 * blackHoleCallback for SecurityComponent
	 *
	 * @return void
	 */
    public function __securityError() {
      	 
    }
	
	
	
	
	public function beforeRender() { 
       $this->_configureErrorLayout();
    }
	
	
	
	
	
	/**
	 * sendMail
	 *
	 * @return	void
	 * @access	private
	 */ 
	 
    public function sendMail($to, $subject, $message, $from=null, $template=null, $cc="", $attachments=""){
		App::uses('CakeEmail', 'Network/Email');
		$email = new CakeEmail();
		$email->config('default');  
		$email->to($to);
		if($cc !="" and is_array($cc)){ $email->cc($cc); }
		$email->subject($subject); 
		if($attachments != ''){ $email->attachments($attachments); }
		$email->template('default', 'default') ;
		$email->emailFormat('html'); 
		if($email->send($message)){
			return true;
		}else{
			return false;
		} 
	}
	
	
	
	/* display sql dump when debug is greater than 0 */
	
	public function displaySqlDump(){
		if (!class_exists('ConnectionManager') || Configure::read('debug') < 2) {
			return false;
		}
		$noLogs = !isset($logs);
		if ($noLogs):
			$sources = ConnectionManager::sourceList();

			$logs = array();
			foreach ($sources as $source):
				$db =& ConnectionManager::getDataSource($source);
				if (!$db->isInterfaceSupported('getLog')):
					continue;
				endif;
				$logs[$source] = $db->getLog();
			endforeach;
		endif;

		if ($noLogs || isset($_forced_from_dbo_)):
			foreach ($logs as $source => $logInfo):
				$text = $logInfo['count'] > 1 ? 'queries' : 'query';
				printf(
					'<table class="cake-sql-log" id="cakeSqlLog_%s" summary="Cake SQL Log" cellspacing="0" border = "0">',
					preg_replace('/[^A-Za-z0-9_]/', '_', uniqid(time(), true))
				);
				printf('<caption>(%s) %s %s took %s ms</caption>', $source, $logInfo['count'], $text, $logInfo['time']); ?>
				
				<thead>
					<tr><th>Nr</th><th>Query</th><th>Error</th><th>Affected</th><th>Num. rows</th><th>Took (ms)</th></tr>
				</thead>
				<tbody><?php
					foreach ($logInfo['log'] as $k => $i) :
						echo "<tr><td>" . ($k + 1) . "</td><td>" . h($i['query']) . "</td><td>{$i['error']}</td><td style = \"text-align: right\">{$i['affected']}</td><td style = \"text-align: right\">{$i['numRows']}</td><td style = \"text-align: right\">{$i['took']}</td></tr>\n";
					endforeach; ?>
				</tbody></table><?php 
			endforeach;
		else:
			echo '<p>Encountered unexpected $logs cannot generate SQL log</p>';
		endif;	
	}

	
 
	public function _configureErrorLayout() {
		if ($this->name == 'CakeError') {
			if ($this->_isAdminMode()) {
				$this->layout = 'error';
			} else {
				$this->layout = 'error';
			}
		}
	}
 
	public function _isAdminMode() {
		$adminRoute = Configure::read('Routing.prefixes');
		if (isset($this->params['prefix']) && in_array($this->params['prefix'], $adminRoute)) {
			return true;
		}
		return false;
	}
	
}