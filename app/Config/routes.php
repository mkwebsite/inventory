<?php
	/* .... Admin URL .....  */
	Router::connect('/', array('admin'=>true, 'controller'=>'admins', 'action'=>'login'));
	Router::connect('/admin', array('admin'=>true, 'controller'=>'admins', 'action'=>'login'));
	
	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';