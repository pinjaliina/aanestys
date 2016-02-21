<?php

  class PollOption extends BaseModel{
		
		//Attributes
		public $id, $polls_id, $name, $description;
		
		//Constructor
		public function __construct($attributes){
			parent::__construct($attributes);
			$this->validators = array('validate_name', 'validate_description');
		}
		
		public function validate_name(){
			$errors = array();
			$nameErr = $this->validateStrLen($this->name, 20, 1, 'Vaihtoehdon nimen');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}
		
		public function validate_description(){
			$errors = array();
			$nameErr = $this->validateStrLen($this->description, 100, 0, 'Vaihtoehdon kuvauksen');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}
		
		private static function tbl() {
			return DatabaseConfig::PREFIX .'poll_options';
		}
		
		public static function findByPollId($polls_id){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE polls_id = :polls_id');
			$q->execute(array('polls_id' => $polls_id));
			$rows = $q->fetchAll();
			
			$polloptions = array();
			foreach($rows as $r) {
				$polloptions[] = new PollOption(array(
						'id' => $r['id'],
						'polls_id' => $r['polls_id'],
						'name' => $r['name'],
						'description' => $r['description']
				));
			}
			
			return $polloptions;
		}
		
		public static function findByPK($id){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array('id' => $id));
			$r = $q->fetch();
			
			if($r) {
				$polloption = new PollOption(array(
						'id' => $r['id'],
						'polls_id' => $r['polls_id'],
						'name' => $r['name'],
						'description' => $r['description']
				));
			}
			
			return $polloption;
			
		}
		
		public function save(){
			$q = DB::connection()->prepare('INSERT INTO '. self::tbl() .' (polls_id, name, description) VALUES (:polls_id, :name, :description) RETURNING id');
			$q->execute(array($this->polls_id, $this->name, $this->description));
			$row = $q->fetch();
			if($row['id']){
				$this->id = $row['id'];
			}
		}
		
		public function update(){
			$q = DB::connection()->prepare('UPDATE '. self::tbl() .' SET (polls_id, name, description)=(:polls_id, :name, :description) WHERE id = :id');
			$q->execute(array($this->polls_id, $this->name, $this->description, $this->id));
		}
		
		public function delete(){
			$q = DB::connection()->prepare('DELETE FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array($this->id));
		}

		public function deleteByPollId(){
			$q = DB::connection()->prepare('DELETE FROM '. self::tbl() .' WHERE polls_id = :polls_id');
			$q->execute(array($this->pollid));
		}
	}
