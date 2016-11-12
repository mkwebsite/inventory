<?php 
App::uses('Model', 'Model');
 
class AppModel extends Model {
 
	function toggleStatus($id = null){
		$this->id = $id;
		$status = $this->field('status');
		$status = ($status==1)?2:1;
		return $this->saveField('status',$status);
	}	
 
	function  toggleCronStatus($id = null){
		$this->id = $id;
		$status = $this->field('status');
		$status = ($status==1)?2:1;
		return $this->saveField('status',$status);
	}	
}