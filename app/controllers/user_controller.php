<?php

	// NOTE: all permission checks are currently missing.
	// We should make sure that the admin attr of the logged in user is true,
  // or otherwise only permit a very limited access.

	class UserController extends BaseController{

		public static function index(){
			self::check_logged_in();
			$user = self::get_user_logged_in();
			if($user->admin) {
				$users = User::findAll();
				View::make('user/index.html', array('users' => $users));
			}
			else {
				Redirect::to('/user/'. $user->id, array('warning' => 'Pääsy kielletty ilman ylläpito-oikeutta!'));			
			}
		}
		
		public static function show($id){
			self::check_logged_in();
			$user = User::findByPK($id);
			$polls = Poll::findByUser($id);
			$nonpolls = Poll::findbyUserNeg($id);
			$objects = array(
				'user' => $user,
				'polls' => $polls,
				'nonpolls' => $nonpolls
			);
			View::make('user/show.html', $objects);
		}

		public static function create(){
			self::check_logged_in();
			$user = self::get_user_logged_in();
			if($user->admin) {
				View::make('user/edit.html');
			}
			else {
				Redirect::to('/user/'. $user->id, array('warning' => 'Pääsy kielletty ilman ylläpito-oikeutta!'));			
			}
		}

		public static function edit($id){
			self::check_logged_in();
			$user = array('user' => User::findByPK($id));
			View::make('user/edit.html', $user);
		}
		
		public static function save(){
			self::check_logged_in();
			$curruser = self::get_user_logged_in();
			// Check that the user is an admin. If the user is aware of the form
			// action URL they could otherwise build a custom form and submit it to
			// create themselves a new account.
			if(!$curruser->admin) {
				Redirect::to('/user/'. $curruser->id, array('warning' => 'Pääsy kielletty ilman ylläpito-oikeutta!'));			
			}
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
			
			$errors = $user->errors();
			if(strcmp($p['password'], $p['confirm']) != 0) {
				$errors[] = "Syötetyt salasanat eivät täsmää.";
			}
			if(count($errors) == 0) {
				$user->save();
				Redirect::to('/user/' . $user->id, array('message' => 'Lisättiin käyttäjä '. $user->login .'.'));
			}
			else {
				View::make('user/edit.html', array('errors' => $errors, 'user' => $user));
			}
		}
		
		public static function update(){
			self::check_logged_in();
			$p = $_POST;
			
			// Set values for any disabled or empty form items and prevent a malicious
			// user from elevating themselves to an admin or editing their login name
			// by manipulating the edit form with debug tools.
			$curruser = self::get_user_logged_in();
			if(!isset($_POST['admin'])) {
				$p['admin'] = 0;
			}
			if(!isset($_POST['login'])) {
				$p['login'] = $curruser->login;
			}
			elseif(!$curruser->admin) {
				if(isset($_POST['login'])) {
					$p['login'] = $curruser->login;
				}
				if(isset($_POST['admin'])) {
					$p['admin'] = 0;
				}
			} 
			
			$user = new User(array(
				'id' => $p['id'],
				'login' => $p['login'],
				'password' => $p['password'],
				'admin' => $p['admin'],
				'name' => $p['name'],
				'email' => $p['email']
			));
			
			$errors = $user->errors();
			if(strlen($p['confirm']) > 0) {
				if(strcmp($p['password'], $p['confirm']) != 0) {
					$errors[] = "Syötetyt salasanat eivät täsmää.";
				}
			}
			else {
				// Password confirmation is zero-length; assume that the current
				// password will not be upgraded.
				unset($user->password);
			}
			if(count($errors) == 0) {
				$user->update();
				Redirect::to('/user/' . $user->id, array('message' => 'Tallennettiin käyttäjä '. $user->login .'.'));
			}
			else {
				View::make('user/edit.html', array('errors' => $errors, 'user' => $user));			
			}
		}
		
		public static function delete($id){
			self::check_logged_in();
			$curruser = self::get_user_logged_in();
			if(!$curruser->admin) {
				Redirect::to('/user/'. $curruser->id, array('warning' => 'Pääsy kielletty ilman ylläpito-oikeutta!'));			
			}
			else if($curruser->id == $id) {
				Redirect::to('/user/'. $curruser->id, array('warning' => 'Et voi poistaa omaa käyttäjätunnustasi!'));							
			}
			$user = new User(array(
				'id' => $id	
			));
			
			$user->delete();
			Redirect::to('/user', array('message' => 'Käyttäjä poistettiin onnistuneesti.'));
		}
		
		public static function login(){
      View::make('user/login.html');
		}

		public static function process_login(){
			$p = $_POST;

			$user = User::authenticate($p['username'], $p['password']);

			if(!$user){
				View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $p['username']));
			}
			else{
				$_SESSION['user'] = $user->id;

				Redirect::to('/', array('message' => 'Tervetuloa takaisin, ' . $user->name . '!'));
			}
		}	
		
	  public static function logout(){
			$_SESSION['user'] = null;
			Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!', 'category' => 'success'));
		}

	}