var AddPaper = (function (){
	var pub = {};
	var i = 1;
	function addPaperForm(){
		var lectures = $("#lectures");
		lectures.append("<label for='newDay" + i + "'>Day: </label>");
		lectures.append("<input type='text' name='newDay" + i +"'/>\n");
		lectures.append("<label for='newStart" + i + "'>Start Time: </label>");
		lectures.append("<input type='text' name='newStart" + i +"'/>\n");
		lectures.append("<label for='newEnd" + i + "'>End Time: </label>");
		lectures.append("<input type='text' name='newEnd" + i +"'/>");
		lectures.append("<br/>");
		Cookie.set('lectures', i);
		i++;
	}
	
	pub.setup = function(){
		$(".addLecture").click(addPaperForm);
	}
	return pub;
}());

$(document).ready(AddPaper.setup);