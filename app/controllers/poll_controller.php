<?php

	// NOTE: all permission checks are currently missing.
	// We should make sure that the admin attr of the logged in user is true,
  // or otherwise only permit a very limited access.

	class PollController extends BaseController{

		public static function index(){
			self::check_logged_in();
			$polls = Poll::findAll();
			View::make('poll/index.html', array('polls' => $polls));
		}
		
		public static function show($id){
			self::check_logged_in();
			$poll = array('poll' => Poll::findByPK($id), 'polloptions' => PollOption::findByPollId($id));
			View::make('poll/show.html', $poll);
		}

		public static function create(){
			self::check_logged_in();
			View::make('poll/edit.html');
		}

		public static function edit($id){
			self::check_logged_in();
			$poll = array('poll' => Poll::findByPK($id), 'polloptions' => PollOption::findByPollId($id));
			View::make('poll/edit.html', $poll);
		}
		
		public static function save(){
			self::check_logged_in();
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
			foreach($p as $key => $value){
				$matches = array();
				if (preg_match("/^option_name_new_([0-9]+)$/", $key, $matches)) {
					$poll_options[$matches[1]]['name'] = $p[$matches[0]];
					$poll_options[$matches[1]]['description'] = $p['option_description_new_'. $matches[1]];
				}
			}
			
			$errors = $poll->errors();
			
			$polloptions = array();
			if(count($errors) == 0) {			
				$poll->save();
				if($poll->id) {
					foreach($poll_options as $option) {
						$polloption = new PollOption(array(
							'polls_id' => $poll->id,
							'name' => $option['name'],
							'description' => $option['description']	
						));
						$errors = $polloption->errors();
						if(count($errors) == 0) {
							$polloption->save();
						}
						else {
							$polloptions[] = $polloption;
						}
					}
				}

				if(empty($polloptions)) {
					Redirect::to('/poll/' . $poll->id, array('message' => 'Lisättiin uusi äänestys '. $poll->name .'.'));
				}
				else { // The poll was saved successfully but options weren't. Edit the poll.
					$errors[] = 'Lisättiin uusi äänestys '. $poll->name .', mutta äänestyksen vaihtoehtoja ei saatu tallennettua. Tarkista virheet';
					View::make('poll/edit.html', array('errors' => $errors, 'poll' => $poll, 'polloptions' => $polloptions));
				}
			}
			else { // The actual poll wasn't saved.
				foreach($poll_options as $option) { // We don't have the poll id.
					$polloption = new PollOption(array(
						'name' => $option['name'],
						'description' => $option['description']	
					));
					$optionerrors = $polloption->errors();
					if(!empty($optionerrors)) {
						$errors = array_merge($errors, $optionerrors);
					}
					$polloptions[] = $polloption;
				}
				View::make('poll/edit.html', array('errors' => $errors, 'poll' => $poll, 'polloptions' => $polloptions));
			}
		}
		
		public static function update(){
			self::check_logged_in();
			$p = $_POST;
			
			$poll = new Poll(array(
				'id' => $p['id'],
				'name' => $p['name'],
				'description' => $p['description'],
				'start_time' => $p['start_time'],
				'end_time' => $p['end_time']
			));
			
			// Search the input array for Option model attributes and build an array
			// out of them:
			$poll_options = array();
			foreach($p as $key => $value){
				$matches = array();
				if (preg_match("/^option_name_([0-9]+)$/", $key, $matches)) {
					$poll_options[$matches[1]]['id'] = $p['option_'. $matches[1]];
					$poll_options[$matches[1]]['name'] = $p[$matches[0]];
					$poll_options[$matches[1]]['description'] = $p['option_description_'. $matches[1]];
				}
				// Even though we've decided to not support adding new options to
				// existing polls, we still need this to handle situations where a new
				// poll was saved succesfully but its options werent.
				else if (preg_match("/^option_name_new_([0-9]+)$/", $key, $matches)) {
					$poll_options[$matches[1]]['name'] = $p[$matches[0]];
					$poll_options[$matches[1]]['description'] = $p['option_description_new_'. $matches[1]];
				}
			}
			
			$errors = $poll->errors();
			
			$polloptions = array();
			if(count($errors) == 0) {			
				$poll->update();

				foreach($poll_options as $option) {
					$polloption = new PollOption(array(
						'polls_id' => $poll->id,
						'name' => $option['name'],
						'description' => $option['description']	
					));
					$errors = $polloption->errors();
					if(count($errors) == 0) {
						if(isset($option['id'])) {
							$polloption->id = $option['id'];
							$polloption->update();										
						}
						else {
							$polloption->save();					
						}
					}
					else {
						$polloptions[] = $polloption;						
					}
				}
				if(empty($polloptions)) {
					Redirect::to('/poll/' . $poll->id, array('message' => 'Tallennettiin äänestys '. $poll->name .'.'));
				}
				else { // The poll was saved successfully but options weren't. Edit the poll.
					$errors[] = 'Tallennettiin äänestys '. $poll->name .', mutta äänestyksen vaihtoehtoja ei saatu tallennettua. Tarkista virheet';
					View::make('poll/edit.html', array('errors' => $errors, 'poll' => $poll, 'polloptions' => $polloptions));
				}
			}
			else { // The actual poll wasn't saved.
				foreach($poll_options as $option) {
					$polloption = new PollOption(array(
						'polls_id' => $poll->id,
						'name' => $option['name'],
						'description' => $option['description']	
					));
					if(isset($option['id'])) {
						$polloption->id = $option['id'];
					}
					$optionerrors = $polloption->errors();
					if(!empty($optionerrors)) {
						$errors = array_merge($errors, $optionerrors);
					}
					$polloptions[] = $polloption;
				}
				View::make('poll/edit.html', array('errors' => $errors, 'poll' => $poll, 'polloptions' => $polloptions));
			}

		}
		
		public static function delete($id){
			self::check_logged_in();
			$poll = new Poll(array(
				'id' => $id	
			));
			
			$poll->delete();
			Redirect::to('/poll', array('message' => 'Äänestys poistettiin onnistuneesti.'));
		}
		
		public static function addUser($users_id){
			self::check_logged_in();
			
			$p = $_POST;

			$poll = Poll::findByPK($p['poll']);
			$user = User::findByPK($users_id);
			
			$poll->addUser($user->id);
			Redirect::to('/user/'. $users_id, array('message' => 'Käyttäjä '. $user->login .' lisättiin onnistuneesti äänestykseen '. $poll->name .'.'));
		}

		public static function removeUser($polls_id, $users_id){
			self::check_logged_in();
			$poll = Poll::findByPK($polls_id);
			$user = User::findByPK($users_id);
			
			$poll->removeUser($user->id);
			Redirect::to('/user/'. $users_id, array('message' => 'Käyttäjä '. $user->login .' poistettiin onnistuneesti äänestyksestä '. $poll->name .'.'));
		}
		
	}