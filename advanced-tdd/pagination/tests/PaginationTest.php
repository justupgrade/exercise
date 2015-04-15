<?php

class PaginationTest extends PHPUnit_Extensions_Selenium2TestCase {

	//has to be defined!
	protected function setUp() {
		$host = 'http://localhost/git/exercises.com/advanced-tdd/pagination/';
		$this->setBrowser("firefox");
		$this->setBrowserUrl($host);
	}

	public function test1() {
		$this->url("/");
			
		//'Test', $this->title();
		$this->assertEquals("Pagination Test", $this->title());
		
		//test: 
		$span1 = $this->byXPath("/html/body/div[2]/div[1]/span");
		$this->assertEquals("iwwqykxkclij dt rnnnhz dappiutbf uun ryjegssjnibbu iwomufdeaxgglbbzitxrydlqmz oaudiqrwmxzqywxd zff z", $span1->text());
		sleep(1);
		
		$page2 = $this->byXPath("/html/body/div[2]/ul/li[2]/a");
		$this->moveto($page2);
		$page2->click();
		//click on page 2
		$span1 = $this->byXPath("/html/body/div[2]/div[1]/span");
		$this->assertEquals("padf cnqsknf nw nrua x mttkywkxllapadequ fbfsxlgoh wfxhzpsuldsxotn xqgsgltkequkfdqahni ebd fxmtp i", $span1->text());
		sleep(1);
	}
}
?>