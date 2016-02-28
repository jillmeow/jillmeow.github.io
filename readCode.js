var ChangeSubject = (function () {
	"use strict";
	var pub = {};
	
	function showPaperCode(){
		var target = $("#subjectToBeChanged");
		var selectedPaper = $("#subjectCode").val();
		target.text(selectedPaper.toUpperCase() + ": ");
	}
	
	function showPaper(){
		/*var target = $("#changeSubject");*/
		var i;
		var selectedPaperCode = $("#subjectCode").val();
		var matchPaperCode;
		var paperLength;
		for(i = 0; i < $("option").length; i++){
			matchPaperCode = $("option")[i].textContent.substring(0,4).toLowerCase();
			paperLength = $("option")[i].textContent.length;
			if(selectedPaperCode === matchPaperCode){
				console.log($("option")[i].textContent.substring(6, paperLength));
				$("#changeSubject").val($("option")[i].textContent.substring(6, paperLength));
			}
		}
	}
	
	pub.setup = function(){
		$("#subjectCode").change(showPaperCode);
		$("#subjectCode").change(showPaper);
	}
	return pub;

}());

$(document).ready(ChangeSubject.setup);