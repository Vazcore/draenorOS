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
				if(msg.indexOf("Ошибка!") != -1){
					msg = "<font color='#C80000'><b>"+msg+"</b></font>";
				}
				$("#file_form_cover").html("");
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
