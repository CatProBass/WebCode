<?
include "inc/restrict.php";
include "inc/functions.php";
conectar();
$idpaciente=1;
$user=json_decode(getuser($_SESSION['usrtoken']));
 $contacts= (getusersbypatient($idpaciente)); //no sé porqué cojones no me hace el json en esta llamda...
 $messagest=json_decode(getmessagesto($user->id));
$messagesf=json_decode(getmessagesfrom($user->id));
$unread=json_decode(getunreadmessages($user->id));

 
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900' rel='stylesheet' type='text/css'>
<title>TFG</title>
</head>

<body>
 <? include "navbar.php";?>
    <div id="headerwrap"> <? include "paciente.php";?>
		<div class="container">
<div class="row inbox">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-body inbox-menu">						
				<a href="javascript:shownewmessage()" class="btn btn-danger btn-block">Nuevo mensaje</a>
				<ul>
					<li>
						<a href="javascript:showinbox()"><i class="fa fa-inbox"></i> Bandeja de entrada<span class="label label-danger"><?=count($unread);?></span></a>
					</li>
					 
					<li>
						<a href="#"><i class="fa fa-rocket"></i> Mensajes enviados</a>
					</li>
				 
				 
				 
				 
				</ul>
			</div>	
		</div>
		
 		<div class="panel panel-default widget mensajes">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-comment"></span>
                <h3 class="panel-title">
                 Últimos  Mensajes</h3>
            
                    
            </div>
    <div class="panel-body">
                <ul class="list-group">
                 <?
					
					
				 
					foreach($messagest as $msg){?>   <li class="list-group-item" id="msg<?=$msg->id;?>">
                        <div class="row">
                            <div class="col-xs-2 col-md-1">
                                <img src="img/profiles/<?=$msg->user_from;?>.jpg" class="img-circle img-responsive" alt="" /></div>
                            <div class="col-xs-10 col-md-11">
                                <div>      
                                   
                                    <?=$msg->subject;?>
                                  
                                    <div class="mic-info">
                                        De: <a href="#"><?=$msg->name;?></a> el <?=date("d-m-Y h:i",strtotime($msg->date));?>
                                    </div>
                              </div>
                              <div class="comment-text">
                                  <?=$msg->body;?>
                                </div>
                               
                        
    <a  class="btn btn-sm btn-hover btn-primary" href="javascript:replymessage(<?=$msg->id;?>,' <?=($msg->subject);?>',<?=($msg->user_from);?>)" ><span class="glyphicon glyphicon-share-alt" style="padding-right:3px;"></span>Responder</a>
      <a href="#" class="btn btn-sm btn-hover btn-danger"><span class="glyphicon glyphicon-remove" style="padding-right:3px;"></span>Borrar</a>
      
                              
                            </div>
                        </div>
                    </li>
                    
                    
                    <?}?>
                </ul>
                
            </div></div>
		
	</div><!--/.col-->
	<div class="clearfix"></div>
    	   
    
    
    
	<div class="col-md-9"><form class="form-horizontal" role="form">
		<div class="panel panel-default newmessage">
			<div class="panel-body message">
				<p class="text-center">Nuevo mensaje</p>
				
					<div class="form-group">
				    	<label for="to" class="col-sm-1 control-label">Destinatario:</label> 

				    	<div class="col-sm-11">
                              <select class="form-control select2-offscreen" id="to" tabindex="-1"><option value="">-</option>
                              <? foreach($contacts as $contact){
								  if($contact['id']!=$user->id){
								  ?>
                              <option value="<?=$contact['id'];?>"><?=$contact['name'];?> <?=$contact['surname'];?></option>
                              <?}}?>
                              </select>
				    	</div>
				  	</div>
					 
		 
				  	<div class="form-group">
				    	<label for="subject" class="col-sm-1 control-label">Asunto:</label> 

				    	<div class="col-sm-11">
                              <input type="text" class="form-control select2-offscreen" id="subject" placeholder="Asunto" tabindex="-1">
				    	</div>
				  	</div>
	
				  				<div class="form-group"><label for="message" class="col-sm-1 control-label">Mensaje:</label> 
			
			<div class="col-sm-11">
					

			
						<textarea class="form-control" id="message" name="message" rows="12" placeholder="Mensaje"></textarea>
					</div>	<div class="form-group">	
 <div class="col-lg-10 col-lg-offset-2">
				<div class="botonenvio">
						<button type="button" class="btn btn-success">Enviar</button> </div>
					</div></div>
				</div>	
			</div>	
		</div>				</form>
	</div><!--/.col-->		
</div>
</div>
	</div><!-- /headerwrap -->
    
     <? include "javascript.php";?>        <? include "footer.php";?>
     <script>
$(".botonenvio").click(
function(e){
fsendmessage($("#to").val(),$("#subject").val(),$("#message").val());
	}
);
	 
	 
	 </script>
</body>
<? desconectar();?>
</html>