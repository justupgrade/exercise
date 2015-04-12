<?php
	abstract class DatabaseObject {
		protected $id;
		
		protected function __construct($id) {
			$this->id = $id;
		}
		
		abstract static public function SetUpConnection($conn);
		
		public function getID(){
			return $this->id;
		}
	}
?>