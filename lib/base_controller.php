<?php

  class BaseController{

    public static function get_user_logged_in(){
			if(isset($_SESSION['user'])){
				$id = $_SESSION['user'];
				$user = User::findByPK($id);

				return $user;
			}

			return null;
    }

    public static function check_logged_in(){
			if(!self::get_user_logged_in()) {
				View::make('user/login.html', array('message' => 'Sisäänkirjautuminen vaaditaan.', 'category' => 'warning'));
			}
    }
		
  }
