<?

echo "hello";
include("config/dbConnect.php");
//include("/var/www/html/kmis/services/HCMT/new_content_add.sh");


//include '/var/www/html/kmis/services/HCMT/Excel/reader.php';

$target_path1 = "uploads/";
$target_path1 = $target_path1.$_FILES['excelfile']['name']; 
$res=explode('.',$_FILES['excelfile']['name']);
if($res[1] == 'csv' && $_FILES['excelfile']['error'] == '0')
  {
    if(move_uploaded_file($_FILES['excelfile']['tmp_name'], $target_path1)) 
		{
			echo "The file ".$_FILES['excelfile']['name']. " has been uploaded";
			chmod($target_path1,0777);
			$filedir="/var/www/html/kmis/services/HCMT/uploads/";
			$filename=$filedir.$_FILES['excelfile']['name'];
			$filedata=file($filename);
			echo '<pre>';
			print_r($filedata);
			 $filesize=count($filedata);

			for ($i=1; $i<$filesize; $i++ )
			{
				$output=explode(',',$filedata[$i]);
				//echo "<pre>";				print_r($output);
				
				if(trim($output[2])!= " ")
				{
					echo "yes";
				/*	$sql="insert into test.tbl_new_content20110623(Date,Sno,SongUniqueCode,AltruistID,FilePath,ContentName,AlbumName,ReleaseYear,ReleaseMonth,	MalePerformers,FemalePerformers,Lyricist,MusicDirector,MaleSingers,FemaleSingers,Language,Genre,SubGenre,Category,SubCategory,Ocasion,Mood,Rating,ISRC,LabelCode,SongNumber,SongDuration,OST,ArtistBirthDate,ArtistDeathDate,Copyright,IVRRights,OnlineRights,WAPRights,ContentExpiry,	RecordLabel,Publisher,Royalty,ContentAggregator,Country,Producer,Director,Description,Cat_ID,CRBT_ID,MT_ID,PT_ID,TT_ID,FSD_ID,Video_ID,Score_ID,BusinessCategory1)";

//$sql .="values('".trim($output[0])."','".trim($output[1])."','".trim($output[2])."','".trim($output[3])."','".trim($output[4])."','".trim($output[5])."','".trim($output[6])."','".trim($output[7])."','".trim($output[8])."','".trim($output[9])."')";

$sql .="values('".trim($output[0])."','".trim($output[1])."','".trim($output[2])."','".trim($output[3])."','".trim($output[4])."','".trim($output[5])."','".trim($output[6])."','".trim($output[7])."','".trim($output[8])."','".trim($output[9])."','".trim($output[10])."','".trim($output[11])."','".trim($output[12])."','".trim($output[13])."','".trim($output[14])."','".trim($output[15])."','".trim($output[16])."','".trim($output[17])."','".trim($output[18])."','".trim($output[19])."','".trim($output[20])."','".trim($output[21])."','".trim($output[22])."','".trim($output[23])."','".trim($output[24])."','".trim($output[25])."','".trim($output[26])."','".trim($output[27])."','".trim($output[28])."','".trim($output[29])."','".trim($output[30])."','".trim($output[31])."','".trim($output[32])."','".trim($output[33])."','".trim($output[34])."','".trim($output[35])."','".trim($output[36])."','".trim($output[37])."','".trim($output[38])."','".trim($output[39])."','".trim($output[40])."','".trim($output[41])."','".trim($output[42])."','".trim($output[43])."','".trim($output[44])."','".trim($output[45])."','".trim($output[46])."','".trim($output[47])."','".trim($output[48])."','".trim($output[49])."','".trim($output[50])."','".trim($output[51])."')";
					echo $sql;
					//exit;
					mysql_query($sql,$dbConn) or die(mysql_error()); 8*/
				
					

				} // end of if(trim($output[2])!= " ")
				else
				{
					echo "no" ;
					//echo '<pre>';
					//print_r($output);
					
				}// end of else condition
					
            }// end of for ($i=1; $i<=$filesize; $i++ ) loop

			//shell_exec('./new_content_add.sh');
			$output = shell_exec("add_content.sh");
			echo $output;
			
			//$last_line = system("/var/www/html/kmis/services/HCMT/add_content.sh");
			//echo $last_line;
			if(file_exists("./new_content_add.sh"))
				echo "athar";
			else
				echo "haider";
			//echo "<pre>$output</pre>";
		 /*   while($filesize > 0)
			{
				$sql1="select foldername,songcount from test.folder_metadata_dump20110623 where songcount<500 order by songcount limit 1";
				mysql_query($sql1,$dbConn) or die(mysql_error());
				if(isset($sql1))
				{
						
						$foldername=$row['foldername'];
						$songcount=$row['songcount'];

						echo $foldername;
						echo $songcount;
							
						//check space in folder
						$limt=500-$songcount;
						echo $limit;
							
						if($filesize < $limit)
						{
							for($j=$filesize; $j>0; $j--)
							{
									echo "inside first if";	
								   //update foledrname//

									$sql_update="update test.tbl_new_content20110623 set foldername='$foldfername' where foldername is null limit";
									mysql_query($sql_update,$dbConn) or die(mysql_error());

									//update songid in tbl_new_content
									mysql_query("update test.tbl_new_content20110623 set songid=concat('$foldername','_','SongUniqueCode') where foldername='$foldername' and songid is null limit 1");

									//update rowcount 

									mysql_query("update test.folder_metadata_dump20110623 set songcount=('$songcount'+1) where foldername='$foldername'");
									$filesize=$filesize-1;
								}

								mysql_query("insert into master_content(SongUniqueCode,FilePath,ContentName,AlbumName,ReleaseYear,ReleaseMonth,MalePerformers,FemalePerformers,Lyricist,MusicDirector,MaleSingers,FemaleSingers,language,Genre,SubGenre,Category,SubCategory,Ocasion,Mood,Rating,ISRC,LabelCode,SongNumber,SongDuration,OST,copyright,Royalty,ContentAggregator,Country,cat_ID,cRBT_ID,MT_ID,PT_ID,TT_ID,FSD_ID,Video_ID,Score_ID,BusinessCategory1,foldername,songid,docomotag) select SongUniqueCode,FilePath,ContentName,AlbumName,ReleaseYear,ReleaseMonth,MalePerformers,FemalePerformers,Lyricist,MusicDirector,MaleSingers,FemaleSingers,language,Genre,SubGenre,Category,SubCategory,Ocasion,Mood,Rating,ISRC,LabelCode,SongNumber,SongDuration,OST,copyright,Royalty,ContentAggregator,Country,cat_ID,cRBT_ID,MT_ID,PT_ID,TT_ID,FSD_ID,Video_ID,Score_ID,BusinessCategory1,foldername,songid,docomotag from tbl_new_content where foldername='$FOLDERNAME' and songid=concat('$FOLDERNAME','_',SongUniqueCode)");
						}
								
						else
						{
						}	
						
				}
				else{}
					
						
				}

		
		}*/
		} // end of if(move_uploaded_file($_FILES['excelfile']['tmp_name'], $target_path1))
		else
		{
			echo "There was an error uploading the file, please try again!";
		}
} // end of if($res[1] == 'csv' && $_FILES['excelfile']['error'] == '0')
  else
  {
       echo "not in correct format";
  }
// $mysql_close($dbConn);
?>