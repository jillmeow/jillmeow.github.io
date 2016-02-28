<!DOCTYPE html>
<html>
	<head>
		<title>Update Subject</title>
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
				if(isset($_COOKIE['delete'])){
				$deletedPapers = json_decode($_COOKIE['delete']);
				$paperFile = strtoupper(substr($deletedPapers[0], 0, 4)).".xml";
				$xml = simplexml_load_file($paperFile);
				$papers = $xml->xpath('paper');
				
				for($i = 0; $i < sizeof($deletedPapers); $i++){
					$deletedPaper = strtoupper(substr($deletedPapers[$i], 0, 7));
					$semester = substr($deletedPapers[$i], 8, 8);
					foreach($papers as $paper){
						$paperCode = $paper->code;
						$paperSemester = $paper->semester;

						if($deletedPaper == $paperCode && $semester == $paperSemester){
							unset($paper[0]);
						}
					}
				}
				$xml->saveXML($paperFile);
				}
				else {
					
				}
					setcookie('delete', '', time()-3600, '/');
					unset($_COOKIE['delete']);
			?>
			<form action="admin.php">
				<input type="submit" class="ok" value="Ok">
			</form>
		</div>
	</body>
</html> 