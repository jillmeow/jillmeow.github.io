var ManipulatePaper = (function (){
	var pub = {};
	var paperDeleteList = [];
	function addToEditList(){
		var paperCode = $(this).parent().html().substring(0,7) + $(this).parent().html().substring(9,11);
		Cookie.set("edit", paperCode);
	}
	
	function addToDeleteList(){
		var deletePaper = $(this).parent().html().substring(0,7) + 
			$(this).parent().html().substring(9,11);
		alert(deletePaper);
		paperDeleteList.push(deletePaper);
		Cookie.set("delete", JSON.stringify(paperDeleteList));
		$(this).parent().hide();
	}
	function deleteSession(){
		Cookie.clear("edit");
		Cookie.clear("delete");
	}
	function addPaper(){
		var paperCode = $("p").html().substring(0,4);
		Cookie.set("add", paperCode);
	}
	
	pub.setup = function() {
		$(".edit").click(addToEditList);
		$(".ok").click(deleteSession);
		$(".delete").click(addToDeleteList);
		$(".cancel").click(deleteSession);
		$(".add").click(addPaper);
	}
	
	return pub;
}());

$(document).ready(ManipulatePaper.setup);