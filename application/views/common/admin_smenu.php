	<!--mmm_smenu mmmm_smenu_on mmmm_smenu_off--><div class="tabpage" id="admin_smenu">
		<ul>
        	<?php foreach($admin_smenu['list'] as $st=>$sv):?>
            	<?php if(!isset($sv['ismenu'])||$sv['ismenu']=='Y'):?>
 					<li>
						<a href="<?=$sv['url']?>" class="<?php if($st==$s_cate) echo 'selected'; ?>" <?=isset($sv['need_id'])?'id="'.$sv['need_id'].'"':''?> ><?=$sv['title']?></a>
					</li>   
                <?php endif;?>             
            <?php endforeach; ?>

		</ul>
	</div>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr><td class="tab-underline"></td></tr>
		</table>


