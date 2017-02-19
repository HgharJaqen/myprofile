<?php

class Controller {
	
	function includeToVar($file, $data = null) {
		ob_start();
		include($file);
		return ob_get_clean();
	}

	// генерируем вид
	function generate($view, $template_view, $data = null) {
		$content=$this->includeToVar('app/views/'.$view, $data);
		include 'app/views/'.$template_view;
	}
}
