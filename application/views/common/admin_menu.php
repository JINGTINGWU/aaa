	<div class="menu">
		<ul>
        	<?php foreach($admin_menu as $value):?>
 					<li>
                    	
						<a href="<?=site_url($value['control'].'/')?>"><?=$value['name']?></a>
						<!--<ul>
                        
						<?php foreach($value['sub_list'] as $vv): ?>
								<li>
									<a href="<?=site_url($value['control'].'/'.$vv['function'].'/')?>"><?=$vv['name']?></a>
								</li>
						<?php endforeach; ?>
						</ul>-->
                        
					</li>           
            <?php endforeach; ?>

		</ul>
	</div>
            <!--
			<?php foreach($menus as $menu): ?>
				<?php if ($menu['menutype']=='1'): ?>
					<?php $parentid = $menu['jec_menu_id'] ?>
					<li>
						<a href="<?= base_url().$menu['control'] ?>" 
							<?php if ($menu['control']!='#' and !is_null($menu['control'])): ?>
								target="ecp_main">
							<?php else: ?>
								target="_self">
							<?php endif; ?>
							<?= $menu['name'] ?>
						</a>
						<ul>
						<?php foreach($menus as $submenu): ?>
							<?php if ($submenu['menutype']=='2' and $submenu['parentid']==$parentid): ?>
								<li>
									<a href="<?= base_url().$submenu['control'] ?>" 
										<?php if ($submenu['control']!='#'): ?>
											target="ecp_main">
										<?php else: ?>
											target="_self">
										<?php endif; ?>
										<?= $submenu['name'] ?>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>-->

