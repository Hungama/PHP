<?php

class FlxZipArchive extends ZipArchive {

 public function addDir($location, $name) {
        $this->addEmptyDir($name);
 
        $this->addDirDo($location, $name);
     } 
 
    private function addDirDo($location, $name) {
        $name .= '/';
        $location .= '/';
 
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;
 
            // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } 
}
?>