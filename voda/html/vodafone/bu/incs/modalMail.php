<?php
require_once("../../../Public/database.class.php");

?>	<p>
                        Circles: <input type="text" id="mailer-list-circle" name="mailer-list-circle" />
                        </p>
                        
                        <p>Recipients: </p>
                        
                        <p>Carbon Copy: </p>
    				<input type="text" id="mailer-list-cc-val" name="mailer-list-cc-val" />
                  
                  <script>
   				 var tmpmail1 = [{"id":"Andhra Pradesh","name":"Andhra Pradesh"}];
    
          		 
				 
					$("#mailer-list-circle").tokenInput("incs/getUsers.php?f=name,email",{prePopulate: tmpmail1});
					
					
                  
                  
                  </script>
                  