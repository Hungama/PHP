#!/bin/sh
#Shell Script for scrubbed base download
WHICH="/usr/bin/which"
filename_org="$1_*"
filePath="/var/www/html/hungamacare/sendVcart/119.82.69.215/output/$filename_org"
filename="$1_"
filename2="/var/www/html/hungamacare/sendVcart/dndcheck/$1.csv"
`wget -r  ftp://vgt:Vgt_Ndnc@119.82.69.215:21/output/$filename*`
sleep 5
`cat $filePath >> $filename2`