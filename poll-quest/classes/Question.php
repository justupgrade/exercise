<?php
/*
 * Pytanie:
 -Ma posiadać tekst pytania.
 -Ma implementować metody: zwracającą wszystkie udzielone odpowiedzi na to
pytanie, zmieniające tekst pytania, zwracające tekst pytania, zapamiętujące pytanie
do bazy danych.
 -Ma implementować statyczne metody: stworzenie nowego pytania (potrzebuje
podania id ankiety), wczytanie pytania o podanym id z bazy danych, usunięcie pytania
o podanym id z bazy danych.
 */
	require_once "DatabaseObject.php";

	class Question extends DatabaseObject{
		static private $connection;
		private $text;
		private $pollID; //what for? will be useful in future?
		
		protected function __construct($id,$text,$pollID) {
			parent::__construct($id);
			$this->text = $text;
			$this->pollID = $pollID;
		}
		
		public function getAllResponses() {
			$query = "SELECT * FROM responses WHERE questionID=" . $this->id;
			$result = self::$connection->query($query);
			if($result && $result->num_rows > 0){
				$responses = array();
				while($row = $result->fetch_assoc()) {
					$responses[] = $row;
				}
				return $responses;
			}
			
			return null;
		}
		
		public function getPollID() {
			return $this->pollID;
		}
		
		public function setText($text){
			$this->text = $text;
		}
		
		public function getText(){
			return $this->text;
		}
		
		public function saveToDb() {
			$query = "UPDATE questions SET text='" . $this->text . "' WHERE id=" . $this->id;
			
			return self::$connection->query($query);
		} 
		
		//--------------- STATIC FUNCTIONS -----------------
		static public function SetUpConnection($conn) {
			self::$connection = $conn;
		}
		
		static public function CreateNewQuestion($pollID, $text) {
			if(!$pollID || !$text) return null;
			
			$query = "INSERT INTO questions (text) VALUES (";
			$query .= "'" . $text . "')";
			
			if(self::$connection->query($query)) {
				$questionID = self::$connection->insert_id;
				$subquery = "INSERT INTO polls_questions (pollID, questionID) VALUES (";
				$subquery .= $pollID . ", " . $questionID . ")";
				
				if(self::$connection->query($subquery)) return new Question($questionID, $text, $pollID);
			}
			
			return null;
		}
		
		static public function LoadQuestion($id) {
			$query = "SELECT * FROM questions WHERE id=" . $id;
			
			$result = self::$connection->query($query);
			if($result && $result->num_rows > 0) {
				return new Question($id, $result->fetch_assoc()['text'], null);
			}
			
			return null;
		}
		
		static public function DeleteQuestion($id) {
			$query = "DELETE FROM questions WHERE id=" . $id;
			self::$connection->query($query);
			
			return mysqli_affected_rows(self::$connection);
		}
	}

?>