<?php

class GeneralHelper extends AppHelper {

	var $helpers = array('Html', 'Session', 'Form', 'Paginator');
	
	public static function getCountryName($country_id=null){
		$obj = ClassRegistry::init('Country'); 
		$result = $obj->find('first',array('conditions'=>array('Country.id'=>$country_id)));
		return (isset($result['Country']['name']))?$result['Country']['name']:''; 
	}	
	
	public static function getProductList($sale_id=null){
	
		$obj = ClassRegistry::init('SaleProduct');
		$obj->bindModel(array('belongsTo'=>array('Product')), false);
		$result = $obj->find('all',array('conditions'=>array('SaleProduct.sale_id'=>$sale_id))); 
		return $result;
	}	
	
	public static function getPurchasesList($purchase_id=null){
	
		$obj = ClassRegistry::init('PurchaseProduct');
		$obj->bindModel(array('belongsTo'=>array('Product')), false);
		$result = $obj->find('all',array('conditions'=>array('PurchaseProduct.purchase_id'=>$purchase_id))); 
		return $result;
	}	
	
	public static function getInvoiceProduct($invoice_id=null){
	
		$obj = ClassRegistry::init('InvoiceProduct');
		$obj->bindModel(array('belongsTo'=>array('Product')), false);
		$result = $obj->find('all',array('conditions'=>array('InvoiceProduct.invoice_id'=>$invoice_id))); 
		return $result;
	}		
	
	public static function getUseraddress($user_id=null){
		$obj = ClassRegistry::init('UserBillingAddress');
		$result = $obj->find('first',array('conditions'=>array('UserBillingAddress.user_id'=>$user_id))); 
		return $result;
	}
	
	public static function getDeliverTo($user_id=null){
		$obj = ClassRegistry::init('User');
		$result = $obj->find('first',array('conditions'=>array('User.id'=>$user_id))); 
		return $result;
	}	
	
	public static function getAttachment($invoice_id=null){
		$obj = ClassRegistry::init('InvoiceAttachment');
		$result = $obj->find('all',array('conditions'=>array('InvoiceAttachment.invoice_id'=>$invoice_id))); 
		return $result;
	}	
	
	public static function getTotalAmount($sale_id=null){
		$obj = ClassRegistry::init('SaleProduct');
		$result = $obj->find('all',array('conditions'=>array('SaleProduct.sale_id'=>$sale_id))); 
		$total_amt = 0;
		if(!empty($result)) {
			foreach($result as $val) {
				$total_amt +=  $val['SaleProduct']['total_amount']; 
			}
		} 
		return $total_amt;
	}	
	
	public static function getTotalInvoiceAmount($invoice_id=null){
		$obj = ClassRegistry::init('InvoiceProduct');
		$result = $obj->find('all',array('conditions'=>array('InvoiceProduct.invoice_id'=>$invoice_id))); 
		$total_amt = 0;
		if(!empty($result)) {
			foreach($result as $val) {
				$total_amt +=  $val['InvoiceProduct']['total_amount']; 
			}
		} 
		return $total_amt;
	}		
	
	public static function getPurchaseTotalAmount($purchase_id=null){
		$obj = ClassRegistry::init('PurchaseProduct');
		$result = $obj->find('all',array('conditions'=>array('PurchaseProduct.purchase_id'=>$purchase_id))); 
		$total_amt = 0;
		if(!empty($result)) {
			foreach($result as $val) {
				$total_amt +=  $val['PurchaseProduct']['total_amount']; 
			}
		} 
		return $total_amt;
	}	
	
	public static function getPurchaseTotalQty($purchase_id=null){
		$obj = ClassRegistry::init('PurchaseProduct');
		$result = $obj->find('all',array('conditions'=>array('PurchaseProduct.purchase_id'=>$purchase_id))); 
		$total_qty = 0;
		if(!empty($result)) {
			foreach($result as $val) {
				$total_qty +=  $val['PurchaseProduct']['qty']; 
			}
		} 
		return $total_qty;
	}	
}