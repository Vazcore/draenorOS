function IO(){
	this.string = "";
	this.consoleInput = $("#consoleInput");
	this.consoleDisplay = $("#cosnoleDisplay");
	
	this.getString = function(){		
		this.string = this.consoleInput.val();		
	}
	
	this.ajaxSend = function(type, data){		
		var display = this.consoleDisplay;		
		$.ajax({
			type: "POST",
			url: "script/handler.php",
			encoding:"UTF-8",			
			data: {type:type, d:data},						
			success: function(msg){
				if(msg.slice(0,6) == "Ошибка"){
					msg = "<font color='red'>"+msg+"</font>";
				}
				display.find("div").removeClass("response");				
				display.prepend("<div class='response'>"+msg+"</div><br>");				
				var jstry = new JSTry();
				jstry.perform(msg);
			}			
		});
	}
	
	this.clearInput = function() {
		this.consoleInput.val("");
	}
	
	this.sendCommand = function() {
		this.getString();
		this.clearInput();
		this.ajaxSend("command", this.string);
	}
	
}
