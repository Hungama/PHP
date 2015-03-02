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
url = "diety_content_wall.json";
request.open('GET', url, false);
request.send(null);
//alert('athar'+request.responseText)
var finalUrl=get_query();
var finalArray=finalUrl['rDId'].split("-"); 
//alert(finalArray[1]);

categories = JSON.parse(request.responseText);
//alert(categories);
var ln=categories.deity.length;
var selectcircle='GUJ';

for (i = 0; i < ln; i++) 
{
	if(categories.deity[i].DeityId===finalArray[1])
	{
		document.getElementById('deitiyName1').innerHTML=categories.deity[i].DeityName;

		var Infoln=categories.deity[i].ContInfo.length;
		
		var k=0;
		for (j = 0; j < Infoln; j++) 
		{
			if(categories.deity[i].ContInfo[j].Category==='Wallpapers')
			{
				var tagId='img'+(k+1)
				var sId='s'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[j].ImageLink+categories.deity[i].ContInfo[j].ContentId+'.gif');
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[j].ContentDesc+"</font>";
				k++
				if(k===4)
					break;
			}
		}
		var k=0;
		for (j = 0; j < Infoln; j++) 
		{
			if(categories.deity[i].ContInfo[j].Category==='Animation')
			{
				var tagId='aimg'+(k+1)
				var sId='as'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[j].ImageLink+categories.deity[i].ContInfo[j].ContentId+'.gif');
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+categories.deity[i].ContInfo[j].ContentDesc+"</font>";
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
		for (j = 0; j < Infoln; j++) 
		{
			if(categories.deity[i].ContInfo[j].Category==='Video')
			{
				var tagId='vimg'+(k+1)
				var sId='vs'+(k+1)
				document.getElementById(tagId).setAttribute('src',categories.deity[i].ContInfo[j].ImageLink+categories.deity[i].ContInfo[j].ContentId+'.gif');
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+lineBreaks(categories.deity[i].ContInfo[j].ContentDesc,10)+"</font>";
				k++
				if(k===4)
					break;
			}
		}
		var k=0;
		for (j = 0; j < Infoln; j++) 
		{
			//alert(categories.deity[i].ContInfo[j].Category);
			if(categories.deity[i].ContInfo[j].Category==='FLA')
			{
				var tagId='fimg'+(k+1)
				var sId='fs'+(k+1)
				document.getElementById(tagId).setAttribute('src',"http://119.82.69.212/airtel/sarnam/images1/ringtone_thum1.gif");
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+lineBreaks(categories.deity[i].ContInfo[j].ContentDesc,10)+"</font>";
				k++
				if(k===4)
					break;
			}
		}
		var k=0;
		for (j = 0; j < Infoln; j++) 
		{
			if(categories.deity[i].ContInfo[j].Category==='ringtone')
			{
				var tagId='rimg'+(k+1)
				var sId='rs'+(k+1)
				document.getElementById(tagId).setAttribute('src',"http://119.82.69.212/airtel/sarnam/images1/fulltracks_thum1.gif");
				document.getElementById(tagId).setAttribute('height','50');
				document.getElementById(tagId).setAttribute('width','65');
				document.getElementById(sId).innerHTML="<font color='black'>"+lineBreaks(categories.deity[i].ContInfo[j].ContentDesc,10)+"</font>";
				k++
				if(k===4)
					break;
			}
		}
	}
}
/*	document.getElementById('downlTxt1').innerHTML="Wallpaper";
	document.getElementById('downlTxt2').innerHTML="Animation";
	document.getElementById('themedownlTxt').innerHTML="Theme";
	document.getElementById('videodownlTxt').innerHTML="Video";
	document.getElementById('fladownlTxt').innerHTML="Full Length Audio";
	*/
	
}



