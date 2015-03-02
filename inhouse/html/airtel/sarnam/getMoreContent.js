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
var startFrom=finalUrl['start'];
var type=finalUrl['type'];
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
		if(type==='wall')
		document.getElementById('contenType').innerHTML="Wallpaper";
		if(type==='anim')
			document.getElementById('contenType').innerHTML="Animations";
		if(type==='video')
			document.getElementById('contenType').innerHTML="Videos";
		if(type==='ring')
			document.getElementById('contenType').innerHTML="Ringtones";
		if(type==='fla')
			document.getElementById('contenType').innerHTML="FLA";




		var moreWallPageLink=categories.deity[i].MorePage;
		var previousWallPageLink="http://119.82.69.212/airtel/sarnam/subCat2.php?rDId="+finalArray[0]+"-"+finalArray[1];
		var WallInfoln=categories.deity[i].ContInfo[0].wallpaper.length;
		var k=0;
		for (j = (startFrom-1); j < WallInfoln; j++) 
		{
			if(categories.deity[i].ContInfo[0].wallpaper[j].sno==(j+1) && type==='wall')
			{
				var tagId='img'+(k+1)
				var sId='s'+(k+1)
				var a='a'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[0].wallpaper[j].ImageLink+categories.deity[i].ContInfo[0].wallpaper[j].ContentId+'.gif');
				document.getElementById(a).setAttribute('href',"http://202.87.41.147/hungamawap/airtel/voiceT/charging.php?contId="+categories.deity[i].ContInfo[0].wallpaper[j].ContentId+"&type=wall");
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[0].wallpaper[j].ContentDesc+"</font>";
				
				k++
				if(k===4)
					break;
			}
		}
		var k=0;
		var AniInfoln=categories.deity[i].ContInfo[1].Animation.length;
		var moreAnimPageLink=categories.deity[i].MorePage;
		var previousAnimPageLink="http://119.82.69.212/airtel/sarnam/subCat2.php?rDId="+finalArray[0]+"-"+finalArray[1];

		for (j = startFrom-1; j < AniInfoln; j++) 
		{
			if(categories.deity[i].ContInfo[1].Animation[j].sno==(j+1) && type==='anim')
			{
				var tagId='img'+(k+1)
				var sId='s'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[1].Animation[j].ImageLink+categories.deity[i].ContInfo[1].Animation[j].ContentId+'.gif');
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[1].Animation[j].ContentDesc+"</font>";
				k++
				if(k===4)
					break;

			}
		}
		/*var k=0;
		for (j = (startFrom-1); j < Infoln; j++) 
		{
			if(categories.deity[i].ContInfo[j].Category==='Theme' && type==='theme')
			{
				var tagId='timg'+(k+1)
				var sId='ts'+(k+	1)
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
		for (j = (startFrom-1); j < VideoInfoln; j++) 
		{

			if(categories.deity[i].ContInfo[2].video[j].sno==(j+1) && type==='video')
			{
				
				var tagId='img'+(k+1)
				var sId='s'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[2].video[j].ImageLink+categories.deity[i].ContInfo[2].video[j].ContentId+'.gif');
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
		for (j = (startFrom-1); j < FlaInfoln; j++) 
		{
		if(categories.deity[i].ContInfo[3].FLA[j].sno==(j+1) && type==='fla'){

				var tagId='img'+(k+1)
				var sId='s'+(k+1)
				document.getElementById(tagId).setAttribute('src',"http://119.82.69.212/airtel/sarnam/images1/fulltracks_thum1.gif");
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
		for (j = (startFrom-1); j < RngInfoln; j++) 
		{
			if(categories.deity[i].ContInfo[4].ringtone[j].sno==(j+1) && type==='ring')
			{
				var tagId='img'+(k+1)
				var sId='s'+(k+1)
				document.getElementById(tagId).setAttribute('src',"http://119.82.69.212/airtel/sarnam/images1/ringtone_thum1.gif");
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
if(WallInfoln>parseInt(startFrom)+8)
	document.getElementById('wallmore').innerHTML="<a href="+moreWallPageLink+">more wall images...</a>";
else if(type==='wall')
	document.getElementById('wallmore').innerHTML="<a href="+previousWallPageLink+">...Previous image</a>";
/*
if(AniInfoln>4) 
	document.getElementById('animmore').innerHTML="more images1...";
if(VideoInfoln>4)
	document.getElementById('videomore').innerHTML="more images2...";
*/

if(AniInfoln>parseInt(startFrom)+8)
	document.getElementById('wallmore').innerHTML="<a href="+moreAnimPageLink+">more animations...</a>";
else if(type==='anim')
	document.getElementById('wallmore').innerHTML="<a href="+previousAnimPageLink+">..Previous animation<br/></a>";


if(FlaInfoln>parseInt(startFrom)+8)
	document.getElementById('wallmore').innerHTML="<a href="+moreWallPageLink+">more Fla...</a>";
else if(type==='fla')
	document.getElementById('wallmore').innerHTML="<a href="+previousWallPageLink+">...Previous fla</a>";
if(RngInfoln>parseInt(startFrom)+8)
	document.getElementById('wallmore').innerHTML="<a href="+moreWallPageLink+">more ringtones...</a>";
else if(type==='ring')
	document.getElementById('wallmore').innerHTML="<a href="+previousWallPageLink+">...Previous ringtones</a>";






	/*
	document.getElementById('downlTxt2').innerHTML="Animation";
	document.getElementById('themedownlTxt').innerHTML="Theme";
	document.getElementById('videodownlTxt').innerHTML="Video";
	document.getElementById('fladownlTxt').innerHTML="Full Length Audio";
	*/
	
}



