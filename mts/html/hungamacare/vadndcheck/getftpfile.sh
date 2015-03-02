#!/bin/sh
#Shell Script for scrubbed base download
WHICH="/usr/bin/which"
filename_org="$1_*"
#filename_org="1VA_OUT_07042014125846_*"
filePath="/var/www/html/hungamacare/vadndcheck/192.168.100.238/output/$filename_org"
filename="$1_"
#filename="1VA_OUT_07042014125846_"
filename2="/var/www/html/hungamacare/vadndcheck/dndcheck/$1.txt"
#filename2="/var/www/html/hungamacare/vadndcheck/dndcheck/1VA_OUT_07042014125846.txt"
`wget -r  ftp://vgt:Vgt_Ndnc@192.168.100.238:21/output/$filename*`
sleep 150
`cat $filePath >> $filename2`