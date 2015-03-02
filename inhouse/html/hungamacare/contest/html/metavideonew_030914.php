<?php

$headers = array(
    'Accept-Language:eng',
    'Authorization: Basic ' . base64_encode("uninor_contests:Uninor@1462"),
    'x-output-level:255'
);

$contentid_array = array(2446646, 2588763, 1808084, 2588764, 2089094, 2588765, 2464590, 2588795, 2554479, 2588794, 2500965, 2588793, 2089096, 2587394, 1808057, 2588792, 2554470,
    2587395, 2464591, 2587396, 1808341, 2588791, 2054262, 2587397, 2406391, 2587398, 2479422, 2588790, 2392085, 2588789, 2188528, 2588788, 2215797, 2587399,
    2191717, 2587400, 2176949, 2587410, 2467550, 2587401, 2450384, 2587402, 1806126, 2588787, 2534420, 2587403, 1840131, 2588786, 1799000, 2588785, 2476901,
    2588784, 2410064, 2588783, 2251966, 2587404, 2188529, 2588782, 2190492, 2587411, 2487131, 2588781, 2464585, 2588780, 2188522, 2588779, 2487132, 2588778,
    2392082, 2588777, 2554472, 2588776, 2406391, 2587405, 2385901, 2587412, 2588376, 2588775, 2588383, 2587406, 2588398, 2588774, 2588400, 2588770, 2588773,
    2588403, 2587407, 2588769, 2588404, 2588772, 2588409, 2587408, 2588410, 2587409, 2588411, 2588771, 2588768, 2588412, 2588766, 2588413, 2588767, 2446643,
    2588692, 2406394, 2588693, 2427797, 2588694, 2191719, 2588695, 1852474, 2588696, 1557485, 2588697, 2410063, 2588698, 2251966, 2587421, 2188522, 2587420,
    2363779, 2587419, 2152739, 2587418, 2477324, 2588699, 2432531, 2587417, 2191713, 2587416, 2126209, 2588700, 1759677, 2588701, 2445195, 2587415, 1557481,
    2587414, 1552508, 2587413, 2467550, 2588737, 2403709, 2588738, 2331959, 2588739, 2191720, 2588740, 2188530, 2588741, 2363773, 2588742, 2152740, 2588743,
    2432538, 2588744, 2191719, 2588745, 2445194, 2588746, 1557487, 2588747, 2588377, 2588748, 2588378, 2588749, 2588380, 2588750, 2588381, 2588751, 2588382,
    2588752, 2588384, 2588753, 2588389, 2588754, 2588390, 2588755, 2588392, 2588756, 2588395, 2588757, 2588397, 2588758, 2588399, 2588759, 2587422, 2588401,
    2588760, 2588402, 2588761, 2588405, 2588762, 2588407, 2587423, 2443006, 1806126, 2588702, 2086522, 2588703, 2152730, 2432532, 2588704, 2176944, 2588705,
    1759690, 1557487, 2588706, 2404717, 2588707, 1808057, 2152742, 2588708, 2427796, 2588709, 1759682, 1557484, 2588710, 1552509, 2588711, 2331963, 2404712,
    2588712, 2403708, 2588713, 2215420, 2479226, 2588714, 1557481, 2588715, 1852477, 1759683, 2588716, 1552505, 2588736, 2331970, 2432534, 2588735, 2167283,
    2588734, 2111438, 2482781, 2588733, 2363778, 2588717, 2188531, 2215803, 2588718, 1808090, 2588719, 2446643, 2505194, 2588720, 2479229, 2588721, 2477323,
    2152737, 2588722, 2215800, 2588723, 2188533, 2487130, 2588726, 2054281, 2588727, 2374406, 2588728, 1808080, 2588379, 2588729, 2588385, 2588386, 2588730,
    2588387, 2588388, 2588731, 2588391, 2588393, 2588732, 2588394, 2588396, 2588725, 2588406, 2588408, 2588724);

foreach ($contentid_array as $key => $value) {


    $url = "http://publisher.metasea.hungamatech.com/MetaSeaWS/content/id/" . $value;
    echo "jyoti" . $value;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);

    $xml = simplexml_load_string($output);
    $json = json_encode($xml);
    $array = json_decode($json, TRUE);

    include ("/var/www/html/hungamacare/config/dbConnect.php");
    $i = 1;
    foreach ($array['files']['file'] as $val) {
        //$contentFileType = $val['contentFileType'];print_r($contentFileType);
        //$subType = $val['subType'];print_r($subType);
        $details = array_values($val);
        //echo "<br/><br/><br/>";
        //print_r($details);
        $ext = $details[2];

        if ($ext == 'mp4') {
            $contentFileType = $details[5];
            $contentFileType_details = array_values($contentFileType);
            $contentFileType_details1 = array_values($contentFileType_details[0]);
            $subType = $details[6];
            $subType_details = array_values($subType);
            $subType_details1 = array_values($subType_details[0]);
            $url = "http://mdn.hungama.com/streaming/" . $value . "/" . $contentFileType_details1[0] . "/" . $subType_details1[0] . "/contest?duration=PT0H0M30S&cdn=akamai&agent=application&cms=ms2&protocol=filedl";

            //http:// mdn.hungama.com/download/12345/4/8/Test      //test video url
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            print_r($output);
            curl_close($ch);

//            echo $qry = "update uninor_summer_contest.question_bank_wapcontest set image1='" . $img . "' where content_id='" . $value . "'";
//            $result = mysql_query($qry);
            echo "<br/><br/><br/>";
            die('here');
        }
        $i++;
    }
    curl_close($ch);
    echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
}
//print_r($array['files']['file'][3]['paths']['path'][1]);
?>