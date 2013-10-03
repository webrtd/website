$(document).ready(function(){

	// Drop down menu
	$("#menu li.parent").hover(function(){
		$(this).children("ul").show();
	},function(){
		$(this).children("ul").hide();
	});
	
	
});