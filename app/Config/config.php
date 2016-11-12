<?php
$protocol = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
$config['SITE_NAME']     			= "Inventory Management" ;

$siteFolder               			= dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])));
$config['App.SiteUrl'] 				= $protocol .'://'. $_SERVER['HTTP_HOST'] . $siteFolder ;
$config['App.SiteLoc'] 				= $siteFolder;

$config['SITE_EMAIL']  	    		= "rkjangid92@gmail.com";

$config['ROLE_ID']					= array('1'=>'Admin', '2'=>'User');
$config['App.Role.Admin']     	 	= 1;
$config['App.Role.User']   	 		= 2;

$config['App.AdminPageLimit']		= '10';
$config['App.PageLimit']			= '10';
$config['AutosujetionLimit']		= '10';
$config['Status']          			= array('1'=>'Active', '2'=>'Inactive');
$config['App.Status.active'] 		= '1';
$config['App.Status.inactive'] 		= '2';

$config['ProductStatus']          	= array('1'=>'Active', '2'=>'Inactive', '3'=>'Below Minimum Stock Limit', '4'=>'Out of Stock', '5'=>'Deleted');
$config['SalesStatus']          	= array('1'=>'New Order', '2'=>'Packed', '3'=>'Dispached', '4'=>'Delivered', '5'=>'Canceled', '6'=>'Returned');
$config['Salutation']          		= array('1'=>'MR.', '2'=>'Mrs.', '3'=>'Ms.', '4'=>'Miss', '5'=>'Dr.');
$config['TrackAccount']          	= array('1'=>'Inventory Asset');

//All transactions related to the products you sell will be displayed in this account
$config['SalesAccount']        		= array('1'=>'Discount', '2'=>'General Income', '3'=>'Interest Income', '4'=>'Late Fee Income', '5'=>'Other Charges', '6'=>'Sales', '7'=>'Shipping Charges');

//All transactions related to the products you purchase will be displayed in this account
$config['PurchasesAccount']    		= array('1'=>'Cost of Goods Sold', '2'=>'Advertising And Marketing', '3'=>'Automobile Expense', '4'=>'Bad Debt', '5'=>'Bank Fees and Charges', '6'=>'Consultant Expense', '7'=>'Credit Card Charges', '8'=>'Depreciation Expense', '9'=>'IT and Internet Expenses', '10'=>'Janitorial Expense', '11'=>'Loading', '12'=>'Meals and Entertainment', '13'=>'Office Supplies', '14'=>'Other Expenses', '15'=>'Postage', '16'=>'Printing and Stationery', '17'=>'Rent Expense', '18'=>'Repairs and Maintenance', '19'=>'Salaries and Employee Wages', '20'=>'Telephone Expense', '21'=>'Travel Expense', '22'=>'Uncategorized');
