<?php
/**
 * Settings Controller
 *
 * PHP version 5.4
 *
 */
class SettingsController extends AppController {
	/**
     * Settings name
     *
     * @var string
     * @access public
     */
	var	$name		= 'Settings';
	var	$uses		= array('Setting');
	var $helpers 	= array();
	
	
	
    public function beforeFilter() {
		parent::beforeFilter();
    }
	
	
	
    public function admin_index($type=null) {
		$this->set('title_for_layout',  __('System settings', true));
		
		$filters = array();
			
        if ($this->request->is('post') || $this->request->is('put')) {
			
			if(!empty($this->request->data)) {
				
				if (!isset($this->request->params['data']['_Token']['key']) || ($this->request->params['data']['_Token']['key'] != $this->request->params['_Token']['key'])) {
					$blackHoleCallback = $this->Security->blackHoleCallback;
					$this->$blackHoleCallback();
				}
				 
				$this->Setting->set($this->request->data);
				$this->Setting->setValidation('admin');
				if ($this->Setting->validates()){
					if(isset($this->request->data['_Token']))
						unset($this->request->data['_Token']);
						
					if(isset($this->request->data['Setting']))
						unset($this->request->data['Setting']);					
					
					if ($this->Setting->saveAll($this->request->data)) {
						$this->Session->setFlash(__('Settings have been updated successfully.', true), 'admin_flash_success');
						$this->redirect($this->referer());
					} else {
						$data = $this->Setting->find('all', array('conditions'=>$filters));
						
						for($i=0; $i<count($data); $i++){
							$this->request->data[$i]['Setting']['label'] = $data[$i]['Setting']['label'];
							$this->request->data[$i]['Setting']['description'] = $data[$i]['Setting']['description'];
						}
						$this->Session->setFlash(__('Settings could not be updated. Please fill all the fields.',true), 'admin_flash_error');
					}
					
				}else {
					$data = $this->Setting->find('all', array('conditions'=>$filters));
					
					for($i=0; $i<count($data); $i++){
						$this->request->data[$i]['Setting']['label'] = $data[$i]['Setting']['label'];
						$this->request->data[$i]['Setting']['description'] = $data[$i]['Setting']['description'];
					}
					$this->Session->setFlash(__('Settings could not be updated. Please fill all the fields.', true), 'admin_flash_error');
				}
			}	
        }else {
			$this->request->data = $this->Setting->find('all', array('conditions'=>$filters, 'order'=>array('id'=>'ASC')));
        }
    }
	
	 
    
}