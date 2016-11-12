<?php
	/**
	* Categories Controller
	*
	* PHP version 5.4
	*
	*/
	class CategoriesController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		var	$name	= 'Categories'; 
		var	$uses	=	array('Category');
		
		/*
			* beforeFilter
			* @return void
		*/
		public function beforeFilter() {
			parent::beforeFilter();
		}
		
		
		/*
		** List all Categories in admin panel
		*/
		public function admin_index($defaultTab=null) {
			$this->set('title_for_layout',  __('Categories Listing', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters[] 		  = array('Category.status'=>$defaultTab);
				$title_for_layout = "Categories Listing (". Configure::read('Status.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Category']['keyword'])){				
					$name = Sanitize::escape($this->request->data['Category']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('Category.name LIKE'=>$keyword."%"));
			}
			
			$this->paginate = array(
				'Category'	=> array(	
				'limit'				=> Configure::read('App.AdminPageLimit'), 
				'order'				=> array('Category.name'=>'ASC'),
				'conditions'		=> $filters
			));
			
			$data = $this->paginate('Category');   
     		$active     = $this->Category->find('count', array('conditions'=>array('Category.status'=>1)));
			$inactive 	 = $this->Category->find('count', array('conditions'=>array('Category.status'=>2)));
			$all		 = (int)$active + (int)$inactive;
			
			$this->set(compact('data','active','inactive','all'));		
			
		}
		
		
		
		public function admin_add() {	
			$this->set('title_for_layout',  __('Add New Category', true)) ;
			
			if ($this->request->is('post')) {
				//check empty
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					//validate Category data
					$this->Category->set($this->request->data);
					$this->Category->setValidation('admin');
					if ($this->Category->validates()) {
						
						if ($this->Category->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Category has been saved successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index'));
						} else {
							$this->Session->setFlash(__('Category could not be saved. Please try again.'), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash('Category could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
			}
			
			
			$categories 	= $this->Category->find('list', array('conditions'=>array('Category.status'=>1, 'OR'=>array('Category.parent_id IS NULL', 'Category.parent_id'=>0)), 'order'=>array('Category.name'=>'ASC')));
			$this->set(compact('categories'));
		}
		
		
		
		public function admin_edit($id = null) {
			$this->set('title_for_layout',  __('Update Category Information', true)) ;
			$this->Category->id = $id;
			
			if (!$this->Category->exists()) {
				throw new NotFoundException(__('Invalid Admin'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {					
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Category data
					$this->Category->set($this->request->data);
					$this->Category->setValidation('admin');
					if ($this->Category->validates()){
						if ($this->Category->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Category information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
							} else {
							$this->Session->setFlash(__('Category could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash(__('Category could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
			}else {			
				$this->request->data = $this->Category->read(null, $id);				
			}
			
			
			$categories 	= $this->Category->find('list', array('conditions'=>array('Category.status'=>1, 'OR'=>array('Category.parent_id IS NULL', 'Category.parent_id'=>0)), 'order'=>array('Category.name'=>'ASC')));
			$this->set(compact('categories'));
		}


		
	    public function admin_delete($id = null){
			$this->Category->id = $id;
			if (!$this->Category->exists()) {
				throw new NotFoundException(__('Invalid Category'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Category->delete()) {
				$this->Session->setFlash(__('Category has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'categories', 'action' =>'index'));			
			}else{
				$this->Session->setFlash(__('Category could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'categories', 'action' =>'index'));
			}
		}
		
		
		
		public function admin_status($id = null) {
			
			$this->Category->id = $id;
			if (!$this->Category->exists()) {
				throw new NotFoundException(__('Invalid Category'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Category->toggleStatus($id)) {
				$this->Session->setFlash(__('Category  status has been changed.'), 'admin_flash_success');
				$this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Category status could not be changed.', 'admin_flash_error'));
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