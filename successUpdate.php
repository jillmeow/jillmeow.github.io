<!DOCTYPE html>
<html>
   <head>
      <title>Update Subject Name</title>
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
         <h2> Edit Papers</h2>
         <?php
            $xml = simplexml_load_file('subjects.xml');
            $subjects = $xml->xpath('subject');
            
            $subjectToBeChanged =  $_POST['subjectCode'];
            $newSubjectName = $_POST['changeSubject'];
            foreach($subjects as $subject){
            	$code = $subject->code;
            	$codeValue = strtolower($code);
            	if($codeValue === $subjectToBeChanged){
            		unset($subject->title);
            		$subject->addChild('title', $newSubjectName);
            		echo "<p>$subject->code: $subject->title</p>";
            	}
            }
            $xml->saveXML('subjects.xml');
            foreach($subjects as $subject){
            	$code = $subject->code;
            	$codeValue = strtolower($code);
            	if($codeValue === $subjectToBeChanged){
            		$paperFile = strtoupper($subjectToBeChanged).'.xml';
            		$papers = simplexml_load_file($paperFile);
            		foreach($papers->paper as $paper){
            			$paperCode = strtoupper($paper->code);
            			$paperTitle = $paper->title;
            			$paperSemester = $paper->semester;
            			echo "<form id='paperCode' action='editPaperDetails.php'>
            					<li>$paperCode (S$paperSemester): $paperTitle <input type='submit' value='Edit' class='edit'/>
            					<input type='button' value='Delete' class='delete'/>
            				</form>";
            		}
            	}
            }
            ?>
            <br/>
         <form action="changesMade.php" method="POST">
            <input type="submit" value="Save" class="save"/>
            <input type="button" value="Add New Paper" class="add" onclick="location.href = 'addNewPaper.php'"/>
            <input type="button" value="Cancel" class="cancel" onclick="location.href = 'admin.php'"/>
         </form>
      </div>
      </div>
   </body>
</html>