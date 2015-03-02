cat /var/www/html/chander/log/msisdn2.txt | while read line
do
mysql -h'192.168.100.224' -u'ivr' -p'ivr' -e "insert into reliance_hungama.charging (ani) values('$line');"
echo "Inserted MSISDN $line"

done



#insert into reliance_hungama.charging (ani) values('8653696382')
