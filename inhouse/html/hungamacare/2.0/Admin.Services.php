<?php
$SKIP = 1;
ini_set('display_errors','0');
$start = (float) array_sum(explode(' ',microtime())); 

require_once("incs/database.php");
//require_once("../../ContentBI/base.php");
require_once("../../cmis/base.php");
require_once("../incs/GraphColors-D.php");
require_once("../incs/citylist.php");
		  //sksort($Service_DESC);
	//print_r($_REQUEST);	  
if($_REQUEST['action']==1) {
	
				
			$Query = "select distinct type as type from base order by type ASC";
			$Get_Distinct = mysql_query($Query) or die(mysql_error());
			$DISTINCT = array();
			while($Data_Distinct = mysql_fetch_array($Get_Distinct)) {
				
				array_push($DISTINCT,$Data_Distinct['type']);
					
			}
	
		foreach($_REQUEST as $key=>$value) {
			if(in_array($key,$DISTINCT)) {
				//echo $key."=".$value."<br>";	
				
				mysql_query("INSERT INTO base (service, type, value) VALUES ('".$_REQUEST['Service']."','".$key."','".addslashes($value)."') ON DUPLICATE KEY UPDATE value='".addslashes($value)."';") or die(mysql_error());
				
				
			}
		}
	//exit;
		@mysql_query("update base set value=replace(value,'\\\','')") or die(mysql_error());
	
}
		  
		  

?><html>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link href="assets/css/bootstrap.css" rel="stylesheet" />
 
  <link href="assets/css/style.css" rel="stylesheet" />
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<link href="assets/css/datepicker.css" rel="stylesheet" />
<link href="assets/css/icons-sprites.css" rel="stylesheet" />
<link href="assets/css/token-input.css" rel="stylesheet" />
<link rel="stylesheet" href="assets/css/base.css" type="text/css" media="all" charset="utf-8" />
 <!-- <link rel="stylesheet/less" href="assets/css/tokeninput-theme.less" type="text/css" />

<script src="assets/js/less.js"></script> -->

<script type="text/javascript">
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}

function toggleAll(val,stag) {

var inputEls = document.getElementsByTagName('input');
for (var i = 0, tEl; tEl = inputEls[i]; i++) {
	inp = tEl.value;
	//alert(inp);
if (tEl.type == 'checkbox' && inp.indexOf(val) != -1) {
		if(tEl.checked == true) {
			tEl.checked = false;	
		} else{
			tEl.checked = true;	

		}
}
}
}

</script>
<style>
.px12 {
 font-size: 12px;	
}
</style>

<body><br><br><div class="container-fluid">
<div>

  
   <?php if($MSG) {?> <tr>
      <div class="alert  alert-success"><?php echo $MSG;?></div>
    </tr>
    <?php } ?>
   
   <form name="form" id="form"><div class="alert">You are current viewing details for 
  <select name="jumpMenu" style="font-size: 11px" id="jumpMenu">
    <?php 
	
			
		$Query_Distinct = "select distinct service, value from base where type='Name' order by value ASC";
		$Get_Distinct = mysql_query($Query_Distinct) or die(mysql_error());
		$DISTINCT = array();
		while($Data_Distinct = mysql_fetch_array($Get_Distinct)) {
			
		$Service=$Data_Distinct['service'];
		$Name=$Data_Distinct['value'];
				
		
		
	?><option value="Admin.Services.php?Service=<?php echo $Service;?>" <?php if(strcmp($_REQUEST['Service'],$Service) == 0) {echo "selected";} ?> ><?php echo $Name;?></option>
    <?php } ?>
  </select>
  <input name="go_button" type="button" class="btn btn-primary" id= "go_button" onClick="MM_jumpMenuGo('jumpMenu','parent',0)" value="Go">
</div></form>

	<?php if($_REQUEST['action'] == 1) {?> <tr>
      <div class="alert  alert-success">Updated Records for Service <?php echo $_REQUEST['Service'];?></div>
    </tr>
    <?php } ?>
	<div class="alert  alert-error"><a href="javascript:;" onClick="$.fn.RegenerateBase()">Regenerate Base</a>&nbsp;<span id="BaseAjax"></span></div>

  <?php
if($_REQUEST['Service']) {
		$SelectedService=$_REQUEST['Service'];

	$Query = mysql_query("select type, value from base where service='".$SelectedService."'") or die(mysql_error());
	unset($Service_DESC);
	$Service_DESC = array();
	while($Result=mysql_fetch_array($Query)) {
		$Service_DESC[$SelectedService][$Result['type']] = $Result['value'];	
	}
	
	if($Service_DESC[$SelectedService]["Currency"]) {
		$Currency = $Service_DESC[$SelectedService]["Currency"];
	} else{
		$Currency = 'INR';	
	}
	
	
?> 

    <form action="Admin.Services.php" method="post">

	  <input name="action" type="hidden" id="action" value="1">
	  <input name="Service" type="hidden" id="Service" value="<?php echo $SelectedService;?>">
       
<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active"><a href="#tab1" data-toggle="tab">Service Profile</a></li>
    <li><a href="#tab2" data-toggle="tab">Tables</a></li>
    <li><a href="#tab3" data-toggle="tab">Service Options</a></li>
    <li><a href="#tab4" data-toggle="tab">Content</a></li>
    <li><a href="#tab5" data-toggle="tab">Shceduled Tasks</a></li>
    <li><a href="#tab6" data-toggle="tab">Mailing List</a></li>
    <li><a href="#tab7" data-toggle="tab">User Manager</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab1">
	
        <table class="table px12">
 			<tr>
            <td>Service Name</td>
            <td><input name="Name" type="text" id="Name" value="<?php echo $Service_DESC[$SelectedService]['Name'];?>" /></td>
            <td>Account Owner</td>
            <td><select name="Account" style="font-size: 11px">
    <?php 
	$Q = mysql_query("select username,ac_flag, concat(fname, ' ', IF(lname IS NOT NULL,lname,'')) as Name from usermanager order by ac_flag DESC, username ASC") or die(mysql_error());
	$OtherPeople =array();
	while($S = mysql_fetch_array($Q)) {
		if(!in_array($S['username'],$OtherPeople) && strcmp($_GET['username'],$S['username']) != 0) {
		array_push($OtherPeople,$S['username']);	
		}
	?><option value="<?php echo $S["username"];?>" <?php if(strcmp($Service_DESC[$SelectedService]['Account'],$S["username"]) == 0) {echo "selected";} ?> ><?php if($S["ac_flag"] == 0) {  echo "[x] ";}?><?php echo $S["Name"];?></option>
    <?php } ?>
  </select>
            </td>
            <td>Account Director</td>
            <td><select name="RBH" style="font-size: 11px"><?php 
			$Q = mysql_query("select username,ac_flag, concat(fname, ' ', IF(lname IS NOT NULL,lname,'')) as Name from usermanager order by ac_flag DESC, username ASC") or die(mysql_error());
			while($S = mysql_fetch_array($Q)) {
		if(!in_array($S['username'],$OtherPeople) && strcmp($_GET['username'],$S['username']) != 0) {
		array_push($OtherPeople,$S['username']);	
		}
	?><option value="<?php echo $S["username"];?>" <?php if(strcmp($Service_DESC[$SelectedService]['RBH'],$S["username"]) == 0) {echo "selected";} ?> ><?php if($S["ac_flag"] == 0) {  echo "[x] ";}?><?php echo $S["Name"];?></option>
    <?php } ?>
  </select></td>
            </tr>
            
            <tr>
            
            <td>Input MAP File</td>
            <td><select name="map_details" style="font-size: 11px"><?php
            $directory = "../../cmis/maps/";
 
			//get all image files with a .jpg extension.
			$Input = glob($directory . "*.call.php");
			 
			//print each file name
			foreach($Input as $input)
			{
				$input = str_replace($directory,"",$input);
			?>
			<option value="<?php echo $input;?>" <?php if(strcmp(strtolower($Service_DESC[$SelectedService]['map_details']),strtolower($input)) == 0) {echo "selected";} ?>><?php echo $input;?></option><?php 
			}
			?></select></td>
            
            <td>Output MAP File</td>
            <td><select name="map_output" style="font-size: 11px"><?php
            $directory = "../../cmis/maps/";
 
			//get all image files with a .jpg extension.
			$Output = glob($directory . "*.output.php");
			 
			//print each file name
			foreach($Output as $output)
			{
				$output = str_replace($directory,"",$output);
			?>
			<option value="<?php echo $output;?>" <?php if(strcmp(strtolower($Service_DESC[$SelectedService]['map_output']),strtolower($output)) == 0) {echo "selected";} ?>><?php echo $output;?></option><?php 
			}
			?></select></td>
            <td>Currency</td>
            <td><select id="Currency" name="Currency">
        
            <option value="INR" selected>
                INR - 
                Indian Rupee
            </option>
        
            <option value="separator" disabled="">
                
                --------------------------------
            </option>
        
            <option value="USD">
                USD - 
                US Dollar
            </option>
        
            <option value="EUR">
                EUR - 
                Euro
            </option>
        
            <option value="GBP">
                GBP - 
                British Pound
            </option>
        
            <option value="CHF">
                CHF - 
                Swiss Franc
            </option>
        
            <option value="JPY">
                JPY - 
                Japanese Yen
            </option>
        
            <option value="CAD">
                CAD - 
                Canadian Dollar
            </option>
        
            <option value="AUD">
                AUD - 
                Australian Dollar
            </option>
        
            <option value="CNY">
                CNY - 
                Chinese Yuan Renminbi
            </option>
        
            <option value="SGD">
                SGD - 
                Singapore Dollar
            </option>
        
            <option value="HKD">
                HKD - 
                Hong Kong Dollar
            </option>
        
            <option value="separator" disabled="">
                
                --------------------------------
            </option>
        
            <option value="AFN">
                AFN - 
                Afghanistan Afghani
            </option>
        
            <option value="AFA">
                AFA - 
                Afghanistan Afghani
            </option>
        
            <option value="ALL">
                ALL - 
                Albanian Lek
            </option>
        
            <option value="DZD">
                DZD - 
                Algerian Dinar
            </option>
        
            <option value="ADF">
                ADF - 
                Andorran Franc
            </option>
        
            <option value="ADP">
                ADP - 
                Andorran Peseta
            </option>
        
            <option value="AOA">
                AOA - 
                Angolan Kwanza
            </option>
        
            <option value="AON">
                AON - 
                Angolan Old Kwanza
            </option>
        
            <option value="ARS">
                ARS - 
                Argentine Peso
            </option>
        
            <option value="AMD">
                AMD - 
                Armenian Dram
            </option>
        
            <option value="AWG">
                AWG - 
                Aruban Florin
            </option>
        
            <option value="AUD">
                AUD - 
                Australian Dollar
            </option>
        
            <option value="ATS">
                ATS - 
                Austrian Schilling
            </option>
        
            <option value="AZN">
                AZN - 
                Azerbaijan New Manat
            </option>
        
            <option value="AZM">
                AZM - 
                Azerbaijan Old Manat
            </option>
        
            <option value="BSD">
                BSD - 
                Bahamian Dollar
            </option>
        
            <option value="BHD">
                BHD - 
                Bahraini Dinar
            </option>
        
            <option value="BDT">
                BDT - 
                Bangladeshi Taka
            </option>
        
            <option value="BBD">
                BBD - 
                Barbados Dollar
            </option>
        
            <option value="BYR">
                BYR - 
                Belarusian Ruble
            </option>
        
            <option value="BEF">
                BEF - 
                Belgian Franc
            </option>
        
            <option value="BZD">
                BZD - 
                Belize Dollar
            </option>
        
            <option value="BMD">
                BMD - 
                Bermudian Dollar
            </option>
        
            <option value="BTN">
                BTN - 
                Bhutan Ngultrum
            </option>
        
            <option value="BOB">
                BOB - 
                Bolivian Boliviano
            </option>
        
            <option value="BAM">
                BAM - 
                Bosnian Mark
            </option>
        
            <option value="BWP">
                BWP - 
                Botswana Pula
            </option>
        
            <option value="BRL">
                BRL - 
                Brazilian Real
            </option>
        
            <option value="GBP">
                GBP - 
                British Pound
            </option>
        
            <option value="BND">
                BND - 
                Brunei Dollar
            </option>
        
            <option value="BGN">
                BGN - 
                Bulgarian Lev
            </option>
        
            <option value="BGL">
                BGL - 
                Bulgarian Old Lev
            </option>
        
            <option value="BIF">
                BIF - 
                Burundi Franc
            </option>
        
            <option value="XOF">
                XOF - 
                CFA Franc BCEAO
            </option>
        
            <option value="XAF">
                XAF - 
                CFA Franc BEAC
            </option>
        
            <option value="XPF">
                XPF - 
                CFP Franc
            </option>
        
            <option value="KHR">
                KHR - 
                Cambodian Riel
            </option>
        
            <option value="CAD">
                CAD - 
                Canadian Dollar
            </option>
        
            <option value="CVE">
                CVE - 
                Cape Verde Escudo
            </option>
        
            <option value="KYD">
                KYD - 
                Cayman Islands Dollar
            </option>
        
            <option value="CLP">
                CLP - 
                Chilean Peso
            </option>
        
            <option value="CNY">
                CNY - 
                Chinese Yuan Renminbi
            </option>
        
            <option value="COP">
                COP - 
                Colombian Peso
            </option>
        
            <option value="KMF">
                KMF - 
                Comoros Franc
            </option>
        
            <option value="CDF">
                CDF - 
                Congolese Franc
            </option>
        
            <option value="CRC">
                CRC - 
                Costa Rican Colon
            </option>
        
            <option value="HRK">
                HRK - 
                Croatian Kuna
            </option>
        
            <option value="CUC">
                CUC - 
                Cuban Convertible Peso
            </option>
        
            <option value="CUP">
                CUP - 
                Cuban Peso
            </option>
        
            <option value="CYP">
                CYP - 
                Cyprus Pound
            </option>
        
            <option value="CZK">
                CZK - 
                Czech Koruna
            </option>
        
            <option value="DKK">
                DKK - 
                Danish Krone
            </option>
        
            <option value="DJF">
                DJF - 
                Djibouti Franc
            </option>
        
            <option value="DOP">
                DOP - 
                Dominican R. Peso
            </option>
        
            <option value="NLG">
                NLG - 
                Dutch Guilder
            </option>
        
            <option value="XEU">
                XEU - 
                ECU
            </option>
        
            <option value="XCD">
                XCD - 
                East Caribbean Dollar
            </option>
        
            <option value="ECS">
                ECS - 
                Ecuador Sucre
            </option>
        
            <option value="EGP">
                EGP - 
                Egyptian Pound
            </option>
        
            <option value="SVC">
                SVC - 
                El Salvador Colon
            </option>
        
            <option value="EEK">
                EEK - 
                Estonian Kroon
            </option>
        
            <option value="ETB">
                ETB - 
                Ethiopian Birr
            </option>
        
            <option value="EUR">
                EUR - 
                Euro
            </option>
        
            <option value="FKP">
                FKP - 
                Falkland Islands Pound
            </option>
        
            <option value="FJD">
                FJD - 
                Fiji Dollar
            </option>
        
            <option value="FIM">
                FIM - 
                Finnish Markka
            </option>
        
            <option value="FRF">
                FRF - 
                French Franc
            </option>
        
            <option value="GMD">
                GMD - 
                Gambian Dalasi
            </option>
        
            <option value="GEL">
                GEL - 
                Georgian Lari
            </option>
        
            <option value="DEM">
                DEM - 
                German Mark
            </option>
        
            <option value="GHC">
                GHC - 
                Ghanaian Cedi
            </option>
        
            <option value="GHS">
                GHS - 
                Ghanaian New Cedi
            </option>
        
            <option value="GIP">
                GIP - 
                Gibraltar Pound
            </option>
        
            <option value="XAU">
                XAU - 
                Gold (oz.)
            </option>
        
            <option value="GRD">
                GRD - 
                Greek Drachma
            </option>
        
            <option value="GTQ">
                GTQ - 
                Guatemalan Quetzal
            </option>
        
            <option value="GNF">
                GNF - 
                Guinea Franc
            </option>
        
            <option value="GYD">
                GYD - 
                Guyanese Dollar
            </option>
        
            <option value="HTG">
                HTG - 
                Haitian Gourde
            </option>
        
            <option value="HNL">
                HNL - 
                Honduran Lempira
            </option>
        
            <option value="HKD">
                HKD - 
                Hong Kong Dollar
            </option>
        
            <option value="HUF">
                HUF - 
                Hungarian Forint
            </option>
        
            <option value="ISK">
                ISK - 
                Iceland Krona
            </option>
        
            
        
            <option value="IDR">
                IDR - 
                Indonesian Rupiah
            </option>
        
            <option value="IRR">
                IRR - 
                Iranian Rial
            </option>
        
            <option value="IQD">
                IQD - 
                Iraqi Dinar
            </option>
        
            <option value="IEP">
                IEP - 
                Irish Punt
            </option>
        
            <option value="ILS">
                ILS - 
                Israeli New Shekel
            </option>
        
            <option value="ITL">
                ITL - 
                Italian Lira
            </option>
        
            <option value="JMD">
                JMD - 
                Jamaican Dollar
            </option>
        
            <option value="JPY">
                JPY - 
                Japanese Yen
            </option>
        
            <option value="JOD">
                JOD - 
                Jordanian Dinar
            </option>
        
            <option value="KZT">
                KZT - 
                Kazakhstan Tenge
            </option>
        
            <option value="KES">
                KES - 
                Kenyan Shilling
            </option>
        
            <option value="KWD">
                KWD - 
                Kuwaiti Dinar
            </option>
        
            <option value="KGS">
                KGS - 
                Kyrgyzstanian Som
            </option>
        
            <option value="LAK">
                LAK - 
                Lao Kip
            </option>
        
            <option value="LVL">
                LVL - 
                Latvian Lats
            </option>
        
            <option value="LBP">
                LBP - 
                Lebanese Pound
            </option>
        
            <option value="LSL">
                LSL - 
                Lesotho Loti
            </option>
        
            <option value="LRD">
                LRD - 
                Liberian Dollar
            </option>
        
            <option value="LYD">
                LYD - 
                Libyan Dinar
            </option>
        
            <option value="LTL">
                LTL - 
                Lithuanian Litas
            </option>
        
            <option value="LUF">
                LUF - 
                Luxembourg Franc
            </option>
        
            <option value="MOP">
                MOP - 
                Macau Pataca
            </option>
        
            <option value="MKD">
                MKD - 
                Macedonian Denar
            </option>
        
            <option value="MGA">
                MGA - 
                Malagasy Ariary
            </option>
        
            <option value="MGF">
                MGF - 
                Malagasy Franc
            </option>
        
            <option value="MWK">
                MWK - 
                Malawi Kwacha
            </option>
        
            <option value="MYR">
                MYR - 
                Malaysian Ringgit
            </option>
        
            <option value="MVR">
                MVR - 
                Maldive Rufiyaa
            </option>
        
            <option value="MTL">
                MTL - 
                Maltese Lira
            </option>
        
            <option value="MRO">
                MRO - 
                Mauritanian Ouguiya
            </option>
        
            <option value="MUR">
                MUR - 
                Mauritius Rupee
            </option>
        
            <option value="MXN">
                MXN - 
                Mexican Peso
            </option>
        
            <option value="MDL">
                MDL - 
                Moldovan Leu
            </option>
        
            <option value="MNT">
                MNT - 
                Mongolian Tugrik
            </option>
        
            <option value="MAD">
                MAD - 
                Moroccan Dirham
            </option>
        
            <option value="MZM">
                MZM - 
                Mozambique Metical
            </option>
        
            <option value="MZN">
                MZN - 
                Mozambique New Metical
            </option>
        
            <option value="MMK">
                MMK - 
                Myanmar Kyat
            </option>
        
            <option value="ANG">
                ANG - 
                NL Antillian Guilder
            </option>
        
            <option value="NAD">
                NAD - 
                Namibia Dollar
            </option>
        
            <option value="NPR">
                NPR - 
                Nepalese Rupee
            </option>
        
            <option value="NZD">
                NZD - 
                New Zealand Dollar
            </option>
        
            <option value="NIO">
                NIO - 
                Nicaraguan Cordoba Oro
            </option>
        
            <option value="NGN">
                NGN - 
                Nigerian Naira
            </option>
        
            <option value="KPW">
                KPW - 
                North Korean Won
            </option>
        
            <option value="NOK">
                NOK - 
                Norwegian Kroner
            </option>
        
            <option value="OMR">
                OMR - 
                Omani Rial
            </option>
        
            <option value="PKR">
                PKR - 
                Pakistan Rupee
            </option>
        
            <option value="XPD">
                XPD - 
                Palladium (oz.)
            </option>
        
            <option value="PAB">
                PAB - 
                Panamanian Balboa
            </option>
        
            <option value="PGK">
                PGK - 
                Papua New Guinea Kina
            </option>
        
            <option value="PYG">
                PYG - 
                Paraguay Guarani
            </option>
        
            <option value="PEN">
                PEN - 
                Peruvian Nuevo Sol
            </option>
        
            <option value="PHP">
                PHP - 
                Philippine Peso
            </option>
        
            <option value="XPT">
                XPT - 
                Platinum (oz.)
            </option>
        
            <option value="PLN">
                PLN - 
                Polish Zloty
            </option>
        
            <option value="PTE">
                PTE - 
                Portuguese Escudo
            </option>
        
            <option value="QAR">
                QAR - 
                Qatari Rial
            </option>
        
            <option value="ROL">
                ROL - 
                Romanian Lei
            </option>
        
            <option value="RON">
                RON - 
                Romanian New Lei
            </option>
        
            <option value="RUB">
                RUB - 
                Russian Rouble
            </option>
        
            <option value="RWF">
                RWF - 
                Rwandan Franc
            </option>
        
            <option value="WST">
                WST - 
                Samoan Tala
            </option>
        
            <option value="STD">
                STD - 
                Sao Tome/Principe Dobra
            </option>
        
            <option value="SAR">
                SAR - 
                Saudi Riyal
            </option>
        
            <option value="RSD">
                RSD - 
                Serbian Dinar
            </option>
        
            <option value="SCR">
                SCR - 
                Seychelles Rupee
            </option>
        
            <option value="SLL">
                SLL - 
                Sierra Leone Leone
            </option>
        
            <option value="XAG">
                XAG - 
                Silver (oz.)
            </option>
        
            <option value="SGD">
                SGD - 
                Singapore Dollar
            </option>
        
            <option value="SKK">
                SKK - 
                Slovak Koruna
            </option>
        
            <option value="SIT">
                SIT - 
                Slovenian Tolar
            </option>
        
            <option value="SBD">
                SBD - 
                Solomon Islands Dollar
            </option>
        
            <option value="SOS">
                SOS - 
                Somali Shilling
            </option>
        
            <option value="ZAR">
                ZAR - 
                South African Rand
            </option>
        
            <option value="KRW">
                KRW - 
                South-Korean Won
            </option>
        
            <option value="ESP">
                ESP - 
                Spanish Peseta
            </option>
        
            <option value="LKR">
                LKR - 
                Sri Lanka Rupee
            </option>
        
            <option value="SHP">
                SHP - 
                St. Helena Pound
            </option>
        
            <option value="SDD">
                SDD - 
                Sudanese Dinar
            </option>
        
            <option value="SDP">
                SDP - 
                Sudanese Old Pound
            </option>
        
            <option value="SDG">
                SDG - 
                Sudanese Pound
            </option>
        
            <option value="SRD">
                SRD - 
                Suriname Dollar
            </option>
        
            <option value="SRG">
                SRG - 
                Suriname Guilder
            </option>
        
            <option value="SZL">
                SZL - 
                Swaziland Lilangeni
            </option>
        
            <option value="SEK">
                SEK - 
                Swedish Krona
            </option>
        
            <option value="CHF">
                CHF - 
                Swiss Franc
            </option>
        
            <option value="SYP">
                SYP - 
                Syrian Pound
            </option>
        
            <option value="TWD">
                TWD - 
                Taiwan Dollar
            </option>
        
            <option value="TJS">
                TJS - 
                Tajikistani Somoni
            </option>
        
            <option value="TZS">
                TZS - 
                Tanzanian Shilling
            </option>
        
            <option value="THB">
                THB - 
                Thai Baht
            </option>
        
            <option value="TOP">
                TOP - 
                Tonga Pa'anga
            </option>
        
            <option value="TTD">
                TTD - 
                Trinidad/Tobago Dollar
            </option>
        
            <option value="TND">
                TND - 
                Tunisian Dinar
            </option>
        
            <option value="TRY">
                TRY - 
                Turkish Lira
            </option>
        
            <option value="TRL">
                TRL - 
                Turkish Old Lira
            </option>
        
            <option value="TMM">
                TMM - 
                Turkmenistan Manat
            </option>
        
            <option value="TMT">
                TMT - 
                Turkmenistan New Manat
            </option>
        
            <option value="USD">
                USD - 
                US Dollar
            </option>
        
            <option value="UGX">
                UGX - 
                Uganda Shilling
            </option>
        
            <option value="UAH">
                UAH - 
                Ukraine Hryvnia
            </option>
        
            <option value="UYU">
                UYU - 
                Uruguayan Peso
            </option>
        
            <option value="AED">
                AED - 
                Utd. Arab Emir. Dirham
            </option>
        
            <option value="UZS">
                UZS - 
                Uzbekistan Som
            </option>
        
            <option value="VUV">
                VUV - 
                Vanuatu Vatu
            </option>
        
            <option value="VEB">
                VEB - 
                Venezuelan Bolivar
            </option>
        
            <option value="VEF">
                VEF - 
                Venezuelan Bolivar Fuerte
            </option>
        
            <option value="VND">
                VND - 
                Vietnamese Dong
            </option>
        
            <option value="YER">
                YER - 
                Yemeni Rial
            </option>
        
            <option value="YUN">
                YUN - 
                Yugoslav Dinar
            </option>
        
            <option value="ZMK">
                ZMK - 
                Zambian Kwacha
            </option>
        
            <option value="ZWD">
                ZWD - 
                Zimbabwe Dollar
            </option>
        
    </select></td>
            </tr>
            
            
            
            <tr>
            <td valign="middle">Logo</td>
            <td><input type="text" name="Logo" value="<?php echo $Service_DESC[$SelectedService]['Logo'];?>" /></td>
            
            
            <td colspan="2"><?php if(file_exists('../../cmis/img/'.$Service_DESC[$SelectedService]['Logo'])) {
				?><img src="<?php echo '../../cmis/img/'.$Service_DESC[$SelectedService]['Logo'];?>" border="0" align="top" />
                <?php
			} ?></td>
            
            
            <td></td>
            <td></td>
            </tr>
            <tr>
              <td colspan="6" valign="middle"></td>
              </tr>
            </table>
          
  </div>
    <div class="tab-pane" id="tab2">
      			<table class="table px12">
 			<tr>
            <th colspan="4">Calling Tables</th>
            </tr>
 			<tr>
            <td>Calling Table</td>
            <td><select name="CallingTable" id="CallingTable">
            <option value="">No Table</option>
            <?php
			$Q = mysql_query("show tables where tables_in_misdata like 'tbl_calling%' ") or die(mysql_error());
			while($S = mysql_fetch_array($Q)) {
			?>
            <option value="<?php echo $S['Tables_in_misdata'];?>" <?php if(strcmp($Service_DESC[$SelectedService]['CallingTable'],$S["Tables_in_misdata"]) == 0) {echo "selected";} ?>><?php echo $S['Tables_in_misdata'];?></option><?php } ?>
            </select></td>
            <td>Calling Table Extra</td>
            <td><input type="text" name="CallingTableExtra" value="<?php echo stripslashes($Service_DESC[$SelectedService]['CallingTableExtra']);?>" /></td>
            </tr>
            <tr>
            <th colspan="4">Billing Tables</th>
            </tr>
            <tr>
            <td>Billing Table</td>
            <td><select name="BillingTable" id="BillingTable">
            <option value="">No Table</option>
            <?php
			$Q = mysql_query("show tables where tables_in_misdata like 'tbl_billing%' ") or die(mysql_error());
			while($S = mysql_fetch_array($Q)) {
			?>
            <option value="<?php echo $S['Tables_in_misdata'];?>" <?php if(strcmp($Service_DESC[$SelectedService]['BillingTable'],$S["Tables_in_misdata"]) == 0) {echo "selected";} ?>><?php echo $S['Tables_in_misdata'];?></option><?php } ?>
            </select></td>
            <td>Billing Table Extra</td>
            <td><input type="text" name="BillingTableExtra" value="<?php echo stripslashes($Service_DESC[$SelectedService]['BillingTableExtra']);?>" /></td>
            </tr>
            
            <tr>
            <th colspan="4">Content Usage Tables</th>
            </tr>
            <tr>
            <td>Content Usage Table</td>
            <td><select name="ContentUsageTable" id="ContentUsageTable">
            <option value="">No Table</option>
            <?php
			$Q = mysql_query("show tables where tables_in_misdata like 'tbl_contentusage%' ") or die(mysql_error());
			while($S = mysql_fetch_array($Q)) {
			?>
            <option value="<?php echo $S['Tables_in_misdata'];?>" <?php if(strcmp($Service_DESC[$SelectedService]['ContentUsageTable'],$S["Tables_in_misdata"]) == 0) {echo "selected";} ?>><?php echo $S['Tables_in_misdata'];?></option><?php } ?>
            </select></td>
            <td>Content Usage Table Extra</td>
            <td><input type="text" name="ContentUsageTableExtra" value="<?php echo stripslashes($Service_DESC[$SelectedService]['ContentUsageTableExtra']);?>" /></td>
            </tr>
            
            
            
            
            <tr>
            <th colspan="4">Content Meta View</th>
            </tr>
            <tr>
            <td>Content Meta View</td>
            <td><select name="ContentTable" id="ContentTable">
            <option value="">No Table</option>
            <?php
			$Q = mysql_query("SELECT table_name FROM information_schema.views where table_name like '%meta%' ") or die(mysql_error());
			while($S = mysql_fetch_array($Q)) {
			?>
            <option value="<?php echo $S['table_name'];?>" <?php if(strcmp($Service_DESC[$SelectedService]['ContentTable'],$S["table_name"]) == 0) {echo "selected";} ?>><?php echo $S['table_name'];?></option><?php } ?>
            </select></td>
            <td>Content View Extra</td>
            <td><input type="text" name="ContentTableExtra" value="<?php echo stripslashes($Service_DESC[$SelectedService]['ContentTableExtra']);?>" /></td>
            </tr>
            
            
            </table>
    </div>
    
    
    <div class="tab-pane" id="tab3">
    <table class="table px12">
    <tr>
    	<td width="25%"><input type="checkbox" value="true" <?php  if($Service_DESC[$SelectedService]['rbt']) {echo 'checked';}?> name="rbt" /> RBT</td>
    	<td width="25%"><input type="checkbox"  value="true" <?php  if($Service_DESC[$SelectedService]['rt']) {echo 'checked';}?> name="rt" /> RT</td>
    	<td width="25%"><input type="checkbox" value="true" <?php  if($Service_DESC[$SelectedService]['Social']) {echo 'checked';}?>  name="Social" /> Social</td>
    	<td width="25%"><input type="checkbox"  value="true" <?php  if($Service_DESC[$SelectedService]['livemis']) {echo 'checked';}?>  name="livemis" /> LiveMIS</td>
    </tr>
    <tr>
    	<td width="25%"><input type="checkbox" value="true" <?php  if($Service_DESC[$SelectedService]['mention_ap']) {echo 'checked';}?> name="mention_ap" /> Active Pending in MIS Mail</td>
    	<td width="25%">&nbsp;</td>
		<td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>

    </table>
    </div>
    
    
    <div class="tab-pane" id="tab4">
      <table class="table px12">
    <tr>
    	<td><input type="checkbox" value="true" <?php  if($Service_DESC[$SelectedService]['DisplayCMS']) {echo 'checked';}?> name="DisplayCMS" /> Display in CMS</td>
    	<td>Display CMS Name</td>
    	<td><input type="text" name="DisplayCMSName" value="<?php echo $Service_DESC[$SelectedService]['DisplayCMSName'];?>" /></td>
    	<td></td>
    </tr>
    </table>
    </div>
    
    <div class="tab-pane" id="tab5">
      <table class="table px12">
    <tr>
    	<th>Tag Name</th>
        <th>&nbsp;</th>
    	<th>Last Successful Run</th>
    	<th>Remarks</th>
    	<th>&nbsp;</th>
    </tr>
	<?php
	$Query_Crons = mysql_query("select * from tbl_system_history where service='".$SelectedService."'") or die(mysql_error());
	while($Fetch_Crons = mysql_fetch_array($Query_Crons)) {
	?>
    
    <tr>
    	<td><?php echo $Fetch_Crons['tag'];?></td>
    	<td><?php 
		$Last = strtotime($Fetch_Crons['last']);
		
		if($Last > (time()-24*60*60)) {
			$SPAN = '<span class="label label-success">';
		} elseif($Last > (time()-3*24*60*60) && $Last < (time()-24*60*60)) {
			 $SPAN = '<span class="label label-warning">';
		} else{
			$SPAN = '<span class="label label-important">';
		}
		$LAST_DAYS = floor((time()-$Last)/(24*60*60));
		
		?><?php echo $SPAN;?><?php echo $LAST_DAYS;?> old</span></td><td><?php echo $Fetch_Crons['last'];?></td>
    	<td><?php echo $Fetch_Crons['last_status'];?></td>
    	<td>[Save]</td>
    </tr>
    <?php } ?>
    </table>
    </div>
    <div class="tab-pane" id="tab6">
    <table class="table px12">
    <tr>
    	<th>Circles</th>
    	<th>Recipient Email</th>
    	<th>Carbon Copy to</th>
    	<th>&nbsp;</th>
    </tr><?php
	$Query_Mails = mysql_query("select * from tbl_usermanager_emailist where service='".$SelectedService."' order by circles ASC") or die(mysql_error());
	while($Fetch_Mails = mysql_fetch_array($Query_Mails)) {
		
		$tmpArray = array();
		$tmpCircles = explode(",",$Fetch_Mails['circles']);
		foreach($tmpCircles as $tCircles)
		{
			array_push($tmpArray,array('id'=>trim($tCircles),'name'=>trim($tCircles)));	
		}
		$Json_Circles=nl2br(json_encode($tmpArray));
		unset($tmpArray);
		
		$tmpArray = array();
		$tmpCC = explode(",",$Fetch_Mails['email_cc']);
		foreach($tmpCC as $tCC)
		{
			array_push($tmpArray,array('id'=>trim($tCC),'name'=>trim($tCC)));	
		}
		$Json_CC=nl2br(json_encode($tmpArray));
		unset($tmpArray);
		
		
	?>
	
     <tr>
    	<td><?php echo $Fetch_Mails['circles'];?><input type='hidden' id='tmp_g_<?php echo $Fetch_Mails['id'];?>_circles' value='<?php echo $Json_Circles;?>' />
        <input type='hidden' id='tmp_g_<?php echo $Fetch_Mails['id'];?>_to' value='<?php echo $Fetch_Mails['email_to'];?>' />
        <input type='hidden' id='tmp_g_<?php echo $Fetch_Mails['id'];?>_cc' value='<?php echo $Json_CC;?>' /></td>
    	<td><?php echo $Fetch_Mails['email_to'];?></td>
    	<td><?php echo $Fetch_Mails['email_cc'];?></td>
    	<td><a data-target="#EmailList"  role="button" class="openModalEmailing btn" data-toggle="modal" data-id="tmp_g_<?php echo $Fetch_Mails['id'];?>">Launch demo modal</a></td>
    </tr>
    <?php } ?></table>
    </div>
    
    <div class="modal hide fade" id="EmailList">
    
    		  <div class="modal-header">
    						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    						<h3>Email List</h3>
      </div>
                    <div class="modal-body">
                    	<p>
                        Circles: <input type="text" id="mailer-list-circle" name="mailer-list-circle" />
                        </p>
                        
                        <p>Recipients: </p><textarea name="mailer-list-to" id="mailer-list-to" style="width: 400px"></textarea>
                        
                        <p>Carbon Copy: </p>
    				<input type="text" id="mailer-list-cc" name="mailer-list-cc" />
                    </div>
                    
                    <div class="modal-footer">
                            <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
                            <a href="#" class="btn btn-primary">Save changes</a>
                    </div>
                    
    
    </div>
   
  </div>
</div><br>
    <input name="button" type="submit" class="btn btn-primary" id="button" value="Submit"></form>



<?php } ?>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap-transition.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>
<script src="assets/js/bootstrap-modal.js"></script>
<script src="assets/js/bootstrap-dropdown.js"></script>
<script src="assets/js/bootstrap-scrollspy.js"></script>
<script src="assets/js/bootstrap-tab.js"></script>
<script src="assets/js/bootstrap-tooltip.js"></script>
<script src="assets/js/bootstrap-popover.js"></script>
<script src="assets/js/bootstrap-button.js"></script>
<script src="assets/js/bootstrap-collapse.js"></script>
<script src="assets/js/bootstrap-carousel.js"></script>
<script src="assets/js/bootstrap-typeahead.js"></script>
<script src="assets/js/jquery.fixheadertable.js"></script>
<script src="assets/js/jquery.tokeninput.js"></script>
<script>
$(document).ready(function($) { 
      $("input[name='DisplayCMS']").click(function(){
               if ($(this).is(':checked')) {               		
                    $("input[name='DisplayCMSName']").attr("disabled", false);               
                 }               
               else if ($(this).not(':checked')) {   	                 	
                   
				            var remove = '';                             	
                           // $('input.textbox:text').attr ('value', remove);
                            $("input[name='DisplayCMSName']").attr("disabled", true);                            
                             }          
 });
 
		$("#mailer-list-circle").tokenInput("incs/getCircles.php");
		//$("#mailer-list-to").tokenInput("incs/getUsers.php?f=name,email");
		$("#mailer-list-cc").tokenInput("incs/getUsers.php?f=name,email");
 
 
 		$.fn.modalMailing = function(data) { 
     					
					
					
					circles = jQuery.parseJSON($('#'+data+'_circles').val());
					cc = jQuery.parseJSON($('#'+data+'_cc').val());
					$('#mailer-list-to').text($('#'+data+'_to').val());
					//alert(circles);
					$('#mailer-list-circle').prev().detach();
					$("#mailer-list-circle").tokenInput("incs/getCircles.php?f=name,email",{prePopulate: circles, preventDuplicates: true});
					
					$('#mailer-list-cc').prev().detach();
					$("#mailer-list-cc").tokenInput("incs/getUsers.php?f=name,email",{prePopulate: cc, preventDuplicates:true });
						
						
						
			 }	
 
 
  });
  $(document).on("click", ".openModalEmailing", function () {
	 var data = $(this).data('id');
	
	 $.fn.modalMailing(data);
  });
 
 	$("#Currency").val("<?php echo $Currency;?>");

 		$.fn.RegenerateBase = function () {
			$("#BaseAjax").empty().html('<img src="../../cmis/img/loading1.gif" />');
			$.ajax({
					  url: "../../cmis/Cron/CreateBase.php",
					  cache: false,
					  type: "GET",
					  data: {},
					  success: function(html){
						//alert(html);
						//document.location.reload();
						$("#BaseAjax").empty().html('&nbsp;&nbsp;&nbsp;Output:'+html);
			
					  }
					});

	 };  

</script>
</div></div>
</body>

</html>
