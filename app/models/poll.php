<?php

  class Poll extends BaseModel{
		
		//Attributes. $voted is a temporary attribute and not in the DB schema.
		public $id, $name, $description, $start_time, $end_time, $voted;
		
		//Constructor
		public function __construct($attributes){
			parent::__construct($attributes);
			$this->validators = array('validate_name', 'validate_description', 'validate_start_time', 'validate_end_time');
	}
		
		public function validate_name(){
			$errors = array();
			$nameErr = $this->validateStrLen($this->name, 20, 3, 'Äänestyksen nimen');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}
		
		public function validate_description(){
			$errors = array();
			$nameErr = $this->validateStrLen($this->description, 100, 0, 'Äänestyksen kuvauksen');
			if(isset($nameErr)){
				$errors[] = $nameErr;
			}
			return $errors;
		}
		
		public function validate_start_time(){
			$errors = array();
			$check = date_parse_from_format('Y-m-d', $this->start_time);
			$formErr = '';
			if($check['warning_count'] > 0 || $check['error_count'] > 0) {
				$formErr = 'Aloitusaika tulee syöttää muodossa VVVV-KK-PP.';
			}
			else {
				unset($formErr);
			}
			if(isset($formErr)){
				$errors[] = $formErr;
			}
			return $errors;
		}
		
		public function validate_end_time(){
			$errors = array();
			$check = date_parse_from_format('Y-m-d', $this->end_time);
			$formErr = '';
			if($check['warning_count'] > 0 || $check['error_count'] > 0) {
				$formErr = 'Päättymisaika tulee syöttää muodossa VVVV-KK-PP.';
			}
			if(!empty($formErr)){
				$errors[] = $formErr;
			}
			$logicErr = '';
			if(!$this->validate_start_time() && empty($formErr)) {
				$start = new DateTime($this->start_time);
				$end = new DateTime($this->end_time);
				if($start >= $end) {
					$logicErr = 'Aloitusajan tulee olla ennen päättymisaikaa.';
				}
			}
			if(!empty($logicErr)){
				$errors = $logicErr;
			}
			return $errors;
		}
		
		private static function tbl($tblname = 'polls') {
			return DatabaseConfig::PREFIX . $tblname;
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
						'start_time' => self::fmtTime($r['start_time']),
						'end_time' => self::fmtTime($r['end_time'])
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
						'start_time' => self::fmtTime($r['start_time']),
						'end_time' => self::fmtTime($r['end_time'])
				));
			}
			
			return $poll;
			
		}
		
		public static function findByUser($users_id) {
			$sql = 'SELECT p.* FROM ' . self::tbl() . ' p INNER JOIN '. self::tbl('users_polls') .' up ON p.id = up.polls_id AND up.users_id = :users_id';
			$q = DB::connection()->prepare($sql);
			$q->execute(array('users_id' => $users_id));
			$rows = $q->fetchAll();
			
			$polls = array();
			foreach($rows as $r) {
				$polls[] = new Poll(array(
						'id' => $r['id'],
						'name' => $r['name'],
						'description' => $r['description'],
						'start_time' => self::fmtTime($r['start_time']),
						'end_time' => self::fmtTime($r['end_time']),
						'voted' => self::checkVoteStatus($users_id, $r['id'])
				));
			}
			
			return $polls;			
		}

		public static function findByUserNeg($users_id) {
			$sql = 'SELECT DISTINCT p.* FROM ' . self::tbl() . ' p LEFT JOIN '. self::tbl('users_polls') .' up ON p.id = up.polls_id AND up.users_id = :users_id LEFT JOIN '. self::tbl('users_polls') .' up2 ON p.id=up2.polls_id and up2.users_id <> :users_id WHERE up.users_id IS NULL';
			$q = DB::connection()->prepare($sql);
			$q->execute(array('users_id' => $users_id));
			$rows = $q->fetchAll();
			
			$polls = array();
			foreach($rows as $r) {
				$polls[] = new Poll(array(
						'id' => $r['id'],
						'name' => $r['name'],
						'description' => $r['description'],
						'start_time' => self::fmtTime($r['start_time']),
						'end_time' => self::fmtTime($r['end_time'])
				));
			}
			
			return $polls;			
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
		
		public function addUser($users_id){
			$q = DB::connection()->prepare('INSERT INTO '. self::tbl('users_polls') .' (polls_id, users_id) VALUES (:polls_id, :users_id)');
			$q->execute(array($this->id, $users_id));			
		}
		
		public function removeUser($users_id){
			$q = DB::connection()->prepare('DELETE FROM '. self::tbl('users_polls') .' WHERE polls_id = :polls_id AND users_id = :users_id');
			$q->execute(array($this->id, $users_id));			
		}
					
		public static function checkVoteStatus($users_id, $polls_id){
			$sql = 'SELECT voted FROM '. self::tbl('users_polls') .' WHERE users_id = :users_id AND polls_id = :polls_id';
			$q = DB::connection()->prepare($sql);
			$q->execute(array('users_id' => $users_id, 'polls_id' => $polls_id));
			$r = $q->fetch();
			if($r) {
				return $r['voted']; //This returns TRUE or FALSE.
			}
			// If $users_id has no right to vote in this poll at all, return NULL--not
			// FALSE--and keep this function public. This is useful in the controller.
			else {
				return NULL;
			}
		}
			
		private function getEligibleVotersCount(){
			$sql = 'SELECT COUNT(*) FROM '. self::tbl('users_polls') .' WHERE polls_id = :polls_id';
			$q = DB::connection()->prepare($sql);
			$q->execute(array('polls_id' => $this->id));
			$r = $q->fetch();
			if($r) {
				return $r['count'];
			}
			else {
				return 0;
			}
		}
		
		private static function cmpVoteCount($a, $b){
			return $b['vote_count'] - $a['vote_count'];
		}

		// Find all the results in a poll and build and associative array out of them;
		public function getResults() {
 			$r = array(
				'id' => $this->id,
				'name' => $this->name,
				'eligible_count' => $this->getEligibleVotersCount(),
				'vote_count' => 0,
				'turnout' => 0.0,
				'options' => array()
			);
			$options = PollOption::findByPollId($this->id);
			foreach($options as $option) {
				$r['options'][$option->id] = array(
					'id' => $option->id,
					'name' => $option->name,
					'vote_count' => 0
				);
				$votes = Vote::findByPollIdAndOptionId($this->id, $option->id);
				foreach($votes as $vote) {
					++$r['vote_count'];				
					++$r['options'][$option->id]['vote_count'];				
				}
				$r['options'][$option->id]['percentage'] = $r['eligible_count'] > 0 ? round(($r['options'][$option->id]['vote_count']/$r['eligible_count'])*100) : 0;
			}
			$r['turnout'] = $r['eligible_count'] > 0 ? round(($r['vote_count']/$r['eligible_count'])*100) : 0;
			uasort($r['options'], "self::cmpVoteCount");
			
			return $r;
		}

	}
