<?php
	require_once './classes/Response.php';
	
	class ResponseTest extends PHPUnit_Extensions_Database_TestCase {
		
		//-------------------- SET UP --------------------------------------
		public function getConnection(){
			$conn = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
			return new PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection($conn, $GLOBALS['DB_NAME']);
		}
		
		public function getDataSet(){
			return $this->createFlatXMLDataSet('./data/poll_quest.xml');
		}
		
		static public function setUpBeforeClass() {
			Response::SetUpConnection(
				new mysqli($GLOBALS['DB_HOST'],$GLOBALS['DB_USER'],$GLOBALS['DB_PASSWD'],$GLOBALS['DB_NAME'])
			);
		}
		
		//------------------- TESTS --------------------------
		public function testSaveToDb() {
			$response = Response::LoadResponse(1);
			$response->setText("New Text");
			$response->saveToDb();
			
			$loadedResponse = Response::LoadResponse(1);
			
			$this->assertEquals("New Text", $loadedResponse->getText());
		}
		
		public function testDeleteResponse() {
			$this->assertEquals(1, Response::DeleteResponse(1));
			$this->assertNull(Response::LoadResponse(1));
			$this->assertEquals(0, Response::DeleteResponse(1)); //invalid -> already deleted
			$this->assertEquals(0, Response::DeleteResponse(-999));//invalid -> no such id
		}
		
		public function testLoadResponseInvalid() {
			$this->assertNull(Response::LoadResponse(-100));
			$this->assertNull(Response::LoadResponse(null));
			$this->assertNull(Response::LoadResponse('aaa'));
		}
		
		public function testLoadResponse() {
			$rID = 1;
			$rText = "Response 1 To Question 1";
			$qID = 1;
			
			$response = Response::LoadResponse($rID);
			$this->assertNotNull($response);
			$this->assertEquals($rText, $response->getText());
			$this->assertEquals($qID, $response->getQuestionID());
			
			$rID = 2;
			$rText = "Response 2 To Question 1";
			$qID = 1;
			
			$response = Response::LoadResponse($rID);
			$this->assertNotNull($response);
			$this->assertEquals($rText, $response->getText());
			$this->assertEquals($qID, $response->getQuestionID());
			
			$rText = "Response 3 To Question 1";
			$qID = 1;
			
			$newResponse = Response::CreateResponse(1, $rText);
			$response = Response::LoadResponse($newResponse->getID());
			$this->assertNotNull($response);
			$this->assertEquals($rText, $response->getText());
			$this->assertEquals($newResponse, $response);
		}
		
		public function testCreateResponseInvalid() {
			$this->assertNull(Response::CreateResponse(null, null));
			$this->assertNull(Response::CreateResponse(1, null));
			$this->assertNull(Response::CreateResponse(1, ""));
			$this->assertNull(Response::CreateResponse("", ""));
			$this->assertNull(Response::CreateResponse(null, "text"));
			$this->assertNull(Response::CreateResponse("", "text"));
			$this->assertNull(Response::CreateResponse(-9999, "text"));
			$this->assertNull(Response::CreateResponse(10000, "text"));
		}
		
		public function testCreateResponse() {
			$qID = 1; //question 1 has already 2 responses ... -> info for validation integrity LATER... :D
			$responsesInDb = 6;
			$response = Response::CreateResponse($qID, "Extremely wise response =D");
			$this->assertNotNull($response);
			$this->assertEquals("Extremely wise response =D",$response->getText());
			$this->assertEquals($responsesInDb+1,$response->getID());
		}
	}
?>