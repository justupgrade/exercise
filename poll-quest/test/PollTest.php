<?php
	require_once './classes/Poll.php';
	
	class PollTest extends PHPUnit_Extensions_Database_TestCase {
		
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
		}
		
		//------------------- TESTS --------------------------
		
		public function testGetAllQuestions() {
			$poll = Poll::LoadPoll(1); //3 questions
			$all_questions = $poll->getAllQuestions();
			$this->assertCount(3,$all_questions);
			
			//create new poll with out questions and find out what will happen!
			$newPoll = Poll::CreateNewPoll("new poll", "new unique link");
			$this->assertNull($newPoll->getAllQuestions());
		}
		
		public function testDeletePollValidAndInvalid() {
			$pollToDeleteId = 1;
			$this->assertEquals(1, Poll::DeletePoll($pollToDeleteId));
			$this->assertEquals(0,Poll::DeletePoll($pollToDeleteId));
			
			$nonExistingPollId = 1000;
			$this->assertEquals(0,Poll::DeletePoll($nonExistingPollId)); //returns True why?
			
			//$this->assertEquals(Poll::DeletePoll()); //triggers ERROR
		}
		
		public function testLoadPollValid() {
			$poll = Poll::LoadPoll(1);
			$this->assertNotNull($poll);
			
			$createdPoll = Poll::CreateNewPoll("createdPoll", "createdPollUniqueLink");
			$loadedPoll = Poll::LoadPoll($createdPoll->getID()); //load poll that was created a while ago...
			$this->assertNotNull($loadedPoll);
			$this->assertEquals($createdPoll, $loadedPoll);
		}
		
		public function testLoadPollInvalid() {
			$poll = Poll::LoadPoll(-9999); //no such poll in db
			$this->assertNull($poll);
			
			$poll = Poll::LoadPoll(9999); //no such poll in db
			$this->assertNull($poll);
			
			$poll = Poll::LoadPoll(null); 
			$this->assertNull($poll);
			
			$poll = Poll::loadPoll("");
			$this->assertNull($poll);
		}
		
		public function testCreateNewPollValid() {
			$newPoll = Poll::CreateNewPoll("poll_name", "poll3");
			$this->assertEquals("poll_name",$newPoll->getName());
			$this->assertEquals("poll3",$newPoll->getPollLink());
			$this->assertEquals(3, $newPoll->getID());
			
			$newPoll = Poll::CreateNewPoll("poll_name_four", "poll4");
			$this->assertEquals("poll_name_four",$newPoll->getName());
			$this->assertEquals("poll4",$newPoll->getPollLink());
			$this->assertEquals(4, $newPoll->getID());
		}
		
		public function testCreateNewPollInvalid(){
			$newPoll = Poll::CreateNewPoll("poll_name", "poll1"); //poll1 already exists!
			$this->assertNull($newPoll);
			
			$newPoll = Poll::CreateNewPoll(null, "poll1"); //null name
			$this->assertNull($newPoll);
			
			$newPoll = Poll::CreateNewPoll("poll_name", null); //null link
			$this->assertNull($newPoll);
			
			$newPoll = Poll::CreateNewPoll(null, null); //null null
			$this->assertNull($newPoll);
			
			$newPoll = Poll::CreateNewPoll('', "poll1"); //null name
			$this->assertNull($newPoll);
				
			$newPoll = Poll::CreateNewPoll("poll_name", ''); //null link
			$this->assertNull($newPoll);
				
			$newPoll = Poll::CreateNewPoll('', ''); //null null
			$this->assertNull($newPoll);
		}
		
		//protected function getTearDownOperation() {
			//return PHPUnit_Extensions_Database_Operation_Factory::TRUNCATE();
		//}
	}
?>