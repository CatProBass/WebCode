<?
session_start();
unset($_SESSION['username']);
unset($_SESSION['usrtoken']);
 
?><html><head></head><body>
	
	<script>localStorage.clear();document.location='login.php'</script>
</body></html>