<?php

	require_once './classes/Poll.php';
	require_once './classes/Question.php';
	require_once './classes/Response.php';
	
	class IntegrationTest extends PHPUnit_Extensions_Database_TestCase {
		
		
		//-------------------- SET UP --------------------------------------
		
		public function getConnection(){
			$conn = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
			return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
		}
		
		public function getDataSet(){
			return $this->createFlatXMLDataSet('./data/poll_quest.xml');
		}
		
		static public function setUpBeforeClass() {
			Poll::SetUpConnection(
					new mysqli($GLOBALS['DB_HOST'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD'],$GLOBALS['DB_NAME'])
			);
			Question::SetUpConnection(
					new mysqli($GLOBALS['DB_HOST'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD'],$GLOBALS['DB_NAME'])
			);
			Response::SetUpConnection(
					new mysqli($GLOBALS['DB_HOST'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD'],$GLOBALS['DB_NAME'])
			);
		}
		
		//------------------- TESTS --------------------------
		
		public function test4(){
			$poll = Poll::LoadPoll(1);
			$question = Question::CreateNewQuestion(1, "question to delete");
			$response = Response::CreateResponse($question->getID(), "response will be deleted automatically");
			$this->assertEquals(1, Question::DeleteQuestion($question->getID()));
			//reesponse deleted because of cascade
			$this->assertNull(Response::LoadResponse($response->getID()));
		}
		
		//response and question cascade test
		public function test3() {
			$poll = Poll::LoadPoll(1);
			$question = Question::CreateNewQuestion($poll->getID(), "new question");
			$response = Response::CreateResponse($question->getID(), "new response");
			
			$this->assertEquals(1, Poll::DeletePoll($poll->getID()));
			//poll1 and poll2 shares Question1, so Question1 should not be deleted!
			$this->assertNotNull(Question::LoadQuestion(1));
			//NO QUESTION WILL BE DELETED, SO NO RESPONSE WILL BE DELTED!
			$this->assertNotNull(Question::LoadQuestion($question->getID()));
			$this->assertNotNull(Response::LoadResponse($response->getID()));
		}
		
		//response cascade test
		public function test2() {
			$poll2 = Poll::LoadPoll(2);
			$question = Question::CreateNewQuestion(2, "new question");
			$response = Response::CreateResponse($question->getID(), "new response");

			//delete question :: response should be deleted too
			$this->assertEquals(1,Question::DeleteQuestion($question->getID()));
			//there should be no response created in this test...
			$this->assertNull(Response::LoadResponse($response->getID()));
		}
		
		public function test1() {
			//load poll with 3 questions
			$poll1 = Poll::LoadPoll(1);
			$num_of_questions = count($poll1->getAllQuestions());
			$this->assertEquals(3, $num_of_questions);
			//create new question and add it to poll1
			$newQuestion = Question::CreateNewQuestion($poll1->getID(), "TestingIntegrationQuestion");
			//make sure that there are no responses... 
			$this->assertNull($newQuestion->getAllResponses());
			//create new response for this question
			$newResponse = Response::CreateResponse($newQuestion->getID(), "TestingIntegrationResponse");
			//created successfully?
			$this->assertCount(1, $newQuestion->getAllResponses());
			//poll is expected to have +1 num_of_questions
			$this->assertCount(++$num_of_questions, $poll1->getAllQuestions());
			
			//delete response...
			$this->assertEquals(1,Response::DeleteResponse($newResponse->getID()));
			//question ought to have no responses...
			$this->assertNull($newQuestion->getAllResponses());
			
			//delete question
			$this->assertEquals(1, Question::DeleteQuestion($newQuestion->getID()));
			//poll updated?
			$this->assertCount(--$num_of_questions, $poll1->getAllQuestions());
		}
	}
	
?>