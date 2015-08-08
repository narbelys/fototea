<?php $mod_q = mysql_query("SELECT m.id, m.description, m.icon, m.url FROM modules m,submodules s, security ss WHERE s.modules_id = m.id AND ss.modules_id = s.id AND ss.users_id = $_COOKIE[id] GROUP BY m.id ORDER BY m.order");


?>
<div class="mainleftinner">
            
              	<div class="leftmenu">
            		<ul>
                    <li><a href="dashboard.php" class="dashboard"><span>Inicio</span></a></li>
 			<?php while($mod_list = mysql_fetch_object($mod_q)){ 
			
			$submod_q = listAll("submodules","WHERE modules_id = $mod_list->id ORDER BY submodules.order");
			$submod_row = mysql_num_rows($submod_q);
			
			?>                   
                    
                    
                    	<li <?php if (strpos($_SERVER['PHP_SELF'], $mod_list->url)==true){?>class="current" <?php } ?>><a href="<?php echo $mod_list->url;?>.php" class="<?php echo $mod_list->icon;?>  <?php if($submod_row > 0){ ?>menudrop<?php } ?>"><span><?php echo $mod_list->description;?></span></a>
                        <?php if($submod_row > 0){ ?>
							<ul>
                        <?php while($submod_list = mysql_fetch_object($submod_q)){ 
						$act = validaAcceso($_COOKIE['id'],$submod_list->id);
						if($act == true){ ?>
                        <li><a href="<?php echo $submod_list->url;?>.php"><span><?php echo $submod_list->description;?></span></a></li>
                        <?php }} ?>
						</ul>
					<?php }} ?> 
                         
                    </ul>
                        
          </div><!--leftmenu-->
            	<div id="togglemenuleft"><a></a></div>
            </div><!--mainleftinner-->