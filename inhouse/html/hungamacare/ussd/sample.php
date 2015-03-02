<!DOCTYPE html>
<html dir="ltr" lang="en-US">
   <head>
      <meta charset="UTF-8" />
      <title>A date range picker for Twitter Bootstrap</title>
	  <?php 
require_once("main-header.php");
?>
      <link rel="stylesheet" type="text/css" media="all" href="http://119.82.69.212/hungamacare/ussd/daterangepicker.css" />
      <script type="text/javascript" src="http://119.82.69.212/hungamacare/2.0/assets/js/jquery.js"></script>
      <script type="text/javascript" src="http://119.82.69.212/hungamacare/ussd/date.js"></script>
      <script type="text/javascript" src="http://119.82.69.212/hungamacare/ussd/daterangepicker.js"></script>
	    <link href="http://119.82.69.212/hungamacare/2.0/assets/css/bootstrap.css" rel="stylesheet" media="screen">
   </head>
   <body>

      <div class="container">
         <div class="span12">

            <div class="well">

                   <fieldset>
                  <div class="control-group">
                    <label class="control-label" for="reservation">Reservation dates:</label>
                    <div class="controls">
                     <div class="input-prepend">
                       <span class="add-on"><i class="icon-calendar"></i></span><input type="text" name="reservation" id="reservation" value="03/18/2013 - 03/23/2013" />
                     </div>
                    </div>
                  </div>
                 </fieldset>
                       <script type="text/javascript">
               $(document).ready(function() {
                  $('#reservation').daterangepicker();
               });
               </script>

            </div>
  <?php
 //require_once("footer.php");
  ?>
          </div>
      </div>
   </body>
</html>
