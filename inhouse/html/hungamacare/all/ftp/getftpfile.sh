#!/bin/sh
#Shell Script for scrubbed base download
WHICH="/usr/bin/which"
#filename_org="testbyspt20140129_*"
filename_org="$1_*"
filePath="/var/www/html/hungamacare/all/ftp/119.82.69.215/output/$filename_org"
#filename="testbyspt20140129_"
filename="$1_"
#filename2="testbyspt20140129.txt"
filename2="$1.txt"
`wget -r  ftp://vgt:Vgt_Ndnc@119.82.69.215:21/output/$filename*`
sleep 5
`cat $filePath >> $filename2`