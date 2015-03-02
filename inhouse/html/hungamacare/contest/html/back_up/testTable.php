<?php
$eurevampDataValue=;
?>
<table border="1">
                    <tr> 
                        <?php
						
                        $k = 1;
                        $i = -1;
                        for ($j = 1; $j <= $eurevampDataValue; $j++) {
                            $i++;
                            if ($i % 3 == 0 && $i != 0) {
                                echo "</tr><tr>";
                            }

                            
                                  ?>
                                <td><span class="label">&nbsp;&nbsp;&nbsp;<?php echo $k; ?>&nbsp;&nbsp;&nbsp;</span>
                            hello       
                                </td>
                                <?php
                                $k++;
                            
                        }
                        ?>
                        <?php
                        for ($k1 = 1; $k1 < (3 - $i % 3); $k1++) {
                            // echo "<td>&nbsp;</td>";
                        }
                        ?>
                    </tr>
                </table>
				
