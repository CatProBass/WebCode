<?

error_reporting(E_ALL);ini_set('display_errors', 1);
$REQUEST_BODY='<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:dol="http://www.nestle.de/DolceGusto">
   <soap:Header>
      <dol:ServiceAuthHeader>
               <dol:Username>3pl_es</dol:Username>
          <dol:Password>9$]-BP.d\<p2$XNv</dol:Password>
      </dol:ServiceAuthHeader>
   </soap:Header>
   <soap:Body>
      <dol:PCMReward>
         <!--Optional:-->
         <dol:customerEmail>?</dol:customerEmail>
         <!--Optional:-->
         <dol:customerId>?</dol:customerId>
         <dol:PCMCode>?</dol:PCMCode>
         <dol:customerWebsiteCode>?</dol:customerWebsiteCode>
      </dol:PCMReward>
   </soap:Body>
</soap:Envelope>';
 
  $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
 
  $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
    );


try{
$soapclient = new SoapClient('https://www.dolce-gusto.es/services/api/index?wsdl', $soapClientOptions);
$response =$soapclient->GetCountriesAvailable();
var_dump($response);
echo '<br><br><br>';
$array = json_decode(json_encode($response), true);
print_r($array);
 
}catch(Exception $e){
    echo $e->getMessage();
}   
 
echo "ARG";
$wsdl = file_get_contents('https://www.dolce-gusto.es/services/api/index?wsdl');
echo $wsdl;
 

?>