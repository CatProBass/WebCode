<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
 $messages=json_decode(getmessagesto($user->id,5));
 $contacts= (getusersbypatient($idpaciente));		
					
				 
					foreach($messages as $msg){?>   <li class="list-group-item" id="message<?=$msg->id;?>">
                        <div class="row">
                            <div class="col-xs-2 col-md-1">
                                <img src="<?=SITE_URL;?>img/profiles/<?=$msg->user_from;?>.jpg" class="img-circle img-responsive" alt="" /></div>
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