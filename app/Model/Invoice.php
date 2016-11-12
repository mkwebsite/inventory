<?php
/**
 * Invoice
 *
 * PHP version 5
 * 
 */
class Invoice extends AppModel {
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'Invoice';
	
	/**
	 * Behaviors used by the Model
	 *
	 * @var array
	 * @access public
	 */
    var $actsAs = array(        
        'Multivalidatable'
    );	

	/**
	 * Custom validation rulesets
	 *
	 * @var array
	 * @access public
	 */
	var $validationSets = array(
		'admin'=> array(
			'user_id'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Customer name is required.'
				)
			),
			'invoice_date'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Invoice date is required.'
				)
			),
			'invoice_number'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Invoice number is required.'
				)
			),
			'due_date'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Due date is required.'
				)
			) 
		)
	);
	
	
	public function nextCode(){ 
		$data = $this->find('first',array('order'=>'Invoice.id desc','fields'=>array('Invoice.id'))) ; 
	
		if(isset($data['Invoice']['id'])){
			preg_match_all('/\d+/', $data['Invoice']['id'], $matches); 
			if(isset($matches[0][0])){ 
				$matches[0][0] +=1;
				$matches[0][0] = (strlen($matches[0][0])==1)?'00'.$matches[0][0]:$matches[0][0];
				$matches[0][0] = (strlen($matches[0][0])==2)?'0'.$matches[0][0]:$matches[0][0];
				return $matches[0][0]; 
			}else{
				return '001' ;
			}
		}else{
			return '001' ;
		} 
	}
	
}