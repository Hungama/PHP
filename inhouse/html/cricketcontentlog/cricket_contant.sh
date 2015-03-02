#!/bin/sh

date=`date -d yesterday +%Y%m%d`

#date=20120401;

rsync -avz root@192.168.100.226:/home/Hungama_call_logs/cricket/cricket_contentlog_$date.txt /var/www/html/cricketcontentlog/cricketcontentlog226/
#rm -rvf  /var/mis/MTVMTS/MTVMTS_ACTIVEPENDING_$dateback.zip


rsync -avz root@192.168.100.227:/home/Hungama_call_logs/cricket/cricket_contentlog_$date.txt /var/www/html/cricketcontentlog/cricketcontentlog227/
#rm -rvf  /var/mis/MTSMU/MTSMU_ACTIVEPENDING_$dateback.zip

#cd /var/mis/
#touch flag.txt


#rsync -avz /var/mis/MTVMTS/MTVMTS_ACTIVEPENDING_$datecurrent.zip  gazab@192.168.100.212:/home/kmis/
#rsync -avz /var/mis/MTSMU/MTSMU_ACTIVEPENDING_$datecurrent.zip  gazab@192.168.100.212:/home/kmis/
#rsync -avz /var/mis/MTS54646/MTS54646_ACTIVEPENDING_$datecurrent.zip gazab@192.168.100.212:/home/kmis/
#rsync -avz /var/mis/MTSDevo/MTSDevo_ACTIVEPENDING_$datecurrent.zip gazab@192.168.100.212:/home/kmis/
#rsync -avz /var/mis/MTSFMJ/MTSFMJ_ACTIVEPENDING_$datecurrent.zip gazab@192.168.100.212:/home/kmis/
#rsync -avz /var/mis/flag.txt gazab@192.168.100.212:/home/kmis/
