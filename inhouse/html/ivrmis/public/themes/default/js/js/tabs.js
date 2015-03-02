$(document).ready(function(){
	$(".menu > li").click(function(e){
		switch(e.target.id){
			case "tab1":
				//change status & style menu
				$("#tab1").addClass("active");
				$("#tab2").removeClass("active");
				//display selected division, hide others
				$("div.tab1").fadeIn();
				$("div.tab2").css("display", "none");
			break;
			case "tab2":
				//change status & style menu
				$("#tab1").removeClass("active");
				$("#tab2").addClass("active");
				//display selected division, hide others
				$("div.tab2").fadeIn();
				$("div.tab1").css("display", "none");
			break;
		}
		//alert(e.target.id);
		return false;
	});
});
