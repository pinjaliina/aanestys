<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
				$errors = array_merge($errors, $this->{$validator}());
      }

      return $errors;
    }
		
		public function validateStrLen($str, $maxlen, $minlen = 0, $name = 'Kentän') {
			if($minlen > 0 && ($str == '' || $str == null || mb_strlen($str, 'UTF-8') < $minlen)) {
				return "$name pituuden tulee olla vähintään $minlen merkkiä.";
			}
			if(mb_strlen($str, 'UTF-8') > $maxlen) {
				return "$name pituuden tulee olla korkeintaan $maxlen merkkiä.";
			}
		}
		
		public static function fmtTime($timestamp){
			// Y-m-d is pretty much mandatory, if we want to use the HTML5 date field,
			// else Google Chrome breaks. This is silly, because in some other
			// browsers a format like 'j.n.Y' would give more readable results.
			// There might be a way around this by using javascript in the view,
			// but I'm not going to investigate that right now.
			return date('Y-m-d', strtotime($timestamp));
		}

  }
