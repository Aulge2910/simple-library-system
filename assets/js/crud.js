function getresult(url) {
	$('#loader').show();
	$.ajax({
		url: url,
		type: "POST",
		data: { rowcount: $("#rowcount").val(), name: $("#name").val(), code: $("#code").val() },
		success: function(data) {
			$(".search-item ").html(data); $('#add-form').hide(); $('#loader').hide();
		}
	});
}
getresult("getresult.php");
 