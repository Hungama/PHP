<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{

//bit_url function
function bit_url(url)
{
var url=url;

var username="atharhaider"; // bit.ly username
var key="R_c781146b43edb21caa43b6df4b05bc67";
$.ajax({
url:"http://api.bit.ly/v3/shorten",data:{longUrl:url,apiKey:key,login:username},dataType:"jsonp",
success:function(v)
{
var bit_url=v.data.url;
$("#result").html('<a href="'+bit_url+'" target="_blank">'+bit_url+'</a>');
}
});
}


$("#short").click(function()
{
var url=$("#url").val();
var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
var urltest=urlRegex.test(url);
if(urltest)
{
	bit_url(url);
}
else
{
	alert("Bad URL");
}
});

});
</script>

<input type="text" name="url" id="url"/>
<input type="submit" id="short" value="Submit"/>
<div id="result"></div>