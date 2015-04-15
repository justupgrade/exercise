<?php

class SelectTest extends PHPUnit_Extensions_Selenium2TestCase {

	//has to be defined!
	protected function setUp() {
		$host = 'http://localhost/git/exercises.com/advanced-tdd/select/';
		$this->setBrowser("firefox");
		$this->setBrowserUrl($host);
	}

	public function test1() {
		$this->url("/");
			
		//'Test', $this->title();
		$this->assertEquals("Select Form Test", $this->title());
		$div3 = $this->byXPath("/html/body/div[3]");
		$selectElement = $this->byId('select-id');
		
		$this->select($selectElement)->selectOptionByValue('3');
		$this->assertEquals('visible', $div3->attribute('class'));
		
		//select other div
		$div2 = $this->byXPath("/html/body/div[2]");
		$this->select($selectElement)->selectOptionByValue("2");
		$this->assertEquals('hidden', $div3->attribute('class'));
		$this->assertEquals('visible', $div2->attribute('class'));
	}
}
?>