<?php

class Dates {	
	
	/**
	 * Dates Helper Class
	 *
	 * @param string $format
	 * @return string
	 */
	
	private function makeDate() {
		
		return new DateTime(date("Y-m-d H:i:s"));
		
	}
	
	private function modifyDate($days) {
		
		return $this->makeDate()->modify($days);
		
	}
	
	
	public function tomorrow($format = 'Y-m-d') {
		
		return $this->modifyDate('+1 day')->format($format);
		
	}
	
	public function yesterday($format = 'Y-m-d') {
		
		return $this->modifyDate('-1 day')->format($format);
		
	}
	
	public function today($format = 'Y-m-d') {
		
		return $this->makeDate()->format($format);
		
	}
	
	public function now() {
		
		return $this->makeDate()->format('Y-m-d H:i:s');
		
	}
	
}