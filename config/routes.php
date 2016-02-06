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

	$routes->get('/poll_show', function() {
		HelloWorldController::poll_show();
	});
	
	$routes->get('/poll_edit', function() {
		HelloWorldController::poll_edit();
	});
