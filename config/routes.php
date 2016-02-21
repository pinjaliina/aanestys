<?php

  $routes->get('/', function() {
    PollController::index();
  });
	
	$routes->get('/login', function() {
		UserController::login();
	});
	
	$routes->get('/user', function() {
		UserController::index();
	});

	$routes->get('/user/new', function() {
		UserController::create();
	});

	$routes->post('/login', function() {
		UserController::process_login();
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
	
	$routes->get('/poll/:id/delete', function($id){
		PollController::delete($id);
	});

	$routes->get('/poll/:id/delete', function($id){
		PollController::delete($id);
	});

	$routes->post('/poll/adduser/:uid', function($uid){
		PollController::addUser($uid);
	});

	$routes->get('/poll/:id/:uid/removeuser', function($id, $uid){
		PollController::removeUser($id, $uid);
	});

  $routes->get('/helloworld', function() {
    HelloWorldController::index();
  });
	
	$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
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
