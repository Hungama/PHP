<?php
error_reporting(0);
//include('get_web_page.php');
/**
 * Get a web file (HTML, XHTML, XML, image, etc.) from a URL.  Return an
 * array containing the HTTP server response header fields and content.
 */
function get_web_page( $url )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 1000,      // timeout on connect
        CURLOPT_TIMEOUT        => 1000,      // timeout on response
        CURLOPT_MAXREDIRS      => 5,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}


$url='http://202.87.41.147/hungamawap/uninor/DoubleConsent/dconsidea.php?stype=VH1&zoneid=1000&afid=1000';
$result = get_web_page( $url );
print_r($result);
$page = $result['content'];
$html = "sc4.html";
unlink($html);
error_log($page, 3, $html);
$html = file_get_contents('sc4.html');
//Create a new DOM document
$dom = new DOMDocument;
//Parse the HTML. The @ is used to suppress any parsing errors
//that will be thrown if the $html string isn't valid XHTML.
@$dom->loadHTML($html);
//Get all links. You could also use any other tag name here,
//like 'img' or 'table', to extract other tags.
$links = $dom->getElementsByTagName('a');
$linksimg = $dom->getElementsByTagName('img');
$surl=array();
$simg=array();
//Iterate over the extracted links and display their URLs
$i=0;
$k=0;
foreach ($links as $link){
    //Extract and show the "href" attribute.
     //echo $link->nodeValue;
    $surl[$i]=$link->getAttribute('href');
	$i++;
	}
foreach ($linksimg as $linksimg){
    //Extract and show the "href" attribute.
     //echo $link->nodeValue;
    $simg[$k]=$linksimg->getAttribute('src');
	$k++;
	}	
//print_r($surl);
//print_r($simg);
$finalurl='http://scg.icl.in'.$surl[0];
$finalurl1='http://scg.icl.in'.$surl[1];
$logdate=date("Ymd");	
$logPath_MIS_IDEA="testRequest_".$logdate.".txt";
$logString_MIS218_Idea = date('Y-m-dH:i:s')."#".$finalurl . "#" . $finalurl1."\r\n";
error_log($logString_MIS218_Idea, 3, $logPath_MIS_IDEA);	

//echo "<script>window.location.href='".$finalurl."'</script>";

?>
<a href="<?php echo $finalurl;?>">Click 1</a>
<br></br>
<a href="<?php echo $finalurl1;?>">Click 2</a>