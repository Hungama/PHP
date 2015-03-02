  <ul class="nav navbar-right usernav">
                   
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                            <!--img src="images/avatar.jpg" alt="" class="image" /-->
							<?php
							$imgurl="http://bugify.hungamavoice.com/assets/gravatar/32/".$_SESSION['email'];
							?>
							<img src="<?php echo $imgurl;?>" alt="" class="image" />							
                            <span class="txt"><?php echo $_SESSION['loginId'];?></span>
                            <!--b class="caret"></b-->
                        </a>
						<!--ul class="dropdown-menu">
                            <li class="menu">
                                <ul>
                                    <li><a href="dashboardGLC1.php"><span class="icon16 icomoon-icon-user"></span>Dashboard</a></li>
                                    <li><a href="bulkUploadGLC.php"><span class="icon16 icomoon-icon-bubble-2"></span>BulkUpload</a></li>
                                </ul>
                            </li>
                        </ul-->
                       
                    </li>
					<li><a href="dashboardGLC1.php"><span class="icon16 icomoon-icon-grid-3"></span><span class="txt"> Dashboard</span></a></li>
					<li><a href="bulkUploadGLC.php"><span class="icon16 icomoon-icon-upload-3"></span><span class="txt"> BulkUpload</span></a></li>
                    <li><a href="logout.php"><span class="icon16 icomoon-icon-exit"></span><span class="txt"> Logout</span></a></li>
                </ul>