<?php
/**
 * User
 *
 * PHP version 5
 * 
 */
class User extends AppModel {
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'User';	
	/**
	 * Behaviors used by the Model
	 *
	 * @var array
	 * @access public
	 */
    var $actsAs = array(        
        'Multivalidatable'
    );	

	
    var $virtualFields = array(
		'name' => 'CONCAT(User.first_name, " ", User.last_name)'
    );
	
	
	 /**
	 * Custom validation rulesets
	 *
	 * @var array
	 * @access public
	 */
	var $validationSets = array(
		'admin_user'=> array(
			'username'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Email address is required.'
				),
				'email' => array(
					'rule' => 'email',
					'message' => 'Invalid email address.'
				),
				'isUnique'	=>	array(
					'rule'	=>	'isUnique',
					'message'	=>	'Email is already exists.'
				)				
			),
			'first_name'=>array(
				'notEmpty' => array(
						'rule' 		=> 'notEmpty',
						'message' 	=>	'First name is required.'
				),
				'alpha' => array(
					'rule' => '/^[a-zA-Z]/',
					'message' => 'First name must have alphabets.'
				)
			), 
			'mobile'=>array(
				'notEmpty' => array(
						'rule' 		=> 'notEmpty',
						'message' 	=>	'Mobile# is required.'
				),
				'mobile' => array(
					'rule' => '/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}(\s*(ext|x)\s*\.?:?\s*([0-9]+))?$/',
					'message' => 'Invalid Phone Number.'
				)
			)
		),
		'admin'	=>	array( 
			'username'=>array(
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Username is required'
				),
				'isUnique'	=>	array(
					'rule'	=>	'isUnique',
					'message'	=>	'Username is already exists.'
				),
				'email' => array(
					'rule' => 'email',
					'message' => 'Invalid email.'
				),
				'minlength' => array(
					'rule'	=> 	array('minLength', 5),
					'message'	=>	'Username must be atleast 5 characters long.'	
				)				
			),
			'password2'	=> array(				
				'notEmpty'	=> array(
					'rule'	=> 	'notEmpty',
					'message'	=>	'Password is required'
				),
				'minlength' => array(
					'rule'	=> 	array('minLength', 6),
					'message'	=>	'Password must be atleast 6 characters long.'	
				)
			),
			'first_name'=>array(
				 'notEmpty' => array(
						'rule' 		=> 'notEmpty',
						'message' 	=>	'First name is required.'
				),
				 'alpha' => array(
					'rule' => '/^[a-zA-Z]/',
					'message' => 'First name must have alphabets.'
				 )
			),
			'country_id'=>array(
				'notEmpty' => array(
						'rule' 		=> 'notEmpty',
						'message' 	=>	'Country is required.'
				)
			), 
			'phone'=>array(
				'notEmpty' => array(
						'rule' 		=> 'notEmpty',
						'message' 	=>	'Phone is required.'
				),
				'phone_no' => array(
					'rule' => '/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}(\s*(ext|x)\s*\.?:?\s*([0-9]+))?$/',
					'message' => 'Invalid Phone Number.'
				)
			),
			'city'=>array(
				'notEmpty' => array(
						'rule' 		=> 'notEmpty',
						'message' 	=>	'City is required.'
				)
			),
			'gender'=>array(
				'notEmpty' => array(
						'rule' 		=> 'notEmpty',
						'message' 	=>	'Gender is required.'
				)
			)
		),  
		
		'change_password' => array(			
			'new_password'=>array(
			    'notEmpty'=>array(
					'rule'=>'notEmpty',
					'message' => 'New password is required.'
				),
			    'minLength'=>array(
					'rule'=>array('minLength', 6),
					'message'=>'Passwords must be at least 6 characters long.' 
				)
			),
			'confirm_password'=>array(
				'notEmpty'=>array(
					'rule'=>'notEmpty',
					'message'=>'Confirm password is required.',
					'last'=>true
				),
				'identicalFieldValues' => array(
					'rule' => array('identicalFieldValues', 'new_password' ),
					'message' => 'Password missmatch! Please check password.'
				)
			)
		),
		
		
		'new_password' => array(			
			'password3'=>array(
				'R1'=>array(
					'rule'=>'notEmpty',
					'message' => 'New password is required.'
				), 
			   'R3'=>array(
					'rule'=>array('minLength', 6),
					'message'=>'Passwords must be at least 6 characters long.' 
				)
			),
			'password4'=>array(
				'R1'=>array(
					'rule'=>'notEmpty',
					'message' => 'Confirm password is required.'
				),
				'identicalFieldValues' => array(
					'rule' => array('identicalFieldValues', 'password3' ),
					'message' => 'Please re-enter your password.'
				)			   
			 ),
			 'old_password'=>array(
			   'R1'=>array(
					'rule'=>'notEmpty',
					'message' => 'Current password is required.'
				),
				'R3'=>array(
					 'rule'=>array('minLength', 6),
					 'message'=>'Passwords must be at least 6 characters long.' 
				),	
				'checkOldPassword' => array(
					'rule' => array('checkOldPassword', 'old_password'),
					'message' => 'Current password is wrong.'
				),	
			)
		),	
		
		
		
		'forgot_password' => array(
			'username'=>array( 				
				'notEmpty' => array(
					'rule'=>'notEmpty',
					'message' => 'Email is required'
				),
				'username'	=>	array(
						'rule'	=>	'email',
						'message'	=>	'Please provide a valid email address.'
				)
			)	
		),
		
		
		
		'admin_edit' => array(
			'current_password'=>array( 				
				'notEmpty' => array(
					'rule'=>'notEmpty',
					'message' => 'Password is required.'
				)
			),
			'new_first_name'=>array( 				
				'notEmpty' => array(
					'rule'=>'notEmpty',
					'message' => 'First name is required.'
				)
			),
			'new_last_name'=>array( 				
				'notEmpty' => array(
					'rule'=>'notEmpty',
					'message' => 'Last name is required.'
				)
			),
			'new_email'=>array(						
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Email is required.'
				),		
				'email'	=>	array(
					'rule'		=>	'email',
					'message'	=>	'Please provide a valid email.'
				)
			),
		),
		
		'login'=>array(
			'username'=>array(						
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Email is required.'
				),		
				'email'	=>	array(
					'rule'	=>	'email',
					'message'	=>	'Please provide a valid email.'
				)
			),
			'password2_login'=>array(
				'notEmpty' => array(
					'rule' =>'notEmpty',
					'message' => 'Password is required.'
				)
			),
			'loginas'=>array(
				'notEmpty' => array(
					'rule' =>'notEmpty',
					'message' => 'Please select your login area.'
				)
			)
		),
		 'forgot_password' => array(
			'username'=>array(	
				'notEmpty' => array(
					'rule'=>'notEmpty',
					'message' => 'Email is required.'
				),
				'username'	=>	array(
					'rule'	=>	'email',
					'message'	=>	'Please provide a valid email address.'
				),
				
			)	
		),
		'new_password' => array(			
			'password3'=>array(	
				'R1'=>array(
					'rule'=>'notEmpty',
					'message' => 'New password is required.'
				),
				'R3'=>array(
					'rule'=>array('minLength', 6),
					'message'=>'Passwords must be at least 6 characters long.' 
				)                   
			),
			'password4'=>array(
				'R1'=>array(
					'rule'=>'notEmpty',
					'message' => 'Confirm password is required.'
				),
				'identicalFieldValues' => array(
					'rule' => array('identicalFieldValues', 'password3' ),
					'message' => 'Password missmatch, Please re-enter.'
				)				   
			),
			'old_password'=>array(	
				'R1'=>array(
					'rule'=>'notEmpty',
					'message' => 'Old password is required.'
				),
				'R3'=>array(
					'rule'=>array('minLength', 6),
					'message'=>'Passwords must be at least 6 characters long.' 
				),
				'checkOldPassword' => array(
					'rule' => array('checkOldPassword', 'old_password'),
					'message' => 'Old password is wrong.'
				)
			)
		),
	);	
	
	
	/* check for identical values in field */
	function identicalFieldValues($field=array(), $compare_field=null){
        foreach( $field as $key => $value ){
            $v1 = $value;
            $v2 = $this->data[$this->name][$compare_field ]; 
            if($v1 !== $v2) {
                return false;
            } else {
                continue;
            }
        }
        return true;
    }
	
	
	/*check confirm password */
	function confirmPassword(){
		if(!empty($this->data['User']['user_password'])){
			if($this->data['User']['user_password']!=$this->data['User']['confirm_password']){
				return false;
			}
			else{
				return true;
			}
		}	
	}
	
	function checkterms($data = null, $field=null){
		if(!empty($this->data[$this->name]['terms1'] )|| !empty($this->data[$this->name]['terms2'])){				
			return true;
		}else{
		  return false;
		}
	}
	
	/*check existing email */
	function checkEmail($data = null, $field=null) {
	    if(!empty($field)){
			if(!empty($this->data[$this->name][$field])){				
				if($this->hasAny(array('User.email' => $this->data[$this->name][$field]))){
					return true;
				}elseif($this->hasAny(array('User.username' => $this->data[$this->name][$field]))){
					return true;
				}else{
				   return false;
				}
			}
		}
	}
	
	
	
	/*check old password*/
	function checkOldPassword( $field = array(), $password = null ){	
		App::import('Component', 'Session');
		$userId = CakeSession::read('Auth.User.id') ;
        $count	= $this->find('count',array('conditions'=>array(
				'User.password'=>Security::hash($this->data[$this->name][$password], null, true),
				'User.id'=>$userId
		)));											
		if($count == 1){
			return true;
		}else{
			return false;
		}
    }
	
	
	function checkLogin($username, $passhash){  
        $user = $this->find(array('username' => $username, 'password' => $passhash), array(), null, 0);  
  
        if ($user){  
            $this->data = $user;  
            $this->id = $user['User']['id'];  
            return true;  
        }  
        return false;  
    }
	
	
	
	function beforeValidate($options = array()) {
		foreach($this->hasAndBelongsToMany as $k=>$v) {
			if(isset($this->data[$k][$k])){
				$this->data[$this->alias][$k] = $this->data[$k][$k];
			}
		}
	}
	
	
	
}