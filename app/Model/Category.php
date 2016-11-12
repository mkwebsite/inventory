<?php
/**
 * Category
 *
 * PHP version 5
 *
 * @category Model 
 * 
 */
class Category extends AppModel{
	/**
	 * Model name
	 *
	 * @public  string
	 * @access public
	 */
	public  $name = 'Category';
	
	/**
	 * Behaviors used by the Model
	 *
	 * @public  array
	 * @access public
	 */
    public  $actsAs = array(        
        'Multivalidatable'
    );	
	
	public  $belongsTo = array(
		'Parent'=>array(
			'className'=>'Category',
			'foreignKey'=>'parent_id',
			'fields'=>array('name')
		)
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
					'message'	=>	'Name is already exists.'
				)
			)	
		)
	);
	
}