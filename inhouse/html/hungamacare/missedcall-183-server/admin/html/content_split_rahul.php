<ul class="list-unstyled">
    <?php if($service=='EnterpriseMcDw')
                                { ?>
<li>
         <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 0-3 Min
                                            <span class="pull-right strong"><?php echo number_format($split_check[1]);?></span>
                                            <div class="progress progress-striped">
                                                <div class="progress-bar <?php echo $bar_label1;?>" style="width: <?php echo $dur1_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 3-6 Min
                                            <span class="pull-right strong"><?php echo number_format($split_check[2]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label2;?>" style="width: <?php echo $dur2_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 6-9 Min
                                            <span class="pull-right strong"><?php echo number_format($split_check[3]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label3;?>" style="width: <?php echo $dur3_percetage;?>%;"></div>
                                            </div>
                                        </li>
										 <li>
                                            <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 9-15 Min
                                            <span class="pull-right strong"><?php echo number_format($split_check[4]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label4;?>" style="width: <?php echo $dur4_percetage;?>%;"></div>
                                            </div>
                                        </li>
										<li>
                                            <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 15-30 Min
                                            <span class="pull-right strong"><?php echo number_format($split_check[5]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label5;?>" style="width: <?php echo $dur5_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span>30+ Mins
                                            <span class="pull-right strong"><?php echo number_format($split_check[6]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label6;?>" style="width: <?php echo $dur6_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <?php }elseif($service=='EnterpriseTiscon'){ ?>
                                        
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 0-15 Mins
                                            <span class="pull-right strong"><?php echo number_format($split_check[1]);?></span>
                                            <div class="progress progress-striped">
                                                <div class="progress-bar <?php echo $bar_label1;?>" style="width: <?php echo $dur1_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span> 16-30 Mins
                                            <span class="pull-right strong"><?php echo number_format($split_check[2]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label2;?>" style="width: <?php echo $dur2_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 31-45 Mins
                                            <span class="pull-right strong"><?php echo number_format($split_check[3]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label3;?>" style="width: <?php echo $dur3_percetage;?>%;"></div>
                                            </div>
                                        </li>
										 <li>
                                            <span class="icon24 icomoon-icon-arrow-down-2 red"></span> 46-60 Mins
                                            <span class="pull-right strong"><?php echo number_format($split_check[4]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label4;?>" style="width: <?php echo $dur4_percetage;?>%;"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <span class="icon24 icomoon-icon-arrow-up-2 green"></span>60+ Mins
                                            <span class="pull-right strong"><?php echo number_format($split_check[5]);?></span>
                                            <div class="progress progress-striped ">
                                                <div class="progress-bar <?php echo $bar_label5;?>" style="width: <?php echo $dur5_percetage;?>%;"></div>
                                            </div>
                                        </li>

                                        
                                        
                                        <?php } ?>

                                    </ul>