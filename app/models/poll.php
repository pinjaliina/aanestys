<?php

  class Poll extends BaseModel{
		
		//Attributes
		public $id, $name, $description, $start_time, $end_time;
		
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
