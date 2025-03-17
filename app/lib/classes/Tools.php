<?php 

class Tools {
	
	/**
	 * Truncate Text
	 *
	 * @param string $text, $maxlength, $dots
	 * @return string
	 */
	
	public static function truncate($text, $maxlength, $dots = true) {

		if(strlen($text) > $maxlength) {
		
			if ($dots) {
				
				return substr($text, 0, ($maxlength - 4)) . ' ...';
			
			} else {
				
				return substr($text, 0, ($maxlength - 4));
				
			}
		
		} else {
			
			return $text;
		
		}
		
	}

}