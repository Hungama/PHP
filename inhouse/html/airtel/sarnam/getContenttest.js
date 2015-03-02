function get_query(){
    var url = location.href;
	var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = qs[i][1];
		
    }
    return result;
}

function lineBreaks(text, maxlength)
{
  var len = text.length;
  var pos = -1;
  var replace = true;
  for (var i=maxlength; i<len; i += maxlength)
  {
    var separator = "\n"
    for (var pos = i; text.charAt(pos) != " "; pos--)
    {
      if (pos == i-maxlength)
      {
        pos = i;
        separator += text.charAt(pos);
        len++;
        break;
      }
    }
    text = text.substring(0, pos) + separator + text.substring(pos+1, len-1);
    i = pos;
    replace = true;
  }
	return text;
}

window.onload = function() {
var request = new XMLHttpRequest();
url = "diety_content_wall_test.json";
request.open('GET', url, false);
request.send(null);
//alert('athar'+request.responseText)
var finalUrl=get_query();
var finalArray=finalUrl['rDId'].split("-"); 
//alert(finalArray[1]);

categories = JSON.parse(request.responseText);
var ln=categories.deity.length;
var selectcircle='GUJ';

for (i = 0; i < ln; i++) 
{
	
	if(categories.deity[i].DeityId===finalArray[1])
	{
		document.getElementById('deitiyName1').innerHTML=categories.deity[i].DeityName;
		
		var moreWallPageLink=categories.deity[i].MorePage +"&rDId="+finalArray[0]+"-"+finalArray[1];
		var moreAnimPageLink=categories.deity[i].animMorePage +"&rDId="+finalArray[0]+"-"+finalArray[1];
		var moreVideoPageLink=categories.deity[i].videoMorePage +"&rDId="+finalArray[0]+"-"+finalArray[1];
		var moreRingPageLink=categories.deity[i].ringMorePage +"&rDId="+finalArray[0]+"-"+finalArray[1];
		var moreFlaPageLink=categories.deity[i].flaMorePage +"&rDId="+finalArray[0]+"-"+finalArray[1];
		var assoDeityName1=categories.deity[i].AssociatedDeityName1;
		var assoDeityImage1=categories.deity[i].AssociatedDeityImage1;
		var assoDeityPath1=categories.deity[i].AssociatedDeity1Path1;
		
		var assoDeityName2=categories.deity[i].AssociatedDeityName2;
		var assoDeityImage2=categories.deity[i].AssociatedDeityImage2;
		var assoDeityPath2=categories.deity[i].AssociatedDeity1Path2;

		var assoDeityName3=categories.deity[i].AssociatedDeityName3;
		var assoDeityImage3=categories.deity[i].AssociatedDeityImage3;
		var assoDeityPath3=categories.deity[i].AssociatedDeity1Path3;
		
		var assoDeityName4=categories.deity[i].AssociatedDeityName4;
		var assoDeityImage4=categories.deity[i].AssociatedDeityImage4;
		var assoDeityPath4=categories.deity[i].AssociatedDeity1Path4;

		var WallInfoln=categories.deity[i].ContInfo[0].wallpaper.length;
		var k=0;
		for (j = 0; j < WallInfoln; j++) 
		{
			if(categories.deity[i].ContInfo[0].wallpaper[j].sno==(j+1))
			{
				var tagId='img'+(k+1)
				var sId='s'+(k+1)
				var hr='hr'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[0].wallpaper[j].ImageLink+categories.deity[i].ContInfo[0].wallpaper[j].ContentId+'.gif');
				document.getElementById(hr).setAttribute('href',"http://202.87.41.147/hungamawap/airtel/voiceT/charging.php?contId="+categories.deity[i].ContInfo[0].wallpaper[j].ContentId+"&type=wall&rDId="+finalArray[0]+"-"+finalArray[1]);
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[0].wallpaper[j].ContentDesc+"</font></a>";
				k++
				if(k===4)
					break;
			}
		}
		var k=0;
		var AniInfoln=categories.deity[i].ContInfo[1].Animation.length;
		for (j = 0; j < AniInfoln; j++) 
		{
			if(categories.deity[i].ContInfo[1].Animation[j].sno==(j+1))
			{
				var tagId='aimg'+(k+1)
				var sId='as'+(k+1)
				var ah='ahr'+(k+1)

				
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[1].Animation[j].ImageLink+categories.deity[i].ContInfo[1].Animation[j].ContentId+'.gif');
				document.getElementById(ah).setAttribute('href',"http://119.82.69.212/airtel/sarnam/charging.php?contId="+categories.deity[i].ContInfo[1].Animation[j].ContentId+"&type=anim");

				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[1].Animation[j].ContentDesc+"</font>";
				k++
				if(k===4)
					break;
			}
		}
		/*var k=0;
		for (j = 0; j < Infoln; j++) 
		{
			if(categories.deity[i].ContInfo[j].Category==='Theme')
			{
				var tagId='timg'+(k+1)
				var sId='ts'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[j].ImageLink+categories.deity[i].ContInfo[j].ContentId+'.gif');
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[j].ContentDesc+"</font>";
				k++
				if(k===3)
					break;
			}
		}*/
		var k=0;
		var VideoInfoln=categories.deity[i].ContInfo[2].video.length;
		for (j = 0; j < VideoInfoln; j++) 
		{

			if(categories.deity[i].ContInfo[2].video[j].sno==(j+1))
			{
				var tagId='vimg'+(k+1)
				var sId='vs'+(k+1)
				var vh='vhr'+(k+1)
				
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[2].video[j].ImageLink+categories.deity[i].ContInfo[2].video[j].ContentId+'.gif');
				document.getElementById(vh).setAttribute('href',"http://119.82.69.212/airtel/sarnam/charging.php?contId="+categories.deity[i].ContInfo[2].video[j].ContentId+"&type=video");

				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[2].video[j].ContentDesc+"</font>";
				k++
				if(k===4)
					break;
			}
		}
		var k=0;
		var FlaInfoln=categories.deity[i].ContInfo[3].FLA.length;
		for (j = 0; j < FlaInfoln; j++) 
		{
			if(categories.deity[i].ContInfo[3].FLA[j].sno==(j+1)){

				var tagId='fimg'+(k+1)
				var sId='fs'+(k+1)
				var fh='fhr'+(k+1)
				
				document.getElementById(tagId).setAttribute('src',"http://119.82.69.212/airtel/sarnam/images1/ringtone_thum1.gif");
				document.getElementById(fh).setAttribute('href',"http://119.82.69.212/airtel/sarnam/charging.php?contId="+categories.deity[i].ContInfo[3].FLA[j].ContentId+"&type=FLA");
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[3].FLA[j].ContentDesc+"</font>";				
				k++
				if(k===4)
					break;
			}
		}
		var k=0;
		var RngInfoln=categories.deity[i].ContInfo[4].ringtone.length;
		for (j = 0; j < RngInfoln; j++) 
		{
			if(categories.deity[i].ContInfo[4].ringtone[j].sno==(j+1))
			{
				var tagId='rimg'+(k+1)
				var sId='rs'+(k+1)
				var rh='rhr'+(k+1)
				
				document.getElementById(tagId).setAttribute('src',"http://119.82.69.212/airtel/sarnam/images1/fulltracks_thum1.gif");
				document.getElementById(rh).setAttribute('href',"http://119.82.69.212/airtel/sarnam/charging.php?contId="+categories.deity[i].ContInfo[4].ringtone[j].ContentId+"&type=FLA");
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[4].ringtone[j].ContentDesc+"</font>";				
				k++
				if(k===4)
					break;
			}
		}
}
}
if(WallInfoln>4)
	document.getElementById('wallmore').innerHTML="<a href="+moreWallPageLink+">more wallpaper</a>";
if(AniInfoln>4)
	document.getElementById('animmore').innerHTML="<a href="+moreAnimPageLink+">more animation...</a>";
if(VideoInfoln>4)
	document.getElementById('videomore').innerHTML="<a href="+moreVideoPageLink+">more videos...</a>";
if(FlaInfoln>4)
	document.getElementById('flamore').innerHTML="<a href="+moreRingPageLink+">more ringtone...</a>";
if(RngInfoln>4)
	document.getElementById('ringmore').innerHTML="<a href="+moreFlaPageLink+">more Fla...</a>";

// To Print the First Associated Deities
	document.getElementById('asscoimg1').setAttribute('src',assoDeityImage1);
	document.getElementById('asscoimg1').setAttribute('height','50');
	document.getElementById('asscoimg1').setAttribute('width','65');
	document.getElementById('ah1').setAttribute('href',assoDeityPath1);
	
// To Print the Second Associated Deities
	document.getElementById('asscoimg2').setAttribute('src',assoDeityImage2);
	document.getElementById('asscoimg2').setAttribute('height','50');
	document.getElementById('asscoimg2').setAttribute('width','65');
	document.getElementById('ah2').setAttribute('href',assoDeityPath2);	

// To Print third Associated Deities
	document.getElementById('asscoimg3').setAttribute('src',assoDeityImage3);
	document.getElementById('asscoimg3').setAttribute('height','50');
	document.getElementById('asscoimg3').setAttribute('width','65');
	document.getElementById('ah3').setAttribute('href',assoDeityPath3);	

// To Print 4th Associated Deities
	document.getElementById('asscoimg4').setAttribute('src',assoDeityImage4);
	document.getElementById('asscoimg4').setAttribute('height','50');
	document.getElementById('asscoimg4').setAttribute('width','65');
	document.getElementById('ah4').setAttribute('href',assoDeityPath4);	

	if(finalArray[0]==1)
	{
	document.getElementById('titleContMore').innerHTML="<h2>Associated deities</h2>";
	document.getElementById('aartiimg').setAttribute('src',"images1/songlist_img08.jpg");
	document.getElementById('bhajanimg').setAttribute('src',"images1/songlist_img09.jpg");
	document.getElementById('yaatraimg').setAttribute('src',"images1/songlist_img10.jpg");
	document.getElementById('chalisimg').setAttribute('src',"images1/songlist_img11.jpg");
	document.getElementById('stutiimg').setAttribute('src',"images1/songlist_img12.jpg");
	}
	if(finalArray[0]==1)
	{
		document.getElementById('sikhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=4-20");
		document.getElementById('sikhsp').innerHTML="sikhism";
		document.getElementById('islamhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=2-18");
		document.getElementById('islamsp').innerHTML="islam";
		document.getElementById('jainhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=6-22");
		document.getElementById('jainsp').innerHTML="jainism";
		document.getElementById('buddhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=5-21");
		document.getElementById('buddhsp').innerHTML="buddhism";
		document.getElementById('chrishr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=1-4");
		document.getElementById('chrissp').innerHTML="christianity";
	}
	if(finalArray[0]==2)
	{
		document.getElementById('sikhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=4-20");
		document.getElementById('sikhsp').innerHTML="sikhism";
		document.getElementById('islamhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/deity.php?cRId=1-1");
		document.getElementById('islamsp').innerHTML="hinduism";
		document.getElementById('jainhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=6-22");
		document.getElementById('jainsp').innerHTML="jainism";
		document.getElementById('buddhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=5-21");
		document.getElementById('buddhsp').innerHTML="buddhism";
		document.getElementById('chrishr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=1-4");
		document.getElementById('chrissp').innerHTML="christian";
	}
	if(finalArray[0]==3)
	{
		document.getElementById('sikhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=2-18");
		document.getElementById('sikhsp').innerHTML="islam";
		document.getElementById('islamhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/deity.php?cRId=1-1");
		document.getElementById('islamsp').innerHTML="hinduism";
		document.getElementById('jainhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=6-22");
		document.getElementById('jainsp').innerHTML="jainism";
		document.getElementById('buddhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=5-21");
		document.getElementById('buddhsp').innerHTML="buddhism";
		document.getElementById('chrishr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=1-4");
		document.getElementById('chrissp').innerHTML="christian";
	}
	if(finalArray[0]==4)
	{
		document.getElementById('sikhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=2-18");
		document.getElementById('sikhsp').innerHTML="islam";
		document.getElementById('islamhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/deity.php?cRId=1-1");
		document.getElementById('islamsp').innerHTML="hinduism";
		document.getElementById('jainhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=6-22");
		document.getElementById('jainsp').innerHTML="jainism";
		document.getElementById('buddhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=5-21");
		document.getElementById('buddhsp').innerHTML="buddhism";
		document.getElementById('chrishr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=1-4");
		document.getElementById('chrissp').innerHTML="christian";
	}
	if(finalArray[0]==5)
	{
		document.getElementById('sikhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=2-18");
		document.getElementById('sikhsp').innerHTML="islam";
		document.getElementById('islamhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/deity.php?cRId=1-1");
		document.getElementById('islamsp').innerHTML="hinduism";
		document.getElementById('jainhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=6-22");
		document.getElementById('jainsp').innerHTML="jainism";
		document.getElementById('buddhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=1-4");
		document.getElementById('buddhsp').innerHTML="christian";
		document.getElementById('chrishr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=4-20");
		document.getElementById('chrissp').innerHTML="sikhism";
	}
	if(finalArray[0]==6)
	{
		document.getElementById('sikhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=2-18");
		document.getElementById('sikhsp').innerHTML="islam";
		document.getElementById('islamhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/deity.php?cRId=1-1");
		document.getElementById('islamsp').innerHTML="hinduism";
		document.getElementById('jainhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=5-21");
		document.getElementById('jainsp').innerHTML="buddhism";
		document.getElementById('buddhhr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=1-4");
		document.getElementById('buddhsp').innerHTML="christian";
		document.getElementById('chrishr').setAttribute('href',"http://119.82.69.212/airtel/sarnam/subCat2.php?rDId=4-20");
		document.getElementById('chrissp').innerHTML="sikhism";
	}

/*
	document.getElementById('downlTxt2').innerHTML="Animation";
	document.getElementById('themedownlTxt').innerHTML="Theme";
	document.getElementById('videodownlTxt').innerHTML="Video";
	document.getElementById('fladownlTxt').innerHTML="Full Length Audio";
	*/
	
}



