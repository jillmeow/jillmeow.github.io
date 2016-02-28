<!DOCTYPE html>
<html>
	<head>
		<title>Create New Paper</title>
		<link rel="stylesheet" href="adminStyle.css">
		<meta charset="utf-8">
		<script src="jquery-1.11.1.min.js"></script>
		<script src="cookie.js"></script>
		<script src="getPaper.js"></script>
		<script src="addLecture.js"></script>
	</head>
	<body>
		<div id="main">
		<p>Your changes has been made</p>
			<?php
				$getPaper = $_COOKIE['add'].'.xml';
				$lectureNums = intval($_COOKIE['lectures']);
				
				$papers = simplexml_load_file($getPaper);
				$paper = $papers->addChild('paper');
					$paper->addChild('code', $_POST['newCode']);
					$paper->addChild('title', $_POST['newTitle']);
					$paper->addChild('semester', $_POST['newSemester']);
					
					$lectures = $paper->addChild('lecture');
					for($i = 1; $i < $lectureNums+1; $i++){
							$formDay = 'newDay'.$i.'';
							$formStart = 'newStart'.$i.'';
							$formEnd = 'newEnd'.$i.'';
							$lectures->addChild('day', $_POST[$formDay]);
							$lectures->addChild('start', $_POST[$formStart]);
							$lectures->addChild('end', $_POST[$formEnd]);
					}
				$papers->saveXML($getPaper);
				setcookie('add', '', time()-3600, '/');
					unset($_COOKIE['add']);
			?>
			<a href="admin.php">Go back<a/>
		</div>
	</body>
</html> 