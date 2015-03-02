<?php

$logDir = "/var/www/html/hungamacare/log/txtNation/";
$logFile = "lastfmNotify_" . date('Ymd');
$logPath = $logDir . $logFile . ".txt";
$logStr = '';

$arrCnt = sizeof($_REQUEST);
for ($i = 0; $i < $arrCnt; $i++)
    $keys = array_keys($_REQUEST);

for ($k = 0; $k < $arrCnt; $k++)
    $logStr .=$keys[$k] . "->" . $_REQUEST[$keys[$k]] . "|";

$logStr.="\r\n";
error_log($logStr, 3, $logPath);

$searchStr = $_REQUEST['searchStr'];
$srctype = $_REQUEST['srctype'];
$artistName = $_REQUEST['astistname'];

class getSearchRecord {

    public $albumName;
    public $apiUrl;
    public $apiKey;

    public function getkey() {
        $this->apiKey = "89d18663b355974640dffbb4ec3b7131";
    }

    public function getUrl($albumName, $srctype,$artistName=0) {
        $this->getkey();
        $this->srcType = $srctype;
        $this->artistName = $artistName;
        $this->albumName=$albumName;
        
        switch ($this->srcType) {
            case 'album':
                $this->apiUrl = "http://ws.audioscrobbler.com/2.0/?method=album.search&album=" . urlencode($albumName) . "&api_key=" . $this->apiKey . "&format=json";
                break;
            case 'track':
                $this->apiUrl = "http://ws.audioscrobbler.com/2.0/?method=track.search&track=" . urlencode($albumName) . "&api_key=" . $this->apiKey . "&format=json";
                break;
            case 'albumtrack':
                $this->apiUrl = "http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=".$this->apiKey."&artist=".urlencode($this->artistName)."&album=".urlencode($this->albumName)."&format=json";
                break;
        }

        $this->ApiResponse = $this->fetchRecord($this->apiUrl);
        $this->json_obj = json_decode(($this->ApiResponse));
        switch ($this->srcType) {
            case 'album':
                $this->showAlbum($this->json_obj);
                break;
            case 'track':
                $this->showTrack($this->json_obj);
                break;
            case 'albumtrack':
                $this->showAlbumTrack($this->json_obj);
                break;
        }
    }

    public function fetchRecord($apiUrl) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($ch);
        return $response;
    }

    public function showTrack($jsonResponse) {
        $this->json_obj = $jsonResponse;
        $this->albumcount = sizeof($this->json_obj->results->trackmatches->track);
        if ($this->albumcount > 0) {
            echo "<table border='1' align='center'>";
            echo "<tr><th>Track Name</th><th>Artist Name</th></tr>";
            for ($this->k = 0; $this->k < $this->albumcount; $this->k++) {
                echo "<tr>";
                echo "<td>" . $this->json_obj->results->trackmatches->track[$this->k]->name . "</td>";
                echo "<td>" . $this->json_obj->results->trackmatches->track[$this->k]->artist . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo 'No Record Found';
        }
    }
    
    public function showAlbumTrack($jsonResponse)
    {
        $this->json_obj = $jsonResponse;
        //echo '<pre>';        print_r($this->json_obj->album->tracks->track);
        $this->albumTrackCount = sizeof($this->json_obj->album->tracks->track);
        echo "<table border='1' align='center'>";
        echo "<tr><td colspan='4'><a href='http://119.82.69.212/hungamacare/lastfm/home.php'>Back</a></td></tr>";
        echo "<tr><th>Track Name</th><th>duration</th><th>Artist Name</th><th>Album Name</th></tr>";
            
        for ($this->ki = 0; $this->ki < $this->albumTrackCount; $this->ki++) {
                echo "<tr>";
                echo "<td>" . $this->json_obj->album->tracks->track[$this->ki]->name . "</td>";
                echo "<td>" . $this->json_obj->album->tracks->track[$this->ki]->duration . "</td>";
                echo "<td>" . $this->json_obj->album->tracks->track[$this->ki]->artist->name . "</td>";
                echo "<td>" . $this->albumName . "</td>";
                echo "</tr>";
            }
    }

    public function showAlbum($jsonResponse) {
		
        $this->json_obj = $jsonResponse;
        $this->albumcount = sizeof($this->json_obj->results->albummatches->album);
        if ($this->albumcount > 0) {
            echo "<table border='1' align='center'>";
            echo "<tr><th>Album Name</th><th>Artist Name</th></tr>";
            for ($this->k = 0; $this->k < $this->albumcount; $this->k++) {
                $this->albumInfoUrl="http://119.82.69.212/hungamacare/last.fm/lastfm_Notify.php?srctype=albumtrack&searchStr=".urlencode($this->json_obj->results->albummatches->album[$this->k]->name)."&astistname=".urlencode($this->json_obj->results->albummatches->album[$this->k]->artist);
                echo "<tr>";
                echo "<td><a href='".$this->albumInfoUrl."'>" . $this->json_obj->results->albummatches->album[$this->k]->name . "</a></td>";
                echo "<td>" . $this->json_obj->results->albummatches->album[$this->k]->artist . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No Record Found";
        }
    }

}

$classobject = new getSearchRecord();
$classobject->getUrl($searchStr, $srctype,$artistName);
?>
