<?php

  $routes->get('/', function() {
    HelloWorldController::index();
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

	$routes->get('/poll_manage_options', function() {
		HelloWorldController::poll_manage_options();
	});
