file_date="$(date --date='1 days ago' "+%Y%m%d")"
#file_date=20150203
#/var/www/html/kmis/mis/waplog/waplogdata_147.sh( schedule inside it)
cd /var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/
#Copy Tar file For Airtel LDR
basepath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/airtel/ldr/"
logfilename='AllAirtelVisitorRequestMISNew_'
targetfilepath="$logfilename$file_date.tar.gz"
orgfilename="$logfilename$file_date.txt"
logfilename_affid='sAffiddata_'
targetfilepath_affid="$logfilename_affid$file_date.tar.gz"
orgfilename_affid="$logfilename_affid$file_date.txt"

sshpass -p'Pass@123' scp -r -P2930 root@117.239.178.108:/var/www/html/hungamawap/airtel/CCG/logs/tarfiles/$targetfilepath $basepath
sshpass -p'Pass@123' scp -r -P2930 root@117.239.178.108:/var/www/html/hungamawap/airtel/CCG/logs/tarfiles/$targetfilepath_affid $basepath
sleep 2
untargetfilepath="$basepath$targetfilepath"
untargetfilepath_affid="$basepath$targetfilepath_affid"
untarfile=`tar -zxvf $untargetfilepath`
untarfile_affid=`tar -zxvf $untargetfilepath_affid`
mvtartxtfile=`mv $orgfilename $basepath`
mvtartxtfile_affid=`mv $orgfilename_affid $basepath`


#For Uninor LDR
basepath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/ldr/"
logfilename='logs_'
targetfilepath="$logfilename$file_date.tar.gz"
orgfilename="$logfilename$file_date.txt"
sshpass -p'Pass@123' scp -r -P2930 root@117.239.178.108:/var/www/html/hungamawap/uninorldr/logs/wap/tarfiles/$targetfilepath $basepath
sleep 2
untargetfilepath="$basepath$targetfilepath"
untarfile=`tar -zxvf $untargetfilepath`
mvtartxtfile=`mv $orgfilename $basepath`


#For Uninor Contest
basepath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/contest/"
logfilename='logs_'
targetfilepath="$logfilename$file_date.tar.gz"
orgfilename="$logfilename$file_date.txt"
sshpass -p'Pass@123' scp -r -P2930 root@117.239.178.108:/var/www/html/hungamawap/uninorcontest/logs/wap/tarfiles/$targetfilepath $basepath
sleep 2
untargetfilepath="$basepath$targetfilepath"
untarfile=`tar -zxvf $untargetfilepath`
mvtartxtfile=`mv $orgfilename $basepath`

#For Uninor Other Servvices
basepath="/var/www/html/kmis/mis/livemis/mis2.0/wap/ALL_WAP_LOGS_108/uninor/others/"
logfilename='AllUninorVisitorRequestMISNew_'
targetfilepath="$logfilename$file_date.tar.gz"
orgfilename="$logfilename$file_date.txt"
sshpass -p'Pass@123' scp -r -P2930 root@117.239.178.108:/var/www/html/hungamawap/uninor/DoubleConsent/logs/tarfiles/$targetfilepath $basepath
sleep 2
untargetfilepath="$basepath$targetfilepath"
untarfile=`tar -zxvf $untargetfilepath`
mvtartxtfile=`mv $orgfilename $basepath`

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