function filterbydate(e){
document.location="index.php?datefrom="+$("#datefrom").val()+"&dateto="+$("#dateto").val();
	}
	
	function filterbyweek(e){
document.location="index.php?lastweek=1";
	}
	
	function verstats (id){$(".seccion:visible").css("display","none");$("#"+id).slideDown();}