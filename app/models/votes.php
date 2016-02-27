<?php

  class Vote extends BaseModel{
		
		//Attributes. $users_id is a temporary attribute and not in the DB schema for this model.
		public $id, $polls_id, $poll_options_id, $time, $users_id;
		
		//Constructor
		public function __construct($attributes){
			parent::__construct($attributes);
		}
		
		private static function tbl($tblname = 'votes') {
			return DatabaseConfig::PREFIX . $tblname;
		}

		public static function findByPollId($polls_id){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE polls_id = :polls_id');
			$q->execute(array('polls_id' => $polls_id));
			$rows = $q->fetchAll();
			
			$votes = array();
			foreach($rows as $r) {
				$votes[] = new Vote(array(
						'id' => $r['id'],
						'polls_id' => $r['polls_id'],
						'poll_options_id' => $r['poll_options_id'],
						'time' => $r['time']
				));
			}
			
			return $votes;
		}
		
		public static function findByPollIdAndOptionId($polls_id, $poll_options_id){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE polls_id = :polls_id AND poll_options_id = :poll_options_id');
			$q->execute(array('polls_id' => $polls_id, 'poll_options_id' => $poll_options_id));
			$rows = $q->fetchAll();
			
			$votes = array();
			foreach($rows as $r) {
				$votes[] = new Vote(array(
						'id' => $r['id'],
						'polls_id' => $r['polls_id'],
						'poll_options_id' => $r['poll_options_id'],
						'time' => $r['time']
				));
			}
			
			return $votes;
		}
		
		public static function findByPK($id){
			$q = DB::connection()->prepare('SELECT * FROM '. self::tbl() .' WHERE id = :id');
			$q->execute(array('id' => $id));
			$r = $q->fetch();
			
			if($r) {
				$vote = new Vote(array(
						'id' => $r['id'],
						'polls_id' => $r['polls_id'],
						'poll_options_id' => $r['poll_options_id'],
						'time' => $r['time']
				));
			}
			
			return $vote;
			
		}
		
		public function save(){
			if($this->users_id) {				
				$q = DB::connection()->prepare('INSERT INTO '. self::tbl() .' (polls_id, poll_options_id, time) VALUES (:polls_id, :poll_options_id, :time) RETURNING id');
				$q->execute(array($this->polls_id, $this->poll_options_id, $this->time));
				$row = $q->fetch();
				if($row['id']){
					$this->id = $row['id'];
				}
				// Upon saving the vote expire the users permission to vote in this poll.
				// NOTE: the vote itself can't be connected to the user past this point.
				$q2 = DB::connection()->prepare('UPDATE '. self::tbl('users_polls') .' SET voted=TRUE WHERE voted=FALSE AND users_id=:users_id AND polls_id=:polls_id');
				$q2->execute(array('users_id' => $this->users_id, 'polls_id' => $this->polls_id));
			}
		}
		
		public function update(){
			$q = DB::connection()->prepare('UPDATE '. self::tbl() .' SET (polls_id, poll_options_id, time)=(:polls_id, :poll_options_id, :time) WHERE id = :id');
			$q->execute(array($this->polls_id, $this->poll_options_id, $this->time, $this->id));
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
