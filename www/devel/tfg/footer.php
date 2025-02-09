<footer></footer>
  <script>  $(function(){if(supportsHTML5Storage()) { getlocalprofileimg();}else{
	 
		  getserverprofileimg('<?=$_SESSION['usrtoken'];?>');
		  
	  }
 		<?php if(!empty($_SESSION['usrtoken'])){?>	 selectpatient();<?php }else{?>
<? if(!homepage){?>loadProfile()<?}?>
	  <?}?>})
  </script>
  
  