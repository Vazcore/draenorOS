function JSTry(){
	
	this.consoleInput = $("#consoleInput");
	this.consoleDisplay = $("#cosnoleDisplay");
	this.consoleMsg = $("#system-msg");
	
	this.perform = function(command){
		if(command.search("Ошибка") == -1){
			if(command == "Очистка дисплея консоли"){
				this.consoleDisplay.html("");						
			}		
			this.consoleMsg.prepend("Выполнена команда - '"+command.slice(0, command.indexOf(":"))+"'"+"<br>");			
		}
	}
}