<?php

  class Poll extends BaseModel{
		
		//Attributes
		// NOTE: in real life the password should be salted and hashed (and the
		// string hidden from the UI), but as that isn't included in the course
		// requirements, I won't implement it.
		public $id, $name, $description, $start_time, $end_time;
		
		//Constructor
		public function __construct($attributes){
			parent::__construct($attributes);
		}
		
		private static function tbl() {
			return DatabaseConfig::PREFIX .'polls';
		}
		
		public static function findAll(){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl());
			$q->execute();
			$rows = $q->fetchAll();
			
			$polls = array();
			foreach($rows as $r) {
				$polls[] = new Poll(array(
						'id' => $r['id'],
						'name' => $r['name'],
						'description' => $r['description'],
						'start_time' => $r['start_time'],
						'end_time' => $r['end_time']
				));
			}
			
			return $polls;
		}
		
		public static function findByPK($id){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array('id' => $id));
			$r = $q->fetch();
			
			if($r) {
				$poll = new Poll(array(
						'id' => $r['id'],
						'name' => $r['name'],
						'description' => $r['description'],
						'start_time' => $r['start_time'],
						'end_time' => $r['end_time']
				));
			}
			
			return $poll;
			
		}
		
		public function save(){
			$q = DB::connection()->prepare('INSERT INTO '. self::tbl() .' (name, description, start_time, end_time) VALUES (:name, :description, :start_time, :end_time) RETURNING id');
			$q->execute(array($this->name, $this->description, $this->start_time, $this->end_time));
			$row = $q->fetch();
			if($row['id']){
				$this->id = $row['id'];
			}
		}
		
		public function update(){
			$q = DB::connection()->prepare('UPDATE '. self::tbl() .' SET (name, description, start_time, end_time)=(:name, :description, :start_time, :end_time) WHERE id = :id');
			$q->execute(array($this->name, $this->description, $this->start_time, $this->end_time, $this->id));
		}
		
		public function delete(){
			$q = DB::connection()->prepare('DELETE FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array($this->id));
		}
	}
