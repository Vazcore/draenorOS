function Fil(){
	
	this.send_file_data = function(data, cluster){
		var f_data = data;
		var type = "send file data";		
		var cluster_id = cluster;

		$.ajax({
			type: "POST",
			url: "script/handler.php",
			encoding:"UTF-8",
			data: {type : type, f_data : f_data, id : cluster_id},
			success: function(msg){		
				//$("#file_work_space").val(msg);									
				$("#window_dark").removeClass("start_window_dark");
				$("#file_window").removeClass("start_file_window");				
			}
		});
	}

	this.openFile = function(data){
		var file_info = data.split("***")[1].split("$$$");
		var type = "open_file";

		$.ajax({
			type: "POST",
			url: "script/handler.php",
			encoding:"UTF-8",
			data: {type:type, f_name:file_info[0], begin_cluster:file_info[1]},
			success: function(msg){
				$("#file_work_space").val("");
				$("#file_name").text(file_info[0]+".txt");
				$("#file_work_space").val(msg);
				$("#file_begin_cluster").val(file_info[1]);
				$("#window_dark").addClass("start_window_dark");
				$("#file_window").addClass("start_file_window");
			}
		});
	}

}


$(document).ready(function(){
	$("#close_file").click(function(){
		$("#window_dark").removeClass("start_window_dark");
		$("#file_window").removeClass("start_file_window");
	});

	$("#save_file").click(function() {
		var f_data = $("#file_work_space").val();
		var b_cluster = $("#file_begin_cluster").val();

		var fil = new Fil();
		fil.send_file_data(f_data, b_cluster);
		
	});

});
