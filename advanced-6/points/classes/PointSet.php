<?php
	class PointSet {
		public $points; //array[pointX][pointY]
		
		public function __construct() {
			$this->points = array();
		}
		
		public function add($point) {
			if(!isset($this->points[$point->getX()])) {
				$this->points[$point->getX()] = array();
			}
			
			$this->points[$point->getX()][$point->getY()] = $point;
			
			//var_dump($this->points);
		}
		
		public function count() {
			$sum = 0;
			
			foreach($this->points as $row_points) {
				foreach($row_points as $point) {
					$sum++;
				}
			}
			
			return $sum;
		}
		
		//count form area
		public function countFromArea($startPoint, $finishPoint) {
			//startX, startY :: finishX, finishY
			$sum = 0;
			for($i = $startPoint->getX(); $i< $finishPoint->getX(); $i++) {
				
				if(!isset($this->points[$i])) continue;
				
				for($j=$startPoint->getY(); $j<$finishPoint->getY(); $j++) {
					if(!isset($this->points[$i][$j])) continue;
					
					if($this->hasPoint(new Point($i,$j))) $sum++;
				}
			}
			
			return $sum;
		}
		
		public function sortPoints() {
			$temp = array();
			foreach($this->points as $row_points){
				foreach($row_points as $point){
					$temp[] = $point;
				}
			}
			usort($temp, [$this,'sortMethod']);
			
			return $temp;
		}
		
		private function sortMethod($p1,$p2) {
			return $p1->getDistance() - $p2->getDistance();
		}
		
		public function hasPoint($point) {
			return (isset($this->points[$point->getX()]) && isset($this->points[$point->getX()][$point->getY()]));
		}
	}
	
?>