file_date="$(date --date='1 days ago' "+%Y%m%d")"
#file_date=20150213
#/var/www/html/kmis/mis/waplog/waplogdata_147.sh( schedule inside it)
cd /var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/
#For TATA LDR
basepath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/tata/ldr/"
logfilename='AllTataVisitorRequestMIS_'
targetfilepath="$logfilename$file_date.tar.gz"
orgfilename="$logfilename$file_date.txt"
sshpass -p'Pass@123' scp -r -P2930 root@117.239.178.108:/var/www/html/hungamawap/tata/CCG/logs/tarfiles/$targetfilepath $basepath
sleep 2
untargetfilepath="$basepath$targetfilepath"
untarfile=`tar -zxvf $untargetfilepath`
mvtartxtfile=`mv $orgfilename $basepath`