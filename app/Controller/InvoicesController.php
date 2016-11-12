<?php
	/**
		* Invoice Controller
		*
		* PHP version 5.4
		*
	*/
	class InvoicesController  extends AppController {
		/**
			* Controller name
			*
			* @var string
			* @access public
		*/
		public $components = array('Common');
		var	$name	= 'Invoice'; 
		var	$uses	=	array('Invoice', 'User', 'Category');
		
		/*
			* beforeFilter
			* @return void
		*/
		public function beforeFilter() {
			parent::beforeFilter();
		}
		
		
		
		
		
		/*
			** get customers lists
		*/
		public function admin_get_cust_list(){
			
			$key = isset($this->params->query['term'])?$this->params->query['term']:''; 
			if($key == '')die;
			
			$city_data = $this->User->find('all', array(
			'limit'		=> Configure::read('AutosujetionLimit'),
			'fields'	=> array('User.id', 'User.first_name', 'User.last_name', 'User.salutation', 'User.username'), 
			'conditions'=> array('User.status'=>1, 'User.role_id'=>2, 'OR'=>array('User.first_name Like '=>$key.'%', 'User.last_name Like '=>$key.'%', 'User.username Like '=>$key.'%', 'User.mobile Like '=>$key.'%', 'User.phone Like '=>$key.'%'))
			));
			
			$data = array();
			
			foreach($city_data as $val){
				$name = Configure::read('Salutation.'. $val['User']['salutation']) .' '. $val['User']['first_name'] .' '. $val['User']['last_name'] ;
				$email= $name ." (". $val['User']['username'] .")";
				$data[] = array(
				'label' 	=> $name,
				'value' 	=> $name,
				'last_name' => $val['User']['last_name'],
				'user_id'   => $val['User']['id'],
				'email'   	=> $email 
				);
			}
			
			echo json_encode($data);
			flush();
			die;
		}
		
		
		
		
		
		/*
			** get product lists
		*/
		public function admin_product_info(){
			$this->loadModel('Product');
			$key = isset($this->params->query['term'])?$this->params->query['term']:''; 
			if($key == '')die;
			
			$city_data = $this->Product->find('all', array(
			'limit'		=> Configure::read('AutosujetionLimit'),
			'conditions'=> array('OR'=>array('Product.name Like '=>$key.'%', 'Product.sku Like '=>$key.'%'))
			));
			
			$data = array();
			
			foreach($city_data as $val){
				$name = $val['Product']['sku'] .': '. $val['Product']['name']; // .'\r\r\n'. $val['Product']['sales_desc'];
				$data[] = array(
				'label' 	=> $name,
				'value' 	=> $name,
				'rate' 		=> $val['Product']['sales_account'],
				'product_id'=> $val['Product']['id'],
				'tax'   	=> $val['Product']['sales_tax'],
				'amount'   	=> $val['Product']['sales_account'] + $val['Product']['sales_tax']
				);
			}
			
			
			echo json_encode($data);
			flush();
			die;
		}
		
		
		
		
		
		public function admin_add_row(){
			$row_id = (isset($this->request->data['row_id']))?$this->request->data['row_id']:'';
			if($row_id){
				$row_id++;
				$this->set('i', $row_id);
				$this->render('/Elements/Admin/Invoice/add_product');
				} else{
				die;
			}
		}
		
		
		
		
		
		
		/*
			** List all products in admin panel
		*/
		public function admin_index($defaultTab=null){ 
		
			$this->set('title_for_layout',  __('Invoices', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array();
			if($defaultTab){
				$filters 		  = array('Invoice.status'=>$defaultTab);
				$title_for_layout = "Sales Order Listing (". Configure::read('SalesStatus.'. $defaultTab) .")";
				$this->Session->write('Url.defaultTab', $defaultTab);
			}
			
			if(!empty($this->request->data)){			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Invoice']['keyword'])){				
					$name = Sanitize::escape($this->request->data['Invoice']['keyword']);
					$this->Session->write('AdminSearch.keyword', $name);				
				}
			}
			
			if($this->Session->check('AdminSearch')){
				$keyword  = $this->Session->read('AdminSearch.keyword');			
				$filters[] = array('OR'=>array('Invoice.invoice_number LIKE'=>$keyword."%", 'Invoice.order_number LIKE'=>$keyword."%", 'User.first_name LIKE'=>$keyword."%", 'User.last_name LIKE'=>$keyword."%"));
			}
			
			$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
			'Invoice'	=> array(
			'fields'			=> array('Invoice.*', 'User.first_name', 'User.last_name'),
			'limit'				=> Configure::read('App.AdminPageLimit'), 
			'order'				=> array('Invoice.modified'=>'DESC'),
			'conditions'		=> $filters
			));
			
			$data 		= $this->paginate('Invoice');    
			$this->set(compact('data'));		
		}
		
		
		public function admin_invoices_report() {
		
			$this->set('title_for_layout',  __('Invoice History', true)) ;
			if(!isset($this->request->params['named']['page']) and !isset($this->request->params['named']['sort'])){
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
			}	
			
			$filters = array(); 
			$title_for_layout = "Invoice History";  
			
			if(!empty($this->request->data)){		
			
				$this->Session->delete('AdminSearch');
				$this->Session->delete('Url');
				
				App::uses('Sanitize', 'Utility');		
				if(!empty($this->data['Invoice']['status'])){				
					$status = Sanitize::escape($this->request->data['Invoice']['status']);
					$this->Session->write('AdminSearch.status', $status);				
				}
				
				if(!empty($this->data['Invoice']['from'])){				
					$from = Sanitize::escape($this->request->data['Invoice']['from']);
					$this->Session->write('AdminSearch.from', $from);				
				}
				
				if(!empty($this->data['Invoice']['to'])){				
					$to = Sanitize::escape($this->request->data['Invoice']['to']);
					$this->Session->write('AdminSearch.to', $to);				
				}
			}

			
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($status){
					$filters[]	= array('Invoice.status'=>$status);
				}
				
				if($from_date and $to_date){
					$filters[] = array('Invoice.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Invoice.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Invoice.created <=' => $to_date);
				}
				
			}
			
			$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
			$this->paginate = array(
			'Invoice'	=> array(
			'fields'			=> array('Invoice.*', 'User.first_name', 'User.last_name'),
			'limit'				=> Configure::read('App.AdminPageLimit'), 
			'order'				=> array('Invoice.modified'=>'DESC'),
			'conditions'		=> $filters
			));
			
			$data 		= $this->paginate('Invoice');    
			$this->set(compact('data'));	
			
			
		}
		
		
		
	
		public function admin_export_pdf() {
		
			$this->loadModel('InvoiceProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Invoice.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Invoice.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Invoice.created <=' => $to_date);
				} 
			}
			
			$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Invoice->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Invoice.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Invoice.modified'=>'DESC'),
			));   
			$all_total_amt = 0;
			$last_key= '';  
			foreach($data as $key => $p){ 
				$sale_product = $this->InvoiceProduct->find('all', array(  
					'conditions'=>array('InvoiceProduct.invoice_id'=>$p['Invoice']['id'])
				));   
				$total_amt = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['InvoiceProduct']['total_amount']; 
					}
				}    
				$postData[$key]['Post']['status'] = Configure::read('Status.' . $p['Invoice']['status']); 
				$postData[$key]['Post']['invoice_date'] = $p['Invoice']['invoice_date'];
				$postData[$key]['Post']['due_date'] 	= $p['Invoice']['due_date'];
				$postData[$key]['Post']['invoice_number'] = $p['Invoice']['invoice_number'];
				$postData[$key]['Post']['order_number'] = $p['Invoice']['order_number'];
				$postData[$key]['Post']['customer_name'] = $p['User']['first_name'] .' '. $p['User']['last_name'];  
				$postData[$key]['Post']['invoice_amount'] =  number_format($total_amt,2); 
				$all_total_amt += $total_amt;   
				$last_key += $key;

			}    
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['status'] = 'Total'; 
				$postData[$last_key]['Post']['invoice_date'] = '';
				$postData[$last_key]['Post']['due_date'] = '';
				$postData[$last_key]['Post']['invoice_number'] = '';
				$postData[$last_key]['Post']['order_number'] = '';
				$postData[$last_key]['Post']['customer_name'] = ''; 
				$postData[$last_key]['Post']['invoice_amount'] =  number_format($all_total_amt,2);  
			}   
			  
			$this->set('posts',$postData);   
			$html_content = '<div class="pageheader" style="margin-bottom: 3px; text-align: center;">
				<h2 class="custom-font">'.$this->Auth->user('company_name').'</h2>
				<p>Invoice Details</p>
			</div>'; 
			$view = new View($this, false);
			$html_content .= $view->element('Admin/Invoice/invoice_report_pdf');	
			
			//pr($html_content); die; 
			
			App::import('Vendor', 'mPDF', array('file'=>'mpdf/mpdf.php')); 
			$mpdf = new mPDF(); 
			$mpdf->setAutoTopMargin = 'stretch'; // Set pdf top margin to stretch to avoid content overlapping  
			$mpdf->WriteHTML($html_content);
			$mpdf->Output('invoice_details.pdf','D');
			die;
			
		}
		
		
		
		public function admin_export_csv() { 
		
			$this->loadModel('InvoiceProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Invoice.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Invoice.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Invoice.created <=' => $to_date);
				} 
			}
			
			$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Invoice->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Invoice.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Invoice.modified'=>'DESC'),
			));   
			$all_total_amt = 0;
			$last_key= '';  
			foreach($data as $key => $p){ 
				$sale_product = $this->InvoiceProduct->find('all', array(  
					'conditions'=>array('InvoiceProduct.invoice_id'=>$p['Invoice']['id'])
				));   
				$total_amt = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['InvoiceProduct']['total_amount']; 
					}
				}    
				$postData[$key]['Post']['status'] = Configure::read('Status.' . $p['Invoice']['status']); 
				$postData[$key]['Post']['invoice_date'] = $p['Invoice']['invoice_date'];
				$postData[$key]['Post']['due_date'] 	= $p['Invoice']['due_date'];
				$postData[$key]['Post']['invoice_number'] = $p['Invoice']['invoice_number'];
				$postData[$key]['Post']['order_number'] = $p['Invoice']['order_number'];
				$postData[$key]['Post']['customer_name'] = $p['User']['first_name'] .' '. $p['User']['last_name'];  
				$postData[$key]['Post']['invoice_amount'] =  number_format($total_amt,2); 
				$all_total_amt += $total_amt;   
				$last_key += $key;

			}    
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['Post']['status'] = 'Total'; 
				$postData[$last_key]['Post']['invoice_date'] = '';
				$postData[$last_key]['Post']['due_date'] = '';
				$postData[$last_key]['Post']['invoice_number'] = '';
				$postData[$last_key]['Post']['order_number'] = '';
				$postData[$last_key]['Post']['customer_name'] = ''; 
				$postData[$last_key]['Post']['invoice_amount'] =  number_format($all_total_amt,2);  
			}   
			
			$file_name = 'invoice_details'; 
			$this->set('posts',$postData);
			$this->layout = null;
			$this->autoLayout = false; 
			
		}
		
		
		
		
		
		public function admin_export_xls(){
		
			$this->autoRender = false;

			$this->loadModel('InvoiceProduct'); 
			$filters = array();
			$postData = array();
			if($this->Session->check('AdminSearch')){
				$from_date  = $this->Session->read('AdminSearch.from');
				$to_date  	= $this->Session->read('AdminSearch.to');
				$status	= $this->Session->read('AdminSearch.status');
				
				if($this->Session->check('AdminSearch.status')){ 
					$filters[]	= array('Purchase.status'=>$status);
				} 
				if($from_date and $to_date){
					$filters[] = array('Invoice.created BETWEEN ? AND ?'=> array($from_date, $to_date));
				}else if($from_date){
					$filters[] = array('Invoice.created >=' => $from_date);
				}else if($to_date){
					$filters[] = array('Invoice.created <=' => $to_date);
				} 
			}
			
			$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
			$data = $this->Invoice->find('all', array(  
				'conditions'=> $filters,
				'fields'=>array('Invoice.*', 'User.first_name', 'User.last_name'),
				'order'	=> array('Invoice.modified'=>'DESC'),
			));   
			$all_total_amt = 0;
			$last_key= '';  
			foreach($data as $key => $p){ 
				$sale_product = $this->InvoiceProduct->find('all', array(  
					'conditions'=>array('InvoiceProduct.invoice_id'=>$p['Invoice']['id'])
				));   
				$total_amt = 0;
				if(!empty($sale_product)) {
					foreach($sale_product as $val) {
						$total_amt +=  $val['InvoiceProduct']['total_amount']; 
					}
				}    
				$postData[$key]['status'] = Configure::read('Status.' . $p['Invoice']['status']); 
				$postData[$key]['invoice_date'] = $p['Invoice']['invoice_date'];
				$postData[$key]['due_date'] 	= $p['Invoice']['due_date'];
				$postData[$key]['invoice_number'] = $p['Invoice']['invoice_number'];
				$postData[$key]['order_number'] = $p['Invoice']['order_number'];
				$postData[$key]['customer_name'] = $p['User']['first_name'] .' '. $p['User']['last_name'];  
				$postData[$key]['invoice_amount'] =  number_format($total_amt,2); 
				$all_total_amt += $total_amt;   
				$last_key += $key;

			}    
			if(!empty($postData)){
				$last_key = $last_key+1;
				$postData[$last_key]['status'] = 'Total'; 
				$postData[$last_key]['invoice_date'] = '';
				$postData[$last_key]['due_date'] = '';
				$postData[$last_key]['invoice_number'] = '';
				$postData[$last_key]['order_number'] = '';
				$postData[$last_key]['customer_name'] = ''; 
				$postData[$last_key]['invoice_amount'] =  number_format($all_total_amt,2);  
			}    
			$name = 'invoice_details';
			$this->Common->createExcelFile($postData,'Excel',$name);
		} 
		
		
		
		public function admin_add() {	
		
			$this->set('title_for_layout',  __('New Invoice', true)) ; 
			if($this->request->is('post')) {
				
 				//check empty
				if(!empty($this->request->data)){
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Invoice data
					$this->Invoice->set($this->request->data);
					$this->Invoice->setValidation('admin');
					if ($this->Invoice->validates()) {
						
						$items = (isset($this->request->data['Invoice']['p']))?$this->request->data['Invoice']['p']:'';
						unset($this->request->data['Invoice']['p']);
						if(isset($this->request->data['attach']) && !empty($this->request->data['attach'])) {
							foreach($this->request->data['attach'] as $img_val) {
								$destination = WWW_ROOT . '/files/' . $this->Auth->user('id') . '/';
								$uploadStatus = $this->Common->uploadFileImage($this->params->form['file'], $destination);
							}
						}
						
						if ($this->Invoice->saveAll($this->request->data)) {
							$invoice_id = $this->Invoice->id; 
							
							$this->loadModel('InvoiceAttachment');			
							if(isset($this->request->data['Invoice']['attach']) && !empty($this->request->data['Invoice']['attach'])) {
								foreach($this->request->data['Invoice']['attach'] as $img_val) {
									$destination = WWW_ROOT . '/img/attachment/';
									$ext = pathinfo($img_val['name'], PATHINFO_EXTENSION);
									$filename = (date('ymdhis')).'_'.rand(1111111111,999999999).'.'.$ext;
									$invoice_attachment = array();
									$invoice_attachment['InvoiceAttachment']['file_name']	 = $filename;
									$invoice_attachment['InvoiceAttachment']['invoice_id']	 = $invoice_id;
									if(move_uploaded_file($img_val['tmp_name'], $destination.$filename)){
										$this->InvoiceAttachment->saveAll($invoice_attachment);
									} 
								}
							} 
							
							if($items){
								$this->loadModel('InvoiceProduct');
								foreach($items as $val){
									$sale_products = array();
									$sale_products['InvoiceProduct']['product_id']	 = $val['product_id'];
									$sale_products['InvoiceProduct']['invoice_id']	 = $invoice_id;
									$sale_products['InvoiceProduct']['qty']			 = $val['quantity'];
									$sale_products['InvoiceProduct']['rate']		 = $val['rate'];
									$sale_products['InvoiceProduct']['discount']	 = $val['discount'];
									$sale_products['InvoiceProduct']['tax']			 = $val['tax'];
									$sale_products['InvoiceProduct']['total_amount'] = $val['amount'];
									$this->InvoiceProduct->saveAll($sale_products);
								}
							} 
							$this->Session->setFlash(__('Invoice has been saved successfully.'), 'admin_flash_success');
							$this->redirect(array('action' => 'index'));
						} else {
							$this->Session->setFlash(__('Invoice could not be saved. Please try again.'), 'admin_flash_error');
						}
					}else {
						$this->Session->setFlash('Invoice could not be saved. Please correct errors.', 'admin_flash_error');
					}
				}
			} else {
				$this->request->data['Invoice']['invoice_number'] = "INV-". date('dmy') .'-'. $this->Invoice->nextCode();
			} 
			$users = $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}
		
		
		
		
		public function admin_edit($id = null) {
			$this->set('title_for_layout',  __('Update Invoice', true)) ;
			$this->Invoice->id = $id;
			
			if (!$this->Invoice->exists()) {
				throw new NotFoundException(__('Invalid Invoice'));
			}
			
			if ($this->request->is('post') || $this->request->is('put')) {	
			
				if(!empty($this->request->data)) {
					if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
						$blackHoleCallback = $this->Security->blackHoleCallback;
						$this->$blackHoleCallback();
					}
					
					//validate Invoice data
					$this->Invoice->set($this->request->data);
					$this->Invoice->setValidation('admin');
					if ($this->Invoice->validates()){
					
						$items = (isset($this->request->data['Invoice']['p']))?$this->request->data['Invoice']['p']:'';
						unset($this->request->data['Invoice']['p']);
					
						if ($this->Invoice->saveAll($this->request->data)) { 
							$invoice_id = $id;
							 
							$this->loadModel('InvoiceAttachment');			
							if(isset($this->request->data['Invoice']['attach']) && !empty($this->request->data['Invoice']['attach'])) {
								foreach($this->request->data['Invoice']['attach'] as $img_val) {
									$destination = WWW_ROOT . '/img/attachment/';
									$ext = pathinfo($img_val['name'], PATHINFO_EXTENSION);
									$filename = (date('ymdhis')).'_'.rand(1111111111,999999999).'.'.$ext;
									$invoice_attachment = array();
									$invoice_attachment['InvoiceAttachment']['file_name']	 = $filename;
									$invoice_attachment['InvoiceAttachment']['invoice_id']	 = $invoice_id;
									if(move_uploaded_file($img_val['tmp_name'], $destination.$filename)){
										$this->InvoiceAttachment->saveAll($invoice_attachment);
									} 
								}
							} 
							
							if($items){
								$this->loadModel('InvoiceProduct');
								$this->InvoiceProduct->deleteAll(array('InvoiceProduct.invoice_id'=>$id));
								foreach($items as $val){
									$sale_products = array();
									$sale_products['InvoiceProduct']['product_id']	 = $val['product_id'];
									$sale_products['InvoiceProduct']['invoice_id']	 = $invoice_id;
									$sale_products['InvoiceProduct']['qty']			 = $val['quantity'];
									$sale_products['InvoiceProduct']['rate']		 = $val['rate'];
									$sale_products['InvoiceProduct']['discount']	 = $val['discount'];
									$sale_products['InvoiceProduct']['tax']			 = $val['tax'];
									$sale_products['InvoiceProduct']['total_amount'] = $val['amount'];
									$this->InvoiceProduct->saveAll($sale_products);
								}
							}   
							
							$this->Session->setFlash(__('Invoice information has been updated successfully.',true), 'admin_flash_success');
							$this->redirect(array('action'=>'index')) ;
						} else {
							$this->Session->setFlash(__('Invoice could not be updated. Please try again.',true), 'admin_flash_error');
						}
					}else {
						$this->Invoice->id = $id;
						$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
						$data_read = $this->Invoice->read(null, $id);
						$this->request->data['User']['first_name'] =  $data_read['User']['first_name'];
						$this->request->data['User']['last_name'] =  $data_read['User']['last_name'];
						$this->Session->setFlash(__('Invoice could not be updated. Please correct errors.', true), 'admin_flash_error');
					}
				}	
				}else {		
				$this->Invoice->id = $id;
				$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
				$this->request->data = $this->Invoice->read(null, $id); 
			}
			
			$users 	= $this->User->find('list', array('fields'=>array('User.id', 'User.name'), 'conditions'=>array('User.role_id'=>3, 'User.status'=>1), 'order'=>array('User.first_name'=>'ASC')));
			$this->set(compact('users')) ;
		}
		
		
		
	    public function admin_delete($id = null){
		
			$this->loadModel('InvoiceAttachment');
			$this->loadModel('InvoiceProduct');
			if(!empty($this->request->data)) {
				$id = isset($this->request->data['Invoice']['id'])?$this->request->data['Invoice']['id']:'';
			} 
			
			$this->Invoice->id = $id;
			if (!$this->Invoice->exists()) {
				throw new NotFoundException(__('Invalid Invoice'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
 			 
			if ($this->Invoice->delete()) {
			
				$InvoiceAttachment 	= $this->InvoiceAttachment->find('all', array('conditions'=>array('InvoiceAttachment.invoice_id'=>$id), 'order'=>array('InvoiceAttachment.id'=>'ASC')));
				if(!empty($InvoiceAttachment)) {
					$destination = WWW_ROOT . '/img/attachment/';
					foreach($InvoiceAttachment as $val){
						$img = $val['InvoiceAttachment']['file_name'];
						if (file_exists($destination .''. $img)) {
							unlink($destination .''. $img);
						} 
					} 
				}  
			
				$this->InvoiceProduct->deleteAll(array('InvoiceProduct.invoice_id'=>$id));
				$this->InvoiceAttachment->deleteAll(array('InvoiceAttachment.invoice_id'=>$id));
			
				$this->Session->setFlash(__('Invoice has been deleted successfully.'), 'admin_flash_success');
				$this->redirect(array('controller' => 'invoices', 'action' =>'index'));			
			}else{
				$this->Session->setFlash(__('Invoice could not be deleted.'), 'admin_flash_error');
				$this->redirect(array('controller' => 'invoices', 'action' =>'index'));
			}
		}	
		
		
		public function admin_download($id = null) {
		
			$this->loadModel('InvoiceAttachment');
		
			$data = $this->InvoiceAttachment->read('file_name', $id); //pr($data); die;
			if($data['InvoiceAttachment']['file_name']){
				
				$file = WWW_ROOT."img/attachment/" . $data['InvoiceAttachment']['file_name'] ;
				if (file_exists($file)) {
					
						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename='.basename($file));
						header('Content-Transfer-Encoding: binary');
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize($file));
						readfile($file);
						exit;
					
				}else{
					$this->Session->setFlash(__('Attatchment does not exist.'), 'admin_flash_success');
				}
				$this->redirect(array('action' => 'index'));
			}else{
				$this->Session->setFlash(__('Attatchment could not be downloaded.'), 'admin_flash_error');
				$this->redirect(array('action' => 'index'));
			}
		}
		
		
	    public function admin_delete_img($id = null){
		 
			$this->loadModel('InvoiceAttachment');
			if(!empty($this->request->data)) {
				$id = isset($this->request->data['id'])?$this->request->data['id']:'';
			}  
			$InvoiceAttachment 	= $this->InvoiceAttachment->find('all', array('conditions'=>array('InvoiceAttachment.id'=>$id), 'order'=>array('InvoiceAttachment.id'=>'ASC')));
			if(!empty($InvoiceAttachment)) {
				$destination = WWW_ROOT . '/img/attachment/';
				foreach($InvoiceAttachment as $val){
					$img = $val['InvoiceAttachment']['file_name'];
					if (file_exists($destination .''. $img)) {
						unlink($destination .''. $img);
					} 
				} 
			}   
			$this->InvoiceAttachment->deleteAll(array('InvoiceAttachment.id'=>$id)); 
			echo 'success'; die;
		}
		
		
		
		public function admin_status($id = null) {
			
			$this->Invoice->id = $id;
			if (!$this->Invoice->exists()) {
				throw new NotFoundException(__('Invalid Invoice'));
			}
			
			if (!isset($this->request->params['named']['token']) || ($this->request->params['named']['token'] != $this->request->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			
			if ($this->Invoice->toggleStatus($id)) {
				$this->Session->setFlash(__('Invoice  status has been changed.'), 'admin_flash_success');
				$this->redirect($this->referer());
			}
			$this->Session->setFlash(__('Invoice status could not be changed.', 'admin_flash_error'));
			$this->redirect($this->referer());
		}
		
		
		
		public function admin_view($id = null) {
			$this->set('title_for_layout',  __('Invoices Information', true)) ;
			$result = array();
			
			$this->Invoice->id = $id;
			if (!$this->Invoice->exists()) {
				throw new NotFoundException(__('Invalid Invoice'));
			}
			
			$this->Invoice->bindModel(array('belongsTo'=>array('User')), false);
			$this->set('data', $this->Invoice->read(null, $id));
		}
		
		
		
		function referer($default = NULL, $local = false){
			$defaultTab = $this->Session->read('Url.defaultTab');
			$Page = $this->Session->read('Url.Page');
			$sort = $this->Session->read('Url.sort');
			$direction = $this->Session->read('Url.direction');
			
			return Router::url(array('action'=>'index', $defaultTab,'Page'=>$Page,'sort'=>$sort,'direction'=>$direction),true);
		}
	}	