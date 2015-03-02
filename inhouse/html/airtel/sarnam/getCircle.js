window.onload = function() {
var request = new XMLHttpRequest();
url = "circle_religion.json";
request.open('GET', url, false);
request.send(null);
//alert('athar'+request.responseText)

categories = JSON.parse(request.responseText);
var ln=categories.circle.length;
var selectcircle='GUJ';

for (i = 0; i < ln; i++) 
{
	if(categories.circle[i].CircleName===selectcircle)
	{
		document.getElementById('img1').setAttribute('src',categories.circle[i].Ref1Img);
		document.getElementById('a1').setAttribute('href',categories.circle[i].Deity1+categories.circle[i].cRId1);
		
		document.getElementById('img2').setAttribute('src',categories.circle[i].Ref2Img);
		document.getElementById('a2').setAttribute('href',categories.circle[i].Deity2+categories.circle[i].cRId2);

		document.getElementById('img3').setAttribute('src',categories.circle[i].Ref3Img);
		document.getElementById('a3').setAttribute('href',categories.circle[i].Deity3+categories.circle[i].cRId3);

		document.getElementById('img4').setAttribute('src',categories.circle[i].Ref4Img);
		document.getElementById('a4').setAttribute('href',categories.circle[i].Deity4+categories.circle[i].cRId4);

		document.getElementById('img5').setAttribute('src',categories.circle[i].Ref5Img);
		document.getElementById('a5').setAttribute('href',categories.circle[i].Deity5+categories.circle[i].cRId5);

		document.getElementById('img6').setAttribute('src',categories.circle[i].Ref6Img);
		document.getElementById('a6').setAttribute('href',categories.circle[i].Deity6+categories.circle[i].cRId6);
	}
}
	document.getElementById('downlTxt').innerHTML="download hindi songs, ringtones, wallpapers @ Rs 2";
}



