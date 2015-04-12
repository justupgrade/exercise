<?php
/*
 * Ankieta:
-Ma posiadać własną nazwę, unikatowy link.
- Ma implementować metody: zwracającą pytań dla danej ankiety, zwracanie nazwy,
zmiana nazwy, zapisanie zmian do bazy danych.
- Ma implementować statyczne metody: stworzenie nowej ankiety, wczytanie ankiety
o podanym id z bazy danych, usunięcie ankiety o podanym id z bazy danych.
 */
	require_once "DatabaseObject.php";

	class Poll extends DatabaseObject {
		static private $connection;
		private $name;
		private $link; //http link or what is that? =D 
		
		protected function __construct($id,$name,$link) {
			parent::__construct($id);
			$this->name = $name;
			$this->link = $link;
		}
		
		public function getAllQuestions() {
			$query = "SELECT questions.id as questionsID, questions.text as questionsText FROM questions ";
			$query .= "JOIN polls_questions ON questions.id=polls_questions.questionID ";
			$query .= "WHERE polls_questions.pollID=" . $this->id;
			
			$result = self::$connection->query($query);
			if($result && $result->num_rows > 0) {
				$questions = array();
				while($row = $result->fetch_assoc()){
					$questions[] = $row;
				}
				return $questions;
			}
			
			return null;
		}
		
		
		public function getName() {
			return $this->name;
		}
		
		public function getPollLink() {
			return $this->link;
		}
		
		public function setName($newName) {
			$this->name = $newName;
			//?save to db?
		}
		
		//returns true or false
		public function saveToDb() {
			$query = "UPDATE polls SET name='" . $this->name . "' WHERE id=" . $this->id;
			return self::$connection->query($query);
		}
		
		//------------------ STATIC functions ---------------
		static public function SetUpConnection($conn) {
			self::$connection = $conn;
		}
		//returns created Poll() or null
		static public function CreateNewPoll($name,$link){
			if(!$name || !$link) return null; //MY DB ALLOWS TO INSERT NULL in NOT NULL COLUMNS!!!
			
			$query = "INSERT INTO polls (name,link) VALUES (";
			$query .= "'" . $name . "',";
			$query .= "'" . $link . "')";
			
			if(self::$connection->query($query)) 
				return new Poll(self::$connection->insert_id, $name,$link);
			
			return null; 
		}
		
		//returns Poll() or null
		static public function LoadPoll($id) {
			$query = "SELECT * FROM polls WHERE id=" . $id;
			$result = self::$connection->query($query);
			
			if($result && $result->num_rows > 0) { //expecting exactly 1 row
				$row = $result->fetch_assoc();
				return new Poll($id, $row['name'], $row['link']);
			}
			
			return null;
		}
		
		//returns true if successfull false if error
		static public function DeletePoll($id) {
			$query = "DELETE FROM polls WHERE id=" . $id . " LIMIT 1";
			
			self::$connection->query($query);
			
			return mysqli_affected_rows(self::$connection);
		}
		
	}
	
?>