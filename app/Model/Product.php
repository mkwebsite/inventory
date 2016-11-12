<?php
/**
 * Product
 *
 * PHP version 5
 * 
 */
class Product extends AppModel {
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'Product';	
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
			'name'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Name is required.'
				)
			),
			'sku'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'SKU is required.'
				),
				'unique' => array(
			        'rule' => 'isUnique',
			        'message' => 'Please enter unique SKU.'
			    ),
			),
			'uom'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'UOM is required.'
				)
			),
			'selling_price'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Selling price is required.'
				)
			),
			'sales_account'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Account is required.'
				)
			),
			'cost_price'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Cost price is required.'
				)
			),
			'purchase_account'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Account is required.'
				)
			),
			'track_account'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Account is required.'
				)
			), 
			'user_id'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Vendor is required.'
				)
			)
		)
	);	
	
	
	public function nextCode(){ 
		$data = $this->find('first',array('order'=>'Product.id desc','fields'=>array('Product.id'))) ; 
	
		if(isset($data['Product']['id'])){
			preg_match_all('/\d+/', $data['Product']['id'], $matches); 
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