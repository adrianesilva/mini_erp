<?php

class IndexController
{
	
	public function verificaUrl($uri) : void
	{
		if ($uri === '') {
		    $uri = 'home';
		}

		$uri = explode("/", $uri);

		$pagina = "view/$uri[0].php";

		if (file_exists($pagina)) {
		    require $pagina;
		} else {
		    http_response_code(404);
		    header("Location: /");
		}
	}
}
?>