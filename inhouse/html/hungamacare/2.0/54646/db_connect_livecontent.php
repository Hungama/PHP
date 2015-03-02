<?php
 $DB_HOST_M224     = '192.168.100.224'; //'172.28.106.4'; //DB HOST
 $DB_USERNAME_M224 = 'webcc';  //DB Username
 $DB_PASSWORD_M224 = 'webcc';  //DB Password 'Te@m_us@r987';
 $DB_DATABASE_M224 = 'master_db';  //Datbase Name  hul_hungama
 $db_m224 = $DB_DATABASE_M224;

 $dbConn = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224);
if (!$dbConn)
 {
  die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
 
$dbConn_218 = mysql_connect("192.168.100.218","kunalk.arora","google");
if (!$dbConn_218)
 {
  die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
 mysql_select_db('misdata',$dbConn_218);
 
 $airtel_devotional_mapping= array('cat0131'=>'TheHolyBible','cat0132'=>'Gospelsongs','cat0133'=>'Dharmik Granth','cat0134'=>'Maryada Purshottam Shri Ram','cat0135'=>'Murlidharshri Krishna','cat0136'=>'DeviMaa','cat0137'=>'SankatmochanShri Hanuman','cat0138'=>'Bhagwan BholeShankar','cat0139'=>'MangalkarishriGanesh','cat0140'=>'Shridike Sai Baba','cat0141'=>'Bhajan Sangam','cat0142'=>'Aayaten ','cat0143'=>'Naat Shareif','cat0144'=>'Darood Sharief','cat0145'=>'Dua','cat0146'=>'Quwwalies','cat0147'=>'Muslim Devotional','cat0148'=>'Bhaktamber Stotra','cat0149'=>'Mantra/Chalisa','cat0150'=>'Aarti','cat0151'=>'Bhakti Geet','cat0152'=>'Vandana','cat0153'=>'Chants','cat0154'=>'Bhajans','cat0231'=>'The Holy Bible','cat0232'=>'Gospel songs','cat0233'=>'Hymns','cat0234'=>'Christmas Songs','cat0331'=>'Hukamnama','cat0332'=>'Paath','cat0333'=>'Mukhwak','cat0335'=>'Ardaas','cat0336'=>'DharmikGeet','cat0337'=>'Shabadkeertan','cat0338'=>'Gurbani','cat0431'=>'Devi Geet','cat0432'=>'Bhagwan Bhole Shankar Ke Bhajan','cat0433'=>'Chhath Pooja ke Geet','cat0434'=>'Bhajan Sangam','cat0631'=>'DebiMaagaan','cat0632'=>'ShriKrishnaBhajan','cat0633'=>'ShibaBhajan','cat0634'=>'BhajanSangam','cat0731'=>'BalajiBhajan','cat0732'=>'Ayyappa','cat0733'=>'Murugan','cat0734'=>'BhajanSangam','cat0739'=>'AayatenTamilTranslation','cat0831'=>'Suprabhatam','cat0832'=>'Ayyappa','cat0833'=>'Sai Baba','cat0834'=>'Hanuman','cat0835'=>'Ganesha','cat0836'=>'Krishna','cat0837'=>'BhajanSangam','cat0839'=>'Balaji Bhajan','cat0931'=>'AayatenMalayamTranslation
','cat0932'=>'ChristianDevotional','cat0935'=>'Krishna','cat0936'=>'Devi maa','cat0937'=>'Ganesha','cat0938'=>'Shiva','cat0939'=>'BhajanSangam','cat0940'=>'Mapilla Devotional','cat1031'=>'Suprabhatam','cat1032'=>'Hanuman','cat1033'=>'Bhajan','cat1231'=>'Shiv bhajan','cat1232'=>'Krishna Bhajan','cat1233'=>'Swaminarayan Kirtan','cat1234'=>'Bhajan Sangam','cat1431'=>'Naat Shareif','cat1432'=>'Hamud','cat1433'=>'Mankabhat','cat1434'=>'Manajhaat','cat1631'=>'Devi Geet','cat1632'=>'Bhajan Sangam','cat1731'=>'Bhajan Sangam','cat1732'=>'Shankardeb Bhajans','cat1831'=>'Khatu Shyam','cat1832'=>'Salasar Ke Balaji','cat1833'=>'Srinathji','cat1834'=>'Baba Ramdev','cat1835'=>'Goga Peer','cat1836'=>'Bhajan Sangam','cat1131'=>'sai Baba','cat1132'=>'GanpatiBhajan','cat1133'=>'Bhakti Geet');
?>