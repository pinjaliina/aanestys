<?php

  class User extends BaseModel{
		
		//Attributes
		// NOTE: in real life the password should be salted and hashed (and the
		// string hidden from the UI), but as that isn't included in the course
		// requirements, I won't implement it.
		public $id, $login, $password, $admin, $name, $email;
		
		//Constructor
		public function __construct($attributes){
			parent::__construct($attributes);
			$this->validators = array('validate_login', 'validate_password', 'validate_name', 'validate_email');
		}
		
		public function validate_login(){
			// FIXME: We should check whether the login name already exists and add
			// an error if it does to avoid the much uglier "violation of unique
			// constraint" SQL error. Issue #4.
			$errors = array();
			$nameErr = $this->validateStrLen($this->login, 15, 3, 'Käyttäjätunnuksen');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}

		public function validate_password(){
			$errors = array();
			$nameErr = $this->validateStrLen($this->password, 20, 6, 'Salasanan');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}
		
		public function validate_name(){
			$errors = array();
			$nameErr = $this->validateStrLen($this->name, 40, 5, 'Koko nimen');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}
		
		public function validate_email(){
			// FIXME: we could do some smart email address validation besides just
			// checking for its length. But I'm in too much hurry to write that regex
			// right now.
			$errors = array();
			$nameErr = $this->validateStrLen($this->email, 40, 5, 'Sähköpostiosoitteen');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}
		
		private static function tbl() {
			return DatabaseConfig::PREFIX .'users';
		}
		
		public static function authenticate($login, $password){
			$user = self::findByLoginName($login);
			if($user) {
				if($password == $user->password) {
					return $user;
				}
			}
		}

		public static function findAll(){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl());
			$q->execute();
			$rows = $q->fetchAll();
			
			$users = array();
			foreach($rows as $r) {
				$users[] = new User(array(
						'id' => $r['id'],
						'login' => $r['login'],
						'password' => $r['password'],
						'admin' => $r['admin'],
						'name' => $r['name'],
						'email' => $r['email']
				));
			}
			
			return $users;
		}
		
		public static function findByPK($id){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array('id' => $id));
			$r = $q->fetch();
			
			if($r) {
				$user = new User(array(
						'id' => $r['id'],
						'login' => $r['login'],
						'password' => $r['password'],
						'admin' => $r['admin'],
						'name' => $r['name'],
						'email' => $r['email']
				));
			}
			
			return $user;			
		}
		
		public static function findByLoginName($login){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE login = :login');
			$q->execute(array('login' => $login));
			$r = $q->fetch();
			
			if($r) {
				$user = new User(array(
						'id' => $r['id'],
						'login' => $r['login'],
						'password' => $r['password'],
						'admin' => $r['admin'],
						'name' => $r['name'],
						'email' => $r['email']
				));
			}
			
			if(isset($user)) {
				return $user;
			}
		}
		
		public function save(){
			$q = DB::connection()->prepare('INSERT INTO '. self::tbl() .' (login, password, admin, name, email) VALUES (:login, :password, :admin, :name, :email) RETURNING id');
			$q->execute(array($this->login, $this->password, $this->admin, $this->name, $this->email));
			$row = $q->fetch();
			if($row['id']){
				$this->id = $row['id'];
			}
		}
		
		public function update(){
			if(isset($this->password) && strlen($this->password) != 0) {
				$q = DB::connection()->prepare('UPDATE '. self::tbl() .' SET (login, password, admin, name, email)=(:login, :password, :admin, :name, :email) WHERE id = :id');
				$q->execute(array($this->login, $this->password, $this->admin, $this->name, $this->email, $this->id));
			}
			else { // Don't update password if it is zero-length.
				$q = DB::connection()->prepare('UPDATE '. self::tbl() .' SET (login, admin, name, email)=(:login, :admin, :name, :email) WHERE id = :id');
				$q->execute(array($this->login, $this->admin, $this->name, $this->email, $this->id));			
			}
		}
		
		public function delete(){
			$q = DB::connection()->prepare('DELETE FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array($this->id));
		}
	}
