<?php

  class PollOption extends BaseModel{
		
		//Attributes
		// NOTE: in real life the password should be salted and hashed (and the
		// string hidden from the UI), but as that isn't included in the course
		// requirements, I won't implement it.
		public $id, $polls_id, $name, $description;
		
		//Constructor
		public function __construct($attributes){
			parent::__construct($attributes);
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
			$q->execute(array($this->polls_id));
		}
	}
