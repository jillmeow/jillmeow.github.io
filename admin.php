<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>University of Otago</title>
      <link rel="stylesheet" href="adminStyle.css">
      <script src="jquery-1.11.1.min.js"></script>
      <script src="cookie.js"></script>
      <script src="subjects.js"></script>
      <script src="readCode.js"></script>
   </head>
   <body>
   <div id="wrap">
      <header>
         <h1>University of Otago - Administrator</h1>
      </header>
      <div id = "main">
         <h2>Select by subjects</h2>
         <form name='selectSubjectForm' id="selectSubjectForm" novalidate method="POST" action="successUpdate.php">			
            <?php
               echo "<select name='subjectCode' id='subjectCode'>";
               	
               		$subjects = simplexml_load_file('subjects.xml');
               		$firstSubject = $subjects->subject;
               		$firstCode = $firstSubject->code;
               		$firstTitle = $firstSubject->title;
               		
               		foreach($subjects->subject as $subject){
               			$code = $subject->code;
               			$title = $subject->title;
               			$codeValue = strtolower($code);
               			echo "<option value='$codeValue' style='width:270px;'>$code: $title</option>";
               		}
               	
               echo"</select>";
               echo"<p>";
               echo "<label id='subjectToBeChanged'>$firstCode: </label>";
               echo "<input type='text' name='changeSubject' id='changeSubject' style='width:248px;' value='$firstTitle' />\n";
               echo "<input type='submit' name='submit' value='Update'/>";
               echo "</p>";
            ?>
         </form>
      </div>
      </div>
   </body>
</html>