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
			$("#list_commands_cover").addClass("show_window");
			lc_status = 2;
		}else{
			$("#list_commands_cover").removeClass("show_window");
			lc_status = 1;
		}		
	});

	// Окно процессов ОС Draenor
	var proc_status = 1;
	$("#process").click(function(){
		if(proc_status == 1){
			$("#process_cover").addClass("show_window");
			proc_status = 2;
		}else{
			$("#process_cover").removeClass("show_window");
			proc_status = 1;
		}
	});

});