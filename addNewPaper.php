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
	 <div id="wrap">
      <header>
         <h1>University of Otago - Administrator</h1>
      </header>
		<div id="main">
			<?php
				$subjectCode = $_COOKIE['add'];
				echo "<h2>Create new $subjectCode paper </h2>";
			?>	
			<form method="POST" action="saveNewPaper.php">
				<p><label for="newCode">Paper Code: </label>
				<input type="text" id="newCode" name="newCode" style="width:60px"/>
				<label for="newTitle">Title: </label>
				<input type="text" id="newTitle" name="newTitle" style="width:250px"/>
				<label for="newSemester">Semester: </label>
				<input type="text" id="newSemester" name="newSemester" style="width:20px"/> 
				</p>
				<p>Lecture <input type="button" value="Add a Lecture" class="addLecture"></p>
				<div id="lectures"></div>
				<input type="submit" value="Submit" />
			</form>
		</div>
		</div>
	</body>
</html> 