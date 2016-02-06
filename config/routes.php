<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
	
	$routes->get('/user', function() {
		UserController::index();
	});

	$routes->get('/user:id', function($id) {
		UserController::index($id);
	});

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
	
	$routes->get('/login', function() {
		HelloWorldController::login();
	});

	$routes->get('/poll_list', function() {
		HelloWorldController::poll_list();
	});

	$routes->get('/poll_show', function() {
		HelloWorldController::poll_show();
	});
	
	$routes->get('/poll_edit', function() {
		HelloWorldController::poll_edit();
	});
