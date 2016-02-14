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
      }

      return $errors;
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
