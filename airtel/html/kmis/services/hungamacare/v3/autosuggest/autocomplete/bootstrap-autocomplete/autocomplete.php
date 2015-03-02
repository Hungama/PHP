<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Language" content="en-us">
<title>Bootstrap Autocomplete</title>
<meta charset="utf-8">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/bootstrap.js"></script> 
<script type="text/javascript" src="js/typeahead.js"></script> 
<style>
h1{
font-size: 20px;
color: #111;
}
.content{
	width: 80%;
	margin: 0 auto;
	margin-top: 50px;
}

.typeahead-devs, .tt-hint,.country,.allcountry  {
 	border: 2px solid #CCCCCC;
    border-radius: 8px 8px 8px 8px;
    font-size: 24px;
    height: 45px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
    width: 400px;
}

.tt-dropdown-menu {
  width: 400px;
  margin-top: 5px;
  padding: 8px 12px;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 8px 8px 8px 8px;
  font-size: 18px;
  color: #111;
  background-color: #F1F1F1;
}

</style>
<script>
$(document).ready(function() {
$('input.typeahead-devs').typeahead({
  name: 'accounts',
  local: ['Sunday', 'Monday', 'Tuesday','Wednesday','Thursday','Friday','Saturday']
});

$('input.country').typeahead({
  name: 'country',
  remote : 'country.php?query=%QUERY'

});

$('input.allcountry').typeahead({
  name: 'allcountry',
  prefetch : 'allcountry.php'
});

})
</script>
</head>
<body>
<div class="content">

<h1>Select data from Array</h1>
<form method="POST" action="#">
	<input type="text" name="accounts" size="20" class="typeahead-devs" placeholder="Please Enter Day Name">


<h1>Select data from Database</h1>
<input type="text" name="country" size="20" class="country" placeholder="Please Enter County">


<h1>Pre fetched data from Database</h1>
<input type="text" name="allcountry" size="20" class="allcountry" placeholder="Please Enter County">	
	
</form>
</div>    
</body>
</html>