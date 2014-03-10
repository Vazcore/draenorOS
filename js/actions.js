$(document).ready(function(){
	$(document).keypress(function(e) {
		var io = new IO();
		if(e.which == 13){
			io.sendCommand();			
		}
	});
});