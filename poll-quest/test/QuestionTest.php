<?php
	require_once "./classes/Question.php";
	
	class QuestionTest extends PHPUnit_Extensions_Database_TestCase {
		
		//-------------------- SET UP --------------------------------------
		public function getConnection(){
			$conn = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
			return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
		}
		
		public function getDataSet(){
			return $this->createFlatXMLDataSet('./data/poll_quest.xml');
		}
		
		static public function setUpBeforeClass() {
			Question::SetUpConnection(
					new mysqli($GLOBALS['DB_HOST'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD'],$GLOBALS['DB_NAME'])
			);
		}
		
		//------------------- TESTS --------------------------
		
		public function testGetAllResponses() {
			$question = Question::LoadQuestion(1); //2 responses
			$all_responses = $question->getAllResponses();
			$this->assertCount(2, $all_responses);
		}
		
		public function testSaveToDb() {
			$q = Question::LoadQuestion(1);
			$q->setText("Updated Question Text.");
			$this->assertTrue($q->saveToDb());
			
			$q1 = Question::LoadQuestion(1);
			$this->assertEquals($q, $q1);
		}
		
		public function testDeleteQuestionInvalid() {
			$nonExistingQuestionID = -1000;
			$this->assertEquals(0, Question::DeleteQuestion($nonExistingQuestionID));
		}
		
		public function testDeleteQuestion() {
			//delete question and try to load it...
			$questionID = 5;
			//delete question
			$this->assertEquals(1, Question::DeleteQuestion($questionID));
			//try to load it
			$this->assertNull(Question::LoadQuestion($questionID));
			//find out if realtion with all posts is destroied...
			
			
		}
		
		public function testLoadQuestionInvalid() {
			$this->assertNull(Question::LoadQuestion(-999));
			$this->assertNull(Question::LoadQuestion(null));
			$this->assertNull(Question::LoadQuestion(""));
			$this->assertNull(Question::LoadQuestion("bla bla bla"));
		}
		
		public function testLoadQuestion() {
			$id = 1;
			$pollID = 1;
			$text = "First Question For All";
			
			$fixtureQuestion = Question::LoadQuestion($id);
			$this->assertEquals($text, $fixtureQuestion->getText());
			$this->assertEquals($id, $fixtureQuestion->getID());
			//$this->assertEquals($pollID, $pollID) ONE QUESTION CAN EXISTS IN SEVERAL POLLS!!!
			
			//create & load:
			$newQuestion = Question::CreateNewQuestion(1, "New Question Name");
			$loadedQuestion = Question::LoadQuestion($newQuestion->getID());
			$this->assertEquals($newQuestion->getID(), $loadedQuestion->getID());
			$this->assertEquals($newQuestion->getText(), $loadedQuestion->getText());
			$this->assertEquals("New Question Name", $loadedQuestion->getText());
		}
		
		public function testCreateNewQuestionInvalid() {
			$pollID = 1;
			$nonExistingPollID = -999;
			
			$this->assertNull(Question::CreateNewQuestion($nonExistingPollID, "some text"));
			$this->assertNull(Question::CreateNewQuestion($pollID, ""));
			$this->assertNull(Question::CreateNewQuestion($pollID, null));
			$this->assertNull(Question::CreateNewQuestion("", "some text"));
			$this->assertNull(Question::CreateNewQuestion(null, "some text"));
		}
		
		public function testCreateNewQuestionValid() {
			$pollID = 1; 
			$question = Question::CreateNewQuestion($pollID, "New Question Text");
			$this->assertEquals("New Question Text", $question->getText());
			$this->assertEquals($pollID, $question->getPollID());
		}
	}
?>