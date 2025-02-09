        <div class="col-md-3">    <div class="list-group">
      <a href="index.html" class="list-group-item active main-color-bg"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
        Estadísticas paciente
      </a>
   
      <a href="javascript:verstats('constantes')" class="list-group-item"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> Constantes Vitales </a>
       <a href="javascript:verstats('ingesta')" class="list-group-item"><span class="glyphicon glyphicon-apple" aria-hidden="true"></span> Ingesta </a>
        <a href="javascript:verstats('curas')" class="list-group-item"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Curas </a>
         <a href="javascript:verstats('deposiciones')" class="list-group-item"><span class="glyphicon glyphicon-tint" aria-hidden="true"></span> Deposiciones </a>
          <a href="javascript:verstats('sueno')" class="list-group-item"><span class="glyphicon glyphicon-lamp" aria-hidden="true"></span> Sueño </a>
    </div>
    
 
    <nav class="timenav"> 
  <button class="btn-primary btn text-center b_lastweek" value="1"  >Última semana</button> 
     <div class="clearfix" style="margin-bottom:20px"></div>  
<label for="datefrom">Fecha de Inicio:</label>
                <div class='input-group date' id='datetimepicker1'>
                
                    <input type='text' class="form-control"    required="required"  id="datefrom" name="datefrom" value="<?=$date1;?>"/>  
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                <label for="dateto">Fecha fin:</label>
                <div class='input-group date' id='datetimepicker2'>
                
                    <input type='text' class="form-control"   required="required"   id="dateto" name="dateto" value="<?=$date2;?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div>    <button class="btn-primary btn text-center filtrar" value="1" >Filtrar</button> 
 <div class="clearfix"></div>   
  </nav> 
    
    
      </div>
      
      