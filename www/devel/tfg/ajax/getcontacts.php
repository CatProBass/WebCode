<?
 
include "../inc/functions.php";
conectar();
$user=json_decode(getuser($_POST['tkn']));
 $idpaciente=1;
 $contacts= (getusersbypatient($idpaciente));
 
 ?>    <select class="form-control select2-offscreen" id="to" tabindex="-1"><option value="">-</option>
                           <? foreach($contacts as $contact){
								  if($contact['id']!=$user->id){
								  ?>
                              <option value="<?=$contact['id'];?>"><?=$contact['name'];?> <?=$contact['surname'];?></option>
                              <?}}?>
                              </select>