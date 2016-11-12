<?php
	/**
		* Products Controller
		*
		* PHP version 5.4
		*
	*/
	class ProductsController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		var	$name	= 'Products'; 
		var	$uses	=	array('Product', 'User', 'Category');
		
		/*
			* beforeFilter
			* @return void
		*/
		public function beforeFilter() {
			parent::beforeFilter();
		}
		
		
		
		/*
		** List all products in admin panel
		*/
		public function admin_index($defaultTab=null) {
			$title_for_layout =  __('Products Listing', true);
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array('Product.status'=>array(1,2,3,4));
			if($defaultTab){
				$filters 		  = array('Product.status'=>$defaultTab);
				$title_for_layout = "Products Listing (". Configure::read('ProductStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			$this->set('title_for_layout',  $title_for_layout) ;
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Product']['keyword'])){				
					$name = Sanitize::escape($this->request->data['Product']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('Product.name LIKE'=>$keyword."%", 'Product.sku LIKE'=>$keyword."%", 'User.first_name LIKE'=>$keyword."%", 'User.last_name LIKE'=>$keyword."%"));
			}
			
			$this->Product->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
				'Product'	=> array(
					'fields'			=> array('Product.*', 'User.first_name', 'User.last_name'),
					'limit'				=> Configure::read('App.AdminPageLimit'), 
					'order'				=> array('Product.modified'=>'DESC'),
					'conditions'		=> $filters
			));
			
			$data 					= $this->paginate('Product');   
     		$active     			= $this->Product->find('count',array('conditions'=>array('Product.status'=>1)));
			$inactive 				= $this->Product->find('count',array('conditions'=>array('Product.status'=>2)));
     		$below_minimum_stock    = $this->Product->find('count',array('conditions'=>array('Product.status'=>3)));
			$out_of_stock 			= $this->Product->find('count',array('conditions'=>array('Product.status'=>4)));
			$all					= (int)$active + (int)$inactive + (int)$below_minimum_stock + (int)$out_of_stock;
			//pr($data);die; 
			$this->set(compact('data','active','inactive','below_minimum_stock','out_of_stock','all'));		
			
		}
		
		
		
		public function admin_add() {	
			$this->set('title_for_layout',  __('Add New Products', true)) ;
			
			if ($this->request->is('post')) {
				//check empty
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						//$blackHoleCallback = $this->Security->blackHoleCallback;
						//$this->$blackHoleCallback();
					}
					
					//validate Product data
					$this->Product->set($this->request->data);
					$this->Product->setValidation('admin');
					if ($this->Product->validates()) {
						if ($this->Product->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Product has been saved successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index'));
						} else {
							$this->Session->setFlash(__('Product could not be saved. Please try again.'), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash('Product could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
			}else{
				$this->request->data['Product']['sku'] = "P". date('dmy') . $this->Product->nextCode();
			}
			
			$users = $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}
		
		
		
		 
		public function admin_edit($id = null) {
			$this->set('title_for_layout',  __('Update Products Information', true)) ;
			$this->Product->id = $id;
			
			if (!$this->Product->exists()) {
				throw new NotFoundException(__('Invalid Admin'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {					
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Product data
					$this->Product->set($this->request->data);
					$this->Product->setValidation('admin');
					if ($this->Product->validates()){
						if ($this->Product->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Product information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
							} else {
							$this->Session->setFlash(__('Product could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash(__('Product could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
			}else {			
				$this->request->data = $this->Product->read(null, $id);				
			}
			
			$users 			= $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}


		
	    public function admin_delete($id = null){
			$this->Product->id = $id;
			if (!$this->Product->exists()) {
				throw new NotFoundException(__('Invalid Products'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			$data['Product']['id'] =  $id;
			$data['Product']['status'] =  5;
			if ($this->Product->saveAll($data)) {
				$this->Session->setFlash(__('Product has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'products', 'action' =>'index'));			
			}else{
				$this->Session->setFlash(__('Product could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'products', 'action' =>'index'));
			}
		}
		
		
		
		public function admin_status($id = null) {
			
			$this->Product->id = $id;
			if (!$this->Product->exists()) {
				throw new NotFoundException(__('Invalid Products'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Product->toggleStatus($id)) {
				$this->Session->setFlash(__('Product  status has been changed.'), 'admin_flash_success');
				$this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Product status could not be changed.', 'admin_flash_error'));
			$this->redirect($this->referer());
		}
		
		
		
		public function admin_view($id = null) {
			$this->set('title_for_layout',  __('Products Information', true)) ;
			$result = array();
			
			$this->Product->id = $id;
			if (!$this->Product->exists()) {
				throw new NotFoundException(__('Invalid Products'));
			}
			
			$this->Product->bindModel(array('belongsTo'=>array('User')), false);
			$this->set('data', $this->Product->read(null, $id));
		}
		
		
		
		function referer($default = NULL, $local = false){
			$defaultTab = $this->Session->read('Url.defaultTab');
			$Page = $this->Session->read('Url.Page');
			$sort = $this->Session->read('Url.sort');
			$direction = $this->Session->read('Url.direction');
			
			return Router::url(array('action'=>'index', $defaultTab,'Page'=>$Page,'sort'=>$sort,'direction'=>$direction),true);
		}

		public function admin_reorder($id = null) {
			$this->set('title_for_layout',  __('Update Products Information', true)) ;
			$this->Product->id = $id;
			
			if (!$this->Product->exists()) {
				throw new NotFoundException(__('Invalid Admin'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {					
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Product data
					$this->Product->set($this->request->data);
					$this->Product->setValidation('admin');
					if ($this->Product->validates()){
						if ($this->Product->saveAll($this->request->data)) {
							$this->Session->setFlash(__('Product information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
							} else {
							$this->Session->setFlash(__('Product could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash(__('Product could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
			}else {			
				$this->request->data = $this->Product->read(null, $id);	
				unset($this->request->data['Product']['id']);			
			}
			
			$users 			= $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}


		 public function admin_barcode($id = null) {

			Configure::write('debug', 0);
	        App::uses('BarcodeHelper','Vendor');
	        
	        $this->Product->id = $id;
			if (!$this->Product->exists()) {
			

	        $ar['code'] = 404;
	        $arr['url'] = '';
	        $arr['msg'] = "Erro in generating barcode.";
	        echo json_encode($arr);exit;
			}

			$product = $this->Product->read(null, $id);	

	        
	        //pr($product);
	        $id=$product['Product']['id'];
	        $upcid=$product['Product']['sku'];
	        
	        
	        //pr($product);
	       //die;


	        $barcode=new BarcodeHelper();
	        $barcode->barcode();
	        $barcode->setType('C128');
	        $barcode->setCode($upcid);
	        $barcode->setSize(80,80);

	         $imgname = 'product_'.$id.'.png';
	         $file = WWW_ROOT.'uploads/products/barcode/'.$imgname;
	        
	        // Generates image file on server            
	        $barcode->writeBarcodeFile($file);
	        // END
	        $sdata['Product']['id'] = $id;
	        $sdata['Product']['barcode_genrated'] = 1;
	        $this->Product->save($sdata);
	        $ar['code'] = 200;
	        $arr['url'] = Router::url('/',true).'uploads/products/barcode/'.$imgname;
	        $arr['msg'] = "barcode generated successfully.";
	        echo json_encode($arr);exit;
    	} 

    	public function admin_download($id = null) {

			$this->viewClass = 'Media';
	        $this->Product->id = $id;
			if (!$this->Product->exists()) {
	        	$this->Session->setFlash(__('Product information has been updated successfully.',true), 'admin_flash_error');
				$this->redirect(array('action'=>'index')) ;
			}

			//$product = $this->Product->read(null, $id);	

			 $params = array(
		            'id'        => 'product_'.$id.'.png',
		            'name'      => 'product_'.$id,
		            'download'  => true,
		            'extension' => 'png',
		            'path'      => WWW_ROOT .'uploads' . DS.'products'.DS.'barcode'.DS
		        );
        	$this->set($params);
	    }   


	}