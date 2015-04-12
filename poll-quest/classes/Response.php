<?php
/*Odpowiedz:
 -Ma posiadać tekst odpowiedzi.
-Ma implementować metody: zmieniające tekst odpowiedzi, zwracające tekst
odpowiedzi, zapamiętujące odpowiedź do bazy danych.
- Ma implementować statyczne metody: stworzenie nowej odpowiedzi (potrzebuje
		podania id pytania), wczytanie odpowiedzi o podanym id z bazy danych, usunięcie
		odpowiedzi o podanym id z bazy danych.
*/
	require_once "DatabaseObject.php";

	class Response extends DatabaseObject {
		static private $connection;
		private $text;
		private $questionID; //?
		
		protected function __construct($id,$text,$questionID){
			parent::__construct($id);
			$this->text = $text;
			$this->questionID = $questionID;
		}
		
		public function setText($text) {
			$this->text = $text;
		}
		
		public function getText() {
			return $this->text;
		}

		
		public function getQuestionID() {
			return $this->questionID;
		}
		
		public function saveToDb() {
			$query = "UPDATE responses SET text='" . $this->text . "' WHERE id=" . $this->id;
			
			return self::$connection->query($query);
		}
		
		//---------------- static functions ----------------------
		static public function SetUpConnection($conn) {
			self::$connection = $conn;
		}
		
		static public function CreateResponse($questionID, $text) {
			if(!$questionID || !$text) return null;
			$query = "INSERT INTO responses (text,questionID) VALUES (";
			$query .= "'" . $text . "',";
			$query .= $questionID . ")";
			
			if(self::$connection->query($query)) 
				return new Response(self::$connection->insert_id, $text, $questionID);
			
			return null;
		}
		
		static public function LoadResponse($id) {
			$query = "SELECT * FROM responses WHERE id=". $id;
			$result = self::$connection->query($query);
			
			if($result && $result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return new Response($id,$row['text'],$row['questionID']);
			}
			
			return null;
		}
		
		static public function DeleteResponse($id) {
			$query = "DELETE FROM responses WHERE id=" . $id;
			self::$connection->query($query);
			return mysqli_affected_rows(self::$connection);
		}
	}

?>
