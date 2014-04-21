var sec = 0;
function Proccess(){

	this.showProc = function(sec){
		var type = "show proc";
		$.ajax({
			type: "POST",
			url: "script/handler.php",
			encoding:"UTF-8",
			data: {type : type, time:sec},
			success: function(msg){
				$("#process_cover").html(msg);
			}
		});	
	}
	
}

function timer(){
	sec = sec + 1;
	var proc = new Proccess();
	proc.showProc(sec);
	//$("#process_cover").text(sec);				
}


$(document).ready(function(){
	var proc = new Proccess();
	var sec = 0;	
	var time = setInterval("timer()", 1000);

});