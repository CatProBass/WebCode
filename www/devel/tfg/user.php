<?
include "inc/restrict.php";
include "inc/functions.php";
conectar();
$idpaciente=1;
$user=json_decode(getuser($_SESSION['usrtoken']));
$patients=json_decode(getpatients($user->id));
$messages=json_decode(getmessagesto($user->id,5));
 $contacts= (getusersbypatient($idpaciente));
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
			<div class="row">
				<div class="col-lg-12">
					   <div class="userprofile">

<div class="panel panel-default">
  <div class="panel-heading">  <h4 >Perfil de usuario</h4></div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     <div class="col-sm-6">
                     <div  align="center"> <img alt="User Pic" src="img/profiles/<?=$user->id;?>.jpg" id="profile-image1" class="img-circle img-responsive"> 
                
                <input id="profile-image-upload" class="hidden" type="file">
 
         
                     
                     </div>
              
              <br>
    
              <!-- /input-group -->
            </div>
            <div class="col-sm-6 profile">
            <h4 class="text-center"><?=$user->username;?> </h4> 
              <span><p  class="text-center"><?=$user->rolname;?> </p></span>            
            </div>
            <div class="clearfix"></div>
            <hr style="margin:5px 0 5px 0;">
    
              
 

<div class="col-sm-5 col-xs-6 tital " >Email:</div><div class="col-sm-7"><?=$user->email;?></div>

  <div class="clearfix"></div>
<div class="bot-border"></div>
  <div class="clearfix"></div>
    <h3 class="text-center text-info">Pacientes</h3> 

  <div class="clearfix"></div>
<div class="bot-border"></div>
<? foreach($patients as $patient){?><div class="patientrow">
<div class="col-sm-12 col-xs-12 tital " >Nombre Paciente:</div>
<div class="col-sm-12"><?=$patient->name;?> <?=$patient->surname;?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-12 col-xs-12 tital " >Fecha de nacimiento:</div><div class="col-sm-12"><?=date("d-M-Y",strtotime($patient->birthdate));?></div>

 <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-12 col-xs-12 tital " >Patología:</div><div class="col-sm-12"><?=$patient->pathologyname;?></div><div class="clearfix"></div>
</div>
<?}?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
       
            
    </div> 
    </div>
</div>  
			 <!-- /col-lg-6 -->
                <div class="clearfix"></div>
				   <div class="panel panel-default widget">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-comment"></span>
                <h3 class="panel-title">
                 Últimos  Mensajes</h3>
            
                    
            </div>
            <div class="panel-body">
                <ul class="list-group">
                 <?
					
					
				 
					foreach($messages as $msg){?>   <li class="list-group-item" id="message<?=$msg->id;?>">
                        <div class="row">
                            <div class="col-xs-2 col-md-1">
                                <img src="img/profiles/<?=$msg->user_from;?>.jpg" class="img-circle img-responsive" alt="" /></div>
                            <div class="col-xs-10 col-md-11">
                                <div>
                                    
                                   
                                    <?=$msg->subject;?>
                                  
                                    <div class="mic-info">
                                        De: <a href="#"><?=$msg->name;?></a> el  <?=date("d-m-Y h:i",strtotime($msg->date));?>
                                    </div>
                              </div>
                              <div class="comment-text">
                                  <?=$msg->body;?>
                                </div>
                               
                        
    <a  class="btn btn-sm btn-hover btn-primary" href="javascript:replymessage(<?=$msg->id;?>,' <?=($msg->subject);?>',<?=($msg->user_from);?>)" ><span class="glyphicon glyphicon-share-alt" style="padding-right:3px;"></span>Responder</a>
      <a href="javascript:deletemessage(<?=$msg->id;?>)" class="btn btn-sm btn-hover btn-danger"><span class="glyphicon glyphicon-remove" style="padding-right:3px;"></span>Borrar</a>
      
                              
                            </div>
                        </div>
                    </li>
                    
                    
                    <?}?>
                </ul>
                
            </div>
            
            
            
            
        </div><form class="form-horizontal" role="form">
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
			</div><!-- /row -->
		</div><!-- /container -->
	</div><!-- /headerwrap -->
    
     <? include "javascript.php";?>        <? include "footer.php";?> <script>
$(".botonenvio").click(
function(e){
fsendmessage($("#to").val(),$("#subject").val(),$("#message").val());
	}
);
	 
	 
	 </script>
</body>
<? desconectar();?>
</html>