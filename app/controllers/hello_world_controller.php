<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
			echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      //echo 'Hello World!';
			View::make('helloworld.html');
    }
		
		public static function login(){
			// Login page
			View::make('designs/login.html');
		}
		
		public static function poll_list(){
			// List polls (and a list demo page)
			View::make('designs/poll_list.html');
		}

		public static function poll_manage_options(){
			// Manage a poll (and a show/edit demo page)
			View::make('designs/poll_manage_options.html');
		}
}
