<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */
$routes = array(
	'/' => 'application#index',
	'/index' => 'application#index',
	'/create' => 'application#create',
	'/read' => 'application#read',
	'/update' => 'application#update',
	'/delete' => 'application#delete',
);
