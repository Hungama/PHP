#!/bin/sh

date=`date -d yesterday +%Y%m%d`

#date=20120401;

#voda 54646
cd /home/Hungama_call_logs/54646
cp 54646_calllog_$date.txt  /var/www/html/VodafoneLog/54646/

#vodaMTV
cd /home/Hungama_call_logs/mtv
cp mtv_calllog_$date.txt  /var/www/html/VodafoneLog/fetch_log_MTV/

#vodaDon
cd /home/Hungama_call_logs/REDFM
cp REDFM_calllog_$date.txt  /var/www/html/VodafoneLog/RedFM/
