<?php
/**
 * Country
 *
 * PHP version 5
 *
 * @category Model 
 * 
 */
class Country extends AppModel{
	/**
	 * Model name
	 *
	 * @public  string
	 * @access public
	 */
	public  $name = 'Country';
	
	/**
	 * Behaviors used by the Model
	 *
	 * @public  array
	 * @access public
	 */
    public  $actsAs = array(        
        'Multivalidatable'
    );	
	
 
	
	 /**
	 * Custom validation rulesets
	 *
	 * @public  array
	 * @access public
	 */	
	public  $validationSets = array(
		'admin'	=>	array(		
			'name'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Name is required.'
				),	
				'isUnique'	=>	array(
					'rule'	=>	'isUnique',
					'message'	=>	'Name already exists.'
				)
			),
			'code'=>array(				
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Country code is required.'
				),	
				'isUnique'	=>	array(
					'rule'	=>	'isUnique',
					'message'	=>	'Country code already exists.'
				)
			)
		)	
	);	
	
}