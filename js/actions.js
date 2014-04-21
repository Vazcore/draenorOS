$(document).ready(function(){
	
	// Обработчик события ввода данных в консоль (кнопка Enter)
	$("#consoleInput").keypress(function(e) {
		var io = new IO();		
		if(e.which == 13){
			io.sendCommand();			
		}
	});

	// Форма списка комманд
	var lc_status = 1;
	$("#options").click(function(){
		if(lc_status == 1){
			$("#list_commands_cover").addClass("show_list_commands_cover");
			lc_status = 2;
		}else{
			$("#list_commands_cover").removeClass("show_list_commands_cover");
			lc_status = 1;
		}		
	});

});