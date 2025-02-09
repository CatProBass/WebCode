<?
 
include "../inc/functions.php";
conectar();
 
$guide=json_decode(getguide());
 
?>

<div class="row">
				<div class="col-lg-6">
					<h1>Pautas</h1> 
   <div class="panel-group" id="accordion">
   <? foreach ($guide as $g){?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$g->id;?>" class="panel-title expand">
           <div class="right-arrow pull-right">+</div>
          <a href="#"><?=$g->title_es;?></a>
        </h4>
      </div>
      <div id="collapse<?=$g->id;?>" class="panel-collapse collapse">
        <div class="panel-body"><?=$g->content_es;?></div>
      </div>
    </div>
    <?}?>
  </div> 
</div>
                 	
				</div>  