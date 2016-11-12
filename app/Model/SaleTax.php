<?php
/**
 * Template
 *
 * PHP version 5
 *
 * @category Model 
 * 
 */
class SaleTax extends AppModel{
	/**
	 * Model name
	 *
	 * @public  string
	 * @access public
	 */
	public  $name = 'SaleTax';
	
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
			'zip_code'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Zip code is required.'
				)
			),
			'state'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'State is required.'
				)
			),
			'state_code'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'State code is required.'
				)
			),
			'combined_rate'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Combined rate is required.'
				)
			)	
		)	
	);
	
}