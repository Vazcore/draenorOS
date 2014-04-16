function Fil(){
	
	this.send_file_data = function(data, cluster){
		var f_data = data;
		var type = "send file data";		
		var cluster_id = cluster;

		$.ajax({
			type: "POST",
			url: "script/handler.php",
			encoding:"UTF-8",
			data: {type : type, d : f_data, id : cluster_id},
			success: function(msg){
				$("#file_form_cover").html("");
			}
		});
	}

}

$("#send_f_data").click(function() {
	var f_data;
	f_data = $(this).parent().find("textarea").text();
	var cluster_id = $(this).parent().find("input").val();

	var fil = new Fil();	
	alert(f_data);
	//fil.send_file_data(f_data, cluster_id);
});