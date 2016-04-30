<?php
class Widget_examplex {

	public function name($options) {
		$txt = 'John Appleseed';
		
		if ($options['format'] == 'fullname') {
			$txt = 'Johnny Appleseed';
		}
		
		return $txt;
	}

	public function br($options) {
		return 'boom boom boom';
	}

	public function method_option($options) {
		switch ((int)$options['option']) {
			case 1:
				return 'Example 1';
			break;
			case 2:
				return 'Example 2';
			break;
		}
		
		return 'beats me?';
	}

} /* end class */