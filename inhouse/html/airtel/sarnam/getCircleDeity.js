function get_query(){
    var url = location.href;
	var qs = url.substring(url.indexOf('?') + 1).split('&');
    for(var i = 0, result = {}; i < qs.length; i++){
        qs[i] = qs[i].split('=');
        result[qs[i][0]] = qs[i][1];
		
    }
    return result;
}

window.onload = function() {
var request = new XMLHttpRequest();
url = "circle_religion_deity.json";
request.open('GET', url, false);
request.send(null);
//alert('athar'+request.responseText)
var finalUrl=get_query();
var finalArray=finalUrl['cRId'].split("-"); 
//alert(finalArray[0]);

categories = JSON.parse(request.responseText);
var ln=categories.circle.length;
var selectcircle='GUJ';

for (i = 0; i < ln; i++) 
{
	if(categories.circle[i].CircleId===finalArray[0] && categories.circle[i].CircleName===selectcircle)
	{
		document.getElementById('img1').setAttribute('src',categories.circle[i].religion[0].DeityImage1);
		document.getElementById('a1').setAttribute('href',categories.circle[i].religion[0].DeityPage1+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId1);
		
		document.getElementById('img2').setAttribute('src',categories.circle[i].religion[0].DeityImage2);
		document.getElementById('a2').setAttribute('href',categories.circle[i].religion[0].DeityPage2+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId2);

		document.getElementById('img3').setAttribute('src',categories.circle[i].religion[0].DeityImage3);
		document.getElementById('a3').setAttribute('href',categories.circle[i].religion[0].DeityPage3+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId3);

		document.getElementById('img4').setAttribute('src',categories.circle[i].religion[0].DeityImage4);
		document.getElementById('a4').setAttribute('href',categories.circle[i].religion[0].DeityPage4+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId4);

		document.getElementById('img5').setAttribute('src',categories.circle[i].religion[0].DeityImage5);
		document.getElementById('a5').setAttribute('href',categories.circle[i].religion[0].DeityPage5+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId5);

		document.getElementById('img6').setAttribute('src',categories.circle[i].religion[0].DeityImage6);
		document.getElementById('a6').setAttribute('href',categories.circle[i].religion[0].DeityPage6+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId6);
		
		document.getElementById('img7').setAttribute('src',categories.circle[i].religion[0].DeityImage7);
		document.getElementById('a7').setAttribute('href',categories.circle[i].religion[0].DeityPage7+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId7);
		
		document.getElementById('img8').setAttribute('src',categories.circle[i].religion[0].DeityImage8);
		document.getElementById('a8').setAttribute('href',categories.circle[i].religion[0].DeityPage8+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId8);
		
		document.getElementById('img9').setAttribute('src',categories.circle[i].religion[0].DeityImage9);
		document.getElementById('a9').setAttribute('href',categories.circle[i].religion[0].DeityPage9+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId9);
		
		document.getElementById('img10').setAttribute('src',categories.circle[i].religion[0].DeityImage10);
		document.getElementById('a10').setAttribute('href',categories.circle[i].religion[0].DeityPage10+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId10);

		document.getElementById('img11').setAttribute('src',categories.circle[i].religion[0].DeityImage11);
		document.getElementById('a11').setAttribute('href',categories.circle[i].religion[0].DeityPage11+"?rDId="+categories.circle[i].religion[0].religionId+"-"+categories.circle[i].religion[0].DeityId11);




		
	}
}
	document.getElementById('downlTxt').innerHTML="download hindi songs, ringtones, wallpapers @ Rs 21";
	
}



