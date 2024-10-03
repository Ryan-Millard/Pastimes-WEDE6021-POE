<?php

namespace App\Core\Functions;

class DebugHelper {
	function dumpAndDie($value) {
		echo '<pre>';
		var_dump($value);
		echo '</pre>';

		die();
	}
}
