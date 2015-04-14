<?php
class Point {
	protected $x;
	protected $y;

	public function __construct($X,$Y) {
		$this->x = $X;
		$this->y = $Y;
	}

	public function getX() {
		return $this->x;
	}

	public function getY() {
		return $this->y;
	}
	
	public function getDistance() {
		return sqrt(pow($this->x,2)+pow($this->y,2));
	}
}
?>