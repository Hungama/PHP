<?php
define("QUEUED", "Queued", true);
define("PICKED", "Processing", true);
define("STATUSAVAILABLE", "Completed", true);
define("ALERT_NO_RECORD_FOUND","<h4>Ooops!</h4>Hey, we couldn't seem to find any record of uploads for $viewhistoryfor",true);
define("ALERT_VIEW_UPLOAD_HISTORY","Upload history for $viewhistoryfor. Displaying last $limit records",true);
define("ALERT_File_UPLOAD_SUCCESS","$filename has been successfully uploaded. Generated Reference ID is $batchid",true);
// JS validation text
define("JS_NOSERVICESELECTED", "Please select Service", true);
define("JS_NOMODESELECTED", "Please select Mode", true);
define("JS_NOPPSELECTED", "Please select Price Point", true);
define("JS_NOFILESELECTED", "Please select File to Uplaod", true);
define("JS_FILETYPEERROR", "Please check the filename of the selected file. There seems to be some naming issue. Only upload Filename.txt files", true);
define("FILEUPLOADEERROR", "There seem to be error in the contents of the file. Please check the file you selected for upload", true);
define("JS_NOCONTENTTYPESELECTED", "Please select content type", true);
define("JS_NOCONTENTIDSELECTED", "Please enter content id", true);
define("JS_NOVALIDCONTENTIDSELECTED", "Please enter valid content id", true);
define("JS_NOMESSAGE", "Please enter message text", true);

//define table header for view bulk upload history
define("TH_BATCHID", "Id", true);
define("TH_FILENAME", "Filename", true);
define("TH_ADDEDON", "Uploaded on", true);
define("TH_SERVICENAME", "Service", true);
define("TH_UPLOADFOR", "Type", true);
define("TH_PRICEPOINT", "Price", true);
define("TH_MODE", "Mode", true);
define("TH_TOTALCOUNTINFILE", "Input Count", true);
define("TH_FILESTATUS", "Status", true);
define("TH_ALREADY_SUBSCRIBED", "Already Subs", true);
define("TH_INPROCESS", "In Process #'s", true);
define("TH_STATUS", "Status", true);


//for view billing/subscription history
// Information tab
define("CC_SEARCH_INFO", "Displaying details for Mobile # ", true);
//Table header tag
define("TH_ANI", "Mobile#", true);
define("TH_REGISTRATION_ID", "Reg.#", true);
define("TH_NEXT_CHARGING", "Next Bill Dt", true);
define("TH_LAST_CHARGING", "Last Bill Dt", true);
define("TH_CHARGED_AMT", "Last Bill Amt", true);
define("TH_CIRCLE", "Circle", true);
define("TH_BILLINGID", "Billing #", true);

define("TH_TRANSACTIONID", "Transaction #", true);
define("TH_EVENTTYPE", "Event Type", true);
define("TH_DATETIME", "Date/Time", true);
define("TH_ATTEMPT_AMOUNT", "Attempted Amt", true);
define("TH_AVAL_BALANCE", "Avail Balance", true);
define("TH_CHARGE_AMOUNT", "Chrg Amt", true);
define("TH_CONTENT_TYPE", "Content Type", true);
define("TH_CONTENT_ID", "Content Id", true);


//file upload for 
define("ACTIVE", "Activation", true);
define("TOPUP", "Top-Up", true);
define("EVENT", "Event", true);
define("DEACTIVE", "Deactivation", true);

//File upload instruction message
define("FILE_UPLOAD_MESSAGE", "Please note: Only .txt file shall be accepted. Also, only 20,000 numbers shall be accepted in the file. Each row in your file should contain just 1 number (10 digits)", true);
define("FILE_UPLOAD_SMS",'The time for upload of SMS Base is between 9 AM to 9 PM', true);
//Subscription status
define("STATUS_0", "Queued", true);
define("STATUS_1", "Active", true);
define("STATUS_5", "Retry (Act)", true);
define("STATUS_11", "Retry (Rnw)", true);


// Label Classes
define("STATUS_LABEL_0","label-warning",true);
define("STATUS_LABEL_1","label-success",true);
define("STATUS_LABEL_5","label-info",true);
define("STATUS_LABEL_11","label-info",true);

//button text
define("BTN_LABEL_DEACTIVE","DeActivate",true);
define("BTN_LABEL_ACTIVE","label-warning",true);
define("BTN_LABEL_SUB_HISTORY","Sub Details",true);
define("BTN_LABEL_RECHARGE_COUPAN_HISTORY","Other Details",true);
define("BTN_LABEL_MESSAGE","Message history",true);

//actual service name code start here 
//$serviceNameArray=array('1502'=>'Airtel - 54646','1501'=>'Airtel - Entertainment Unlimited','1511'=>'Airtel - Gud Life','1513'=>'Airtel - MND','1518'=>'Airtel - Mana Paata Mana','1509'=>'Airtel - Miss Riya','1514'=>'Airtel - PD','1515'=>'Airtel - Sarnam','1517'=>'Airtel - Spoken English','1507'=>'Airtel - VH1 Radio GaGa');
$serviceNameArray=array('1502'=>'Airtel - 54646','1501'=>'Airtel - Entertainment Unlimited','1511'=>'Airtel - Gud Life','1513'=>'Airtel - MND','1518'=>'Airtel - Mana Paata Mana','1509'=>'Airtel - Miss Riya','1514'=>'Airtel - PD','1515'=>'Airtel - Sarnam','1517'=>'Airtel - Spoken English','1507'=>'Airtel - VH1 Radio GaGa');

//$serviceNameArray=array('1518'=>'Airtel Comedy','1520'=>'Airtel Palleturi Kathalu','1522'=>'Airtel Regional Manoranjan','1515'=>'Airtel SARNAM','1502'=>'Entertainment Portal 54646','1501'=>'Entertainment Unlimited','1504'=>'Good Life Store @Re 1','1511'=>'GoodLife','1509'=>'Miss Riya','1503'=>'MTV Dj Dial','1513'=>'My Naughty Diary','1514'=>'Personality Development','15212'=>'SMSPack - SexEducation','15211'=>'SMSPack - Ur Zodic','15213'=>'SMSPack - Vastu','1517'=>'Spoken English','15071'=>'VH1 Night Pack ','1507'=>'VH1 Radio GAGA');

//plnid- 63 1522  crazy  AirtelRegKK
//64   1522  manoranjan AirtelRegTN
$serviceArrayBulk=array('Airtel54646'=>'1502','AirtelRegTN'=>'1522','AirtelEU'=>'1501','AirtelGL'=>'1511','AirtelComedy'=>'1518','AirtelRegKK'=>'','RIAAirtel'=>'1509','AirtelMND'=>'1513','AirtelMNDKK'=>'','AirtelPK'=>'1520','AirtelPD'=>'1514','AirtelDevo'=>'1515','AirtelSE'=>'1517','VH1Airtel'=>'1507','Good Life Store @Re 1'=>'1504','MTV Dj Dial'=>'1503','SMSPack - SexEducation'=>'15212','SMSPack - Ur Zodic'=>'15211','SMSPack - Vastu'=>'15213','VH1 Night Pack'=>'15071','AirtelRegKR'=>'1523');

$serviceArray=array('Airtel54646'=>'1502','AirtelRegTN'=>'1522','AirtelEU'=>'1501','AirtelGL'=>'1511','AirtelComedy'=>'1518','AirtelRegKK'=>'','RIAAirtel'=>'1509','AirtelMND'=>'1513','AirtelMNDKK'=>'','AirtelPK'=>'1520','AirtelPD'=>'1514','AirtelDevo'=>'1515','AirtelSE'=>'1517','VH1Airtel'=>'1507','AirtelRegKR'=>'1523','WAPAirtelLDR'=>'1527');

$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa', 'KAR'=>'Karnataka', 'HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh',''=>'Other');
?>