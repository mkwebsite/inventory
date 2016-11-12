<?php
/**
 * Sale
 *
 * PHP version 5
 * 
 */
class Sale extends AppModel {
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'Sale';
	
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
			'order_no'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Sales order# is required.'
				)
			),
			'order_date'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Sales order date is required.'
				)
			)
		)
	);
	
	
	public function nextCode(){ 
		$data = $this->find('first',array('order'=>'Sale.id desc','fields'=>array('Sale.id'))) ; 
	
		if(isset($data['Sale']['id'])){
			preg_match_all('/\d+/', $data['Sale']['id'], $matches); 
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