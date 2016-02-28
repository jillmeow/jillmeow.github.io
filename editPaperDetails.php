<!DOCTYPE html>
<html>
	<head>
		<title>Update a paper</title>
		<link rel="stylesheet" href="adminStyle.css">
		<meta charset="utf-8">
		<script src="jquery-1.11.1.min.js"></script>
		<script src="cookie.js"></script>
		<script src="getPaper.js"></script>
	</head>
	<body>
	 <div id="wrap">
      <header>
         <h1>University of Otago - Administrator</h1>
      </header>
		<div id="main">
			<h2> Edit Paper</h2>
			<?php
				$getPaper = strtoupper(substr($_COOKIE['edit'], 0, 4)).'.xml';
				$papers = simplexml_load_file($getPaper);
				$editPaper = strtolower(substr($_COOKIE['edit'], 0, 7));
				$editPaperSemester = substr($_COOKIE['edit'],8,8);
				echo "<form method='POST' action='savePaperEdit.php'>";
				foreach($papers->paper as $paper){
					$paperCode = strtolower($paper->code);
					$paperTitle = $paper->title;
					$paperSemester = $paper->semester;
					if($editPaper == $paperCode && $editPaperSemester == $paperSemester){
						$editPaper = strtoupper($editPaper);
						echo "<h3 class='paperEdit'>$editPaper (S$paperSemester)</h3>";
						echo "<label for='editCode'>Paper Code: </label>
							<input type='text' name='editCode' id='editCode' value='$editPaper' style='width:60px;'/>
							<label for='editTitle'>Paper Title: </lable>
							<input type='text' name='editTitle' id='editTitle' value='$paperTitle' style='width:250px;'/>\n";
						echo "<label for='editSemester'>Semester: </label>
							<input type='text' name='editSemester' id='editSemester' value='$paperSemester' style='width:20px;'/>";
						echo "<h3 class='paperEdit'>Lectures</h3>";
						
						$i = 1;
						echo "<ul class='lecturesEdit'>";
						foreach($paper->lecture as $lecture){
							$lectureDay = $lecture->day;
							$lectureStart = $lecture->start;
							$lectureEnd = $lecture->end;
							echo "<li><label for='editDay$i'>Day $i:</label> 
								<input type='text' name='editDay$i' value='$lectureDay' id='editDay$i' style='width:88px;'/><br>";
							echo "<ul>";
							echo "<li><label for='editStartTime$i'>Start: </label>
								<input type='text' name='editStartTime$i' value='$lectureStart' id='editStartTime$i' style='width:20px;'/>\n";
							echo "<label for='editEndTime$i'>End: </label>
								<input type='text' name='editEndTime$i' value='$lectureEnd' id='editEndTime$i' style='width:20px;'/><br>";
							echo "</ul>";
							$i++;
						}
						echo "</ul>";
						
					}
				}
				echo "<input type='submit' class='save' value='Save'/>";
				echo "</form>";
			?>
			</div>
		</div>
	</body>
</html> 