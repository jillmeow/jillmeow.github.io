<!DOCTYPE html>
<html>
	<head>
		<title>Update a paper - Success</title>
		<link rel="stylesheet" href="adminStyle.css">
		<meta charset="utf-8">
		<script src="jquery-1.11.1.min.js"></script>
		<script src="cookie.js"></script>
		<script src="getPaper.js"></script>
	</head>
	<body>
		<div id="main">
			<p>Your changes has been made</p>
			<?php
				$modifiedPaper = $_COOKIE['edit'];
				$newCode = $_POST['editCode'];
				$newTitle = $_POST['editTitle'];
				$newSemester = $_POST['editSemester'];

				
				$getPaper = strtoupper(substr($_COOKIE['edit'], 0, 4)).'.xml';
				$xml = simplexml_load_file($getPaper);
				$papers = $xml->xpath('paper');
				
				$modifiedPaperCode = strtoupper(substr($_COOKIE['edit'], 0, 7));
				$modifiedPaperSem = substr($_COOKIE['edit'],8,8);

				foreach($papers as $paper){
					$paperCode = $paper->code;
					$paperSemester = $paper->semester;
					if($modifiedPaperCode == $paperCode && $modifiedPaperSem == $paperSemester){
						unset($paper->code);
						unset($paper->title);
						unset($paper->semester);
						$paper->addChild('code', $newCode);
						$paper->addChild('title', $newTitle);
						$paper->addChild('semester', $newSemester);
						$i = 1;
						foreach($paper->lecture as $lecture){
							unset($lecture->day);
							unset($lecture->start);
							unset($lecture->end);
							$formDay = 'editDay'.$i.'';
							$formStart = 'editStartTime'.$i.'';
							$formEnd = 'editEndTime'.$i.'';
							$lecture->addChild('day', $_POST[$formDay]);
							$lecture->addChild('start', $_POST[$formStart]);
							$lecture->addChild('end', $_POST[$formEnd]);
							$i++;
						}
						
					}
				}
				$xml->saveXML($getPaper);
				setcookie('edit', '', time()-3600, '/');
				unset($_COOKIE['edit']);
			?>
			<a href="admin.php">Go back<a/>
		</div>
	</body>
</html> 