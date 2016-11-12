<?php
/**
 * ProductSold
 *
 * PHP version 5
 * 
 */
class ProductSold extends AppModel {
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	 
	var $name = 'ProductSold';	
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
					'message' 	=>	'Select customer from auto suggestion.'
				)
			),
			'first_name'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'First name is required.'
				)
			)
		)
	);
}