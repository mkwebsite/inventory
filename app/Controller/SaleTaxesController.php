<?php
	/**
		* Sale Taxes Controller
		*
		* PHP version 5.4
		*
	*/
	class SaleTaxesController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		var	$name	= 'SaleTaxes'; 
		var	$uses	=	array('SaleTax');
		
		/*
			* beforeFilter
			* @return void
		*/
		public function beforeFilter() {
			parent::beforeFilter();
		}
		
		
		/*
		** List all sale taxes in admin panel
		*/
		public function admin_index($defaultTab=null) {
			$this->set('title_for_layout',  __('Taxes Listing', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters[] 		  = array('SaleTax.status'=>$defaultTab);
				$title_for_layout = "Taxes Listing (". Configure::read('Status.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['SaleTax']['keyword'])){				
					$name = Sanitize::escape($this->request->data['SaleTax']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('SaleTax.zip_code LIKE'=>$keyword."%", 'SaleTax.state LIKE'=>$keyword."%", 'SaleTax.state_code LIKE'=>$keyword."%", 'SaleTax.tax_region_code LIKE'=>$keyword."%"));
			}
			
			$this->paginate = array(
				'SaleTax'	=> array(	
				'limit'				=> Configure::read('App.AdminPageLimit'), 
				'order'				=> array('SaleTax.id'=>'ASC'),
				'conditions'		=> $filters
			));
			
			$data = $this->paginate('SaleTax');   
     		$active     = $this->SaleTax->find('count',array('conditions'=>array('SaleTax.status'=>1)));
			$inactive 	 = $this->SaleTax->find('count',array('conditions'=>array('SaleTax.status'=>2)));
			$all		 = (int)$active + (int)$inactive;
			
			$this->set(compact('data','active','inactive','all'));		
			
		}
		
		
		
		public function admin_add() {	
			$this->set('title_for_layout',  __('Add New Sales Tax', true)) ;
			
			if ($this->request->is('post')) {
				//check empty
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					//validate SaleTax data
					$this->SaleTax->set($this->request->data);
					$this->SaleTax->setValidation('admin');
					if ($this->SaleTax->validates()) {
						
						if ($this->SaleTax->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Sales tax has been saved successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index'));
						} else {
							$this->Session->setFlash(__('Sales tax could not be saved. Please try again.'), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash('Sales tax could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
			}
		}
		
		
		
		public function admin_edit($id = null) {
			$this->set('title_for_layout',  __('Update Sales Tax Information', true)) ;
			$this->SaleTax->id = $id;
			
			if (!$this->SaleTax->exists()) {
				throw new NotFoundException(__('Invalid Admin'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {					
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate SaleTax data
					$this->SaleTax->set($this->request->data);
					$this->SaleTax->setValidation('admin');
					if ($this->SaleTax->validates()){
						if ($this->SaleTax->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Sales tax information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
							} else {
							$this->Session->setFlash(__('Sales tax could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash(__('Sales tax could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
			}else {			
				$this->request->data = $this->SaleTax->read(null, $id);				
			}
			
		}


		
	    public function admin_delete($id = null){
			$this->SaleTax->id = $id;
			if (!$this->SaleTax->exists()) {
				throw new NotFoundException(__('Invalid Sales Tax'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->SaleTax->delete()) {
				$this->Session->setFlash(__('Sales tax has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'sale_taxes', 'action' =>'index'));			
			}else{
				$this->Session->setFlash(__('Sales tax could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'sale_taxes', 'action' =>'index'));
			}
		}
		
		
		
		public function admin_status($id = null) {
			
			$this->SaleTax->id = $id;
			if (!$this->SaleTax->exists()) {
				throw new NotFoundException(__('Invalid Sales Tax'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->SaleTax->toggleStatus($id)) {
				$this->Session->setFlash(__('Sales tax  status has been changed.'), 'admin_flash_success');
				$this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Sales tax status could not be changed.', 'admin_flash_error'));
			$this->redirect($this->referer());
		}
		
		
		
		public function admin_view($id = null) {
			$this->set('title_for_layout',  __('Sales Tax Information', true)) ;
			$result = array();
			
			$this->SaleTax->id = $id;
			if (!$this->SaleTax->exists()) {
				throw new NotFoundException(__('Invalid Sales Tax'));
			}
			
			$this->set('data', $this->SaleTax->read(null, $id));
		}
		
		
		
		function referer($default = NULL, $local = false){
			$defaultTab = $this->Session->read('Url.defaultTab');
			$Page = $this->Session->read('Url.Page');
			$sort = $this->Session->read('Url.sort');
			$direction = $this->Session->read('Url.direction');
			
			return Router::url(array('action'=>'index', $defaultTab,'Page'=>$Page,'sort'=>$sort,'direction'=>$direction),true);
		}
	}