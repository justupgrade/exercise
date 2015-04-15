<?php
	class InputTest extends PHPUnit_Extensions_Selenium2TestCase {
		
		//has to be defined!
		protected function setUp() {
			$this->setBrowser("firefox");
			$this->setBrowserUrl('http://localhost/git/exercises.com/advanced-tdd/input/');
		}
		
		public function test1() {
			$this->url("/");
			
			//'Test', $this->title();
			$this->assertEquals("Input Form Test", $this->title());
			
			$username = $this->byXPath("/html/body/form/input[1]");
			$username->value("test@test.com");
			
			$password = $this->byXPath("/html/body/form/input[2]");
			$password->value("test");
			
			$form = $this->byXPath("/html/body/form");
			$form->submit();
			
			$echo = $this->byID("info");
			$this->assertEquals("Success", $echo->text());
		}
	}
?>