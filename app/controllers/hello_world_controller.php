<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  //View::make('home.html');
			echo 'Koodi on työn alla. Kts. <a href="/aanestys/hiekkalaatikko">hiekkalaatikko</a>.';
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

		public static function poll_show(){
			// View a single poll (and an show demo page)
			View::make('designs/poll_show.html');
		}
		
		public static function poll_edit(){
			// Manage a poll (and an edit demo page)
			View::make('designs/poll_edit.html');
		}
}
