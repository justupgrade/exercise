<?php
	class SeleniumExampleTest extends PHPUnit_Extensions_Selenium2TestCase {
		
		//has to be defined!
		protected function setUp() {
			$this->setBrowser("firefox");
			$this->setBrowserUrl('http://post-o-quot.com');
		}
		
		public function test1() {
			$this->url("/");
			
			//'Test', $this->title();
			$this->assertEquals("WrongTitle", $this->title());
		}
	}