<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });
	
	$routes->get('/user', function() {
		UserController::index();
	});

	$routes->get('/user/new', function() {
		UserController::create();
	});

	$routes->post('/user/save', function() {
		UserController::save();
	});

	$routes->post('/user/update', function() {
		UserController::update();
	});

	$routes->get('/user/:id', function($id) {
		UserController::show($id);
	});

	$routes->get('/user/:id/edit', function($id) {
		UserController::edit($id);
	});
	
	$routes->get('/user/:id/delete', function($id){
		UserController::delete($id);
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
