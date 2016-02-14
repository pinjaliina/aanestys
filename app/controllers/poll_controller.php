<?php

	// NOTE: all permission checks are currently missing.
	// We should make sure that the admin attr of the logged in user is true,
  // or otherwise only permit a very limited access.

	class PollController extends BaseController{

		public static function index(){
			$polls = Poll::findAll();
			View::make('poll/index.html', array('polls' => $polls));
		}
		
		public static function show($id){
			$poll = array('poll' => Poll::findByPK($id), 'polloptions' => PollOption::findByPollId($id));
			View::make('poll/show.html', $poll);
		}

		public static function create(){
			View::make('poll/edit.html');
		}

		public static function edit($id){
			$poll = array('poll' => Poll::findByPK($id), 'polloptions' => PollOption::findByPollId($id));
			View::make('poll/edit.html', $poll);
		}
		
		public static function save(){
			$p = $_POST;
			
			$poll = new Poll(array(
				'name' => $p['name'],
				'description' => $p['description'],
				'start_time' => $p['start_time'],
				'end_time' => $p['end_time']
			));
			
			// Search the input array for Option model attributes and build an array
			// out of them:
			$poll_options = array();
			$matching_keys = array();
			foreach($p as $key => $value){
				$matches = array();
				if (preg_match("/^option_name_new_([0-9]+)$/", $key, $matches)) {
					// This works. I'll commit here and continue sometime later to
					// fullfill the stupid course schedule requirements about doing input
					// validators first. But we should be able to pickup any submitted
					// Option model attributes with a relative ease and then save them
					// separately. Ditto for self::update().
					Kint::dump($matches);
				}
			}
			
			Kint::dump($p);
			//$poll->save();
			//Redirect::to('/poll/' . $poll->id, array('message' => 'Lisättiin uusi äänestys '. $poll->name .'.'));
		}
		
		public static function update(){
			$p = $_POST;
			
			$poll = new Poll(array(
				'id' => $p['id'],
				'name' => $p['name'],
				'description' => $p['description'],
				'start_time' => $p['start_time'],
				'end_time' => $p['end_time']
			));
			
			Kint::dump($p);
			//$poll->update();
			//Redirect::to('/poll/' . $poll->id, array('message' => 'Tallennettiin äänestys '. $poll->name .'.'));
		}
		
		public static function delete($id){
			$poll = new Poll(array(
				'id' => $id	
			));
			
			$poll->delete();
			Redirect::to('/poll', array('message' => 'Äänestys poistettiin onnistuneesti.'));
		}
		
	}