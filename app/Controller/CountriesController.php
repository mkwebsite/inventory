<?php
	/**
		* Countries Controller
		*
		* PHP version 5.4
		*
	*/
	class CountriesController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		var	$name	= 'Countries'; 
		var	$uses	=	array('Country');
		
		/*
			* beforeFilter
			* @return void
		*/
		public function beforeFilter() {
			parent::beforeFilter();
		}
		
		
		/*
		** List all Countries in admin panel
		*/
		public function admin_index($defaultTab=null) {
			$this->set('title_for_layout',  __('Countries Listing', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters[] 		  = array('Country.status'=>$defaultTab);
				$title_for_layout = "Countries Listing (". Configure::read('Status.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Country']['keyword'])){				
					$name = Sanitize::escape($this->request->data['Country']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('Country.name LIKE'=>$keyword."%", 'Country.code LIKE'=>$keyword."%"));
			}
			
			$this->paginate = array(
				'Country'	=> array(	
				'limit'				=> Configure::read('App.AdminPageLimit'), 
				'order'				=> array('Country.name'=>'ASC'),
				'conditions'		=> $filters
			));
			
			$data = $this->paginate('Country');   
     		$active     = $this->Country->find('count', array('conditions'=>array('Country.status'=>1)));
			$inactive 	 = $this->Country->find('count', array('conditions'=>array('Country.status'=>2)));
			$all		 = (int)$active + (int)$inactive;
			
			$this->set(compact('data','active','inactive','all'));		
			
		}
		
		
		
		public function admin_add() {	
			$this->set('title_for_layout',  __('Add New Country', true)) ;
			
			if ($this->request->is('post')) {
				//check empty
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					//validate Country data
					$this->Country->set($this->request->data);
					$this->Country->setValidation('admin');
					if ($this->Country->validates()) {
						
						if ($this->Country->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Country has been saved successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index'));
						} else {
							$this->Session->setFlash(__('Country could not be saved. Please try again.'), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash('Country could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
			}
		}
		
		
		
		public function admin_edit($id = null) {
			$this->set('title_for_layout',  __('Update Country Information', true)) ;
			$this->Country->id = $id;
			
			if (!$this->Country->exists()) {
				throw new NotFoundException(__('Invalid Admin'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {					
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Country data
					$this->Country->set($this->request->data);
					$this->Country->setValidation('admin');
					if ($this->Country->validates()){
						if ($this->Country->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Country information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
							} else {
							$this->Session->setFlash(__('Country could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash(__('Country could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
			}else {			
				$this->request->data = $this->Country->read(null, $id);				
			}
			
		}


		
	    public function admin_delete($id = null){
			$this->Country->id = $id;
			if (!$this->Country->exists()) {
				throw new NotFoundException(__('Invalid Country'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Country->delete()) {
				$this->Session->setFlash(__('Country has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'countries', 'action' =>'index'));			
			}else{
				$this->Session->setFlash(__('Country could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'countries', 'action' =>'index'));
			}
		}
		
		
		
		public function admin_status($id = null) {
			
			$this->Country->id = $id;
			if (!$this->Country->exists()) {
				throw new NotFoundException(__('Invalid Country'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Country->toggleStatus($id)) {
				$this->Session->setFlash(__('Country  status has been changed.'), 'admin_flash_success');
				$this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Country status could not be changed.', 'admin_flash_error'));
			$this->redirect($this->referer());
		}
		
		
		
		
		
		function referer($default = NULL, $local = false){
			$defaultTab = $this->Session->read('Url.defaultTab');
			$Page = $this->Session->read('Url.Page');
			$sort = $this->Session->read('Url.sort');
			$direction = $this->Session->read('Url.direction');
			
			return Router::url(array('action'=>'index', $defaultTab,'Page'=>$Page,'sort'=>$sort,'direction'=>$direction),true);
		}
	}