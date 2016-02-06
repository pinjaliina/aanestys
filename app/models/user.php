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
		}
		
		private static function tbl() {
			return DatabaseConfig::PREFIX .'users';
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
		
		public function save(){
			$q = DB::connection()->prepare('INSERT INTO '. self::tbl() .' (login, password, admin, name, email) VALUES (:login, :password, :admin, :name, :email) RETURNING id');
			$q->execute(array($this->login, $this->password, $this->admin, $this->name, $this->email));
			$row = $q->fetch();
			if($row['id']){
				$this->id = $row['id'];
			}
		}
		
		public function update(){
			$q = DB::connection()->prepare('UPDATE '. self::tbl() .' SET (login, password, admin, name, email)=(:login, :password, :admin, :name, :email) WHERE id = :id');
			$q->execute(array($this->login, $this->password, $this->admin, $this->name, $this->email, $this->id));
		}
		
		public function delete(){
			$q = DB::connection()->prepare('DELETE FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array($this->id));
		}
	}
