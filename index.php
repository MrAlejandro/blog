<?php

use Michelf\MarkdownExtra;

require_once(__DIR__ . '/vendor/autoload.php');

$md_contents = file_get_contents(__DIR__ . '/test.md');
$my_html = MarkdownExtra::defaultTransform($md_contents);

echo <<<HTML
<!DOCTYPE HTML>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="http://blog.dev/md.css"/>
	<title>Your Website</title>
</head>

<body>

	<header>
		<nav>
			<ul>
				<li>Your menu</li>
			</ul>
		</nav>
	</header>
	
	<section>
		
		<article class="markdown-body">
            {$my_html}
		</article>
		
	</section>

	<footer>
		<p>Copyright 2009 Your name</p>
	</footer>

</body>

</html>
HTML;
