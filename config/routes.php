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

	$routes->get('/poll', function() {
		PollController::index();
	});

	$routes->get('/poll/new', function() {
		PollController::create();
	});

	$routes->post('/poll/save', function() {
		PollController::save();
	});

	$routes->post('/poll/update', function() {
		PollController::update();
	});

	$routes->get('/poll/:id', function($id) {
		PollController::show($id);
	});

	$routes->get('/poll/:id/edit', function($id) {
		PollController::edit($id);
	});
	
	/* Disable the delete route for now, as it doesn't yet handle any tables with
	 * referential integrity restrictions intelligently. We don't really want
	 * the course assistants to mess with it.
	$routes->get('/poll/:id/delete', function($id){
		PollController::delete($id);
	});*/

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
