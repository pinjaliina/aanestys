<?php

	// NOTE: all permission checks are currently missing.
	// We should make sure that the admin attr of the logged in user is true,
  // or otherwise only permit a very limited access.

	class UserController extends BaseController{

		public static function index(){
			$users = User::findAll();
			View::make('user/index.html', array('users' => $users));
		}
		
		public static function show($id){
			$user = array('user' => User::findByPK($id));
			View::make('user/show.html', $user);
		}

		public static function create(){
			View::make('user/edit.html');
		}

		public static function edit($id){
			$user = array('user' => User::findByPK($id));
			View::make('user/edit.html', $user);
		}
		
		public static function save(){
			$p = $_POST;
			
			if(!isset($_POST['admin'])) {
				$p['admin'] = 0;
			}
			
			$user = new User(array(
				'login' => $p['login'],
				'password' => $p['password'],
				'admin' => $p['admin'],
				'name' => $p['name'],
				'email' => $p['email']
			));
			
			$user->save();
			
			Redirect::to('/user/' . $user->id, array('message' => 'Lisättiin käyttäjä '. $user->login .'.'));
		}
		
		public static function update(){
			$p = $_POST;
			
			if(!isset($_POST['admin'])) {
				$p['admin'] = 0;
			}
			
			$user = new User(array(
				'id' => $p['id'],
				'login' => $p['login'],
				'password' => $p['password'],
				'admin' => $p['admin'],
				'name' => $p['name'],
				'email' => $p['email']
			));
			
			$user->update();
			
			Redirect::to('/user/' . $user->id, array('message' => 'Tallennettiin käyttäjä '. $user->login .'.'));
		}
		
		public static function delete($id){
			$user = new User(array(
				'id' => $id	
			));
			
			$user->delete();
			Redirect::to('/user', array('message' => 'Käyttäjä poistettiin onnistuneesti.'));
		}
		
	}