<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
 
 
 $contacts= (getusersbypatient($idpaciente)); //no sé porqué cojones no me hace el json en esta llamda...

 
$messagesf=json_decode(getmessagesfrom($user->id));
$unread=json_decode(getunreadmessages($user->id)); $messagest=json_decode(getmessagesto($user->id));

?>
 		<h1><span class="headermessenger"></span>Mensajería interna </h1><div class="clearfix"></div>
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
						<a href="javascript:showsent()"><i class="fa fa-rocket"></i> Mensajes enviados</a>
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
            
         <div class="panel panel-default widget enviados">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-comment"></span>
                <h3 class="panel-title">
                 Mensajes Enviados</h3>
            
                    
            </div>
    <div class="panel-body">
                <ul class="list-group">
                 <?
					
					
				 
					foreach($messagesf as $msg){?>   <li class="list-group-item" id="msg<?=$msg->id;?>">
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
 