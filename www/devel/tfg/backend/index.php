<? 

include "../inc/functions.php";
$idpaciente=1;conectar();
$patient=json_decode(getpatient($idpaciente));


//TODO ESTO LUEGO A FUNCTIONS
function getLastWeekDates()
{
	$days=8;
    $lastWeek = array();
  $m = date("m"); $de= date("d"); $y= date("Y");
 
    for($i=0; $i<=$days-1; $i++){
        $lastWeek[] =  date("Y-m-d", mktime(0,0,0,$m,($de-$i),$y)) ; 
		 
    }
    return array_reverse($lastWeek);
 
    // create the dates from Monday to Sunday
   
 
   // return $lastWeek;
}
if($_REQUEST['lastweek']==1 || empty($_REQUEST['datefrom'])){
$rangofechas=getLastWeekDates();
$date1=date("Y-m-d",strtotime($rangofechas[0]));
$date2=date("Y-m-d",strtotime($rangofechas[6]));
}

if(!empty($_REQUEST['datefrom']) && !empty($_REQUEST['dateto'])){
		$date1=$_REQUEST['datefrom'];
$date2=$_REQUEST['dateto'];
	$rangofechas = date_range($date1, $date2, "+1 day", "Y-m-d");
 




	
}

 
 $vitalsigns=json_decode(get_patient_daily_signs_date($idpaciente,$date1,$date2));
 $meals=json_decode(getmealtypes());
 
 
 //print_r($vitalsigns);
$temperature=array();
$pressure=array();
$heartrate=array();
 $saturation=array();
 foreach($vitalsigns as $vs){
	 array_push($temperature,$vs->temperature);
	  array_push($heartrate,$vs->heartrate);
	  	  array_push($saturation,$vs->saturation);
		  	  	  array_push($pressure,$vs->pressure);
	 }
 $sleephours=json_decode(get_sleep_hours());
//print_r($temperature);
//
$heals=json_decode(getheals());

?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
  
    <title>TFG Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet" type="text/css" >
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
  <script src="../js/jquery-1.11.0.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="js/chart.js"></script> 
     <script src="js/moment.js"></script>
          <script src="js/bootstrap-datetimepicker.min.js"></script>
  <script src="js/funciones.js"></script>
    
</head>

  <body>

    <? include "navbar.php";?>


    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> TFG Backend <small> </small></h1>
          </div>
          <div class="col-md-2">
                   <div class="dropdown">
  
 
</div> 
          </div>
        </div>
      </div>
    </header>
<br>

  <section id="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="active">Dashboard</li>
      </ol>
    </div>
  </section>


<section id="main">
  <div class="container">
    <div class="row"><?
		  include "menulateral.php";?>
  

      <div class="col-md-9"><!--Latest User-->
<div class="panel panel-default">
  <div class="panel-heading" style="background-color: #66CC99";>
    <h3 class="panel-title"><?=$patient->name;?> <?=$patient->surname;?></h3>
  </div>
  
  <div class="panel-body">
  <div class="constantes seccion" id="constantes">
  <canvas id="constantes1" width="400" height="140"></canvas>
<script>
  var ctx = $("#constantes1");
  var constasteschart1 = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["<? 
		$d=1;
		foreach($rangofechas as $dia){echo $dia;
		if($d<count($rangofechas)){
echo		"\",\"";$d++;}}?>"],
        datasets: [{
            label: 'Temperatura',fill: false,
			backgroundColor:"#f00",
					borderColor: "#f00",
            data: [<? $_temperature=implode($temperature,",");
			 echo  $_temperature;
			?>] 
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

 <canvas id="constantes2" width="400" height="140"></canvas>
<script>
  var ctx = $("#constantes2");
  var constasteschart2 = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["<? 
		$d=1;
		foreach($rangofechas as $dia){echo $dia;
		if($d<count($rangofechas)){
echo		"\",\"";$d++;}}?>"],
        datasets: [{
            label: 'Ritmo cardíaco',fill: false,
			backgroundColor:"#00c",
					borderColor: "#00c",
            data: [<? $_heartrate=implode($heartrate,",");
			 echo  $_heartrate;
			?>] 
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

<canvas id="constantes3" width="400" height="140"></canvas>
<script>
  var ctx = $("#constantes3");
  var constasteschart3 = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["<? 
		$d=1;
		foreach($rangofechas as $dia){echo $dia;
		if($d<count($rangofechas)){
echo		"\",\"";$d++;}}?>"],
        datasets: [{
            label: 'Saturación',fill: false,
			backgroundColor:"#0fc",
					borderColor: "#0fc",
            data: [<? $_saturation=implode($saturation,",");
			 echo  $_saturation;
			?>] 
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>


  </div>
  
  <div class="meals seccion" id="ingesta"><h2>Ingesta</h2>
  <?
	  foreach($rangofechas as $dia){ 

?> 
      <div class="meal">
      <h4><?=$dia;?></h4>
      <?   foreach($meals as $meal){?>
      <div class="dailymeal">
      <strong><?=$meal->name;?></strong>
      <?
  $mealintake=json_decode(get_patient_meal_intake_date($idpaciente,$meal->id,date("Y-m-d",strtotime($dia))));
 
// print_r($mealintake);
  ?><?=$mealintake->name;?></div>
  <?}?>
   
  <div class="dailymeal water">
   <strong>Agua</strong>
     <?
  $waterintake=json_decode(get_patient_water_intake_date($idpaciente,$meal->id,date("Y-m-d",strtotime($dia))));
 
// print_r($mealintake);
  ?><?=$waterintake->name;?>
  </div> </div>
  <?}?><div class="clearfix"></div>
  </div>
 
  
  
  
  <div class="heals seccion" id="curas"><h2>Curas</h2>
  <?
	  foreach($rangofechas as $dia){ 

?> 
      <div class="heal">
      <h4><?=$dia;?></h4>
      <?   foreach($heals as $heal){?>
      <div class="dailyheal">
      <strong><?=$heal->name;?></strong>
      <?
  $patientheal=json_decode(get_patient_heal_date($idpaciente,$heal->id,date("Y-m-d",strtotime($dia))));
 
 
// print_r($mealintake);
  ?><? if(count($patientheal)>0){?>Sí<?}else{?>No<?}?></div>
  <?}?>
  <?
	$nails=json_decode(get_patient_nails_date($idpaciente,$dia));
									 
		  ?>
  <strong>Corte de uñas</strong> <?=$nails->name;?>
  </div>
  
  <?}?><div class="clearfix"></div>
  </div>
  
  
  
  <div class="stools seccion" id="deposiciones"><h2>Deposiciones</h2>
  <?
	  foreach($rangofechas as $dia){ 

?> 
      <div class="stool">
      <h4><?=$dia;?></h4>
     
      <div class="dailystool">
      <h3>Heces</h3>
      <?
  $stools=json_decode(get_patient_daily_stools_date($idpaciente,date("Y-m-d",strtotime($dia))));
 
 
// print_r($mealintake);
  ?> 
  <strong>Veces: </strong>  <? echo($stools->times);?><hr> <strong>Apariencia: </strong>   <? echo($stoolappearance[$stools->appearance]);?> <hr>
   <strong>Consistencia: </strong>  <? echo($stoolconsistency[$stools->consistency]);?> <hr>
</div>

  </div>
  
 <?}?> <div class="clearfix"></div> 
  </div>
 
  
  <div class="sleeps seccion" id="sueno"><h2>Sueño</h2>
  <?

	  foreach($rangofechas as $dia){ 

?> 
      <div class="sleep">
      <h4><?=$dia;?></h4>
     
      <div class="dailysleep">
  
      <?
 
 
  
$patientasleep=json_decode(get_patient_asleep_date($idpaciente,$dia));
$patientsh=json_decode(get_patient_sleep_hours_date($idpaciente,$dia));
// print_r($mealintake);
  ?> 
  <strong>Horas de sueño nocturnas: </strong> 
 <?=$patientsh->name;?><hr> <strong>¿Se ha mantenido despierto durante el día? : </strong> 
  <?
  if($patientasleep->asleep==""){ echo "";}else{if($patientasleep->asleep==0){?> No<?}else{?>Sí<?}}?> <hr>
 
</div>

  </div>
  
 <?}?> <div class="clearfix"></div> 
  </div>
  
  
  
  
   </div>
</div>

      </div>
    </div>
  </div>
</section>


  <footer id="footer">
 
  </footer>

  <script type="text/javascript">
            $(function () {
                $('#datetimepicker1,#datetimepicker2').datetimepicker({   locale: 'es',format:"YYYY-MM-DD"})  ;
				  $(".filtrar").click(filterbydate);
           
		   $(".b_lastweek").click(filterbyweek)
		   verstats("constantes");
		   
		    })</script> </body>
</html>
