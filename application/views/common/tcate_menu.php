<?php 
/*
if(isset($mm_js)):
	foreach($mm_js as $value):
		?><script src="<?=base_url()?>js/<?=$value?>.js"></script><?php
	endforeach;
endif;*/
?>
<?php if($P_this_view==$this_view||(isset($show_tcate)&&$show_tcate='Y')):?>
<div id="tcate_menu_div" class="tabpage">
	<div  class="clearfix">
    	<div  class="tab-div-left">
	<ul id="functiontabs">
	<?php $tno=0; foreach($tcate_menu as $st=>$sv):$tno++; ?><!--mmmm_tag_on mmmm_tag_off -->
    	<?php if($tno>1):?>
    	<?php
			if($this->CM->InStr($st,"button_")):
				$tcm_click="ECP_Load_BK('".$sv['index']."')";
			else:
				$sv_index=$tno==1?$sv['index'].'_noplate':$sv['index'];
				if($tno==1):
					$tcm_click="mmm_tcate_change('".$st."')";
				else:
					$tcm_click="mmm_tcate_change('".$st."','".site_url($var_purl.$st."/".$sv_index."/".$key_id."/")."')";
				endif;
				//url
			endif;
			$tcm_click="";
		?>
	<li><a <?=$tag==$st?'class="selected"':''?> onclick="<?=$tcm_click?>" id="tcate_<?=$st?>_tag" href="<?=isset($tcate_url[$st])?$tcate_url[$st]:'#'?>" <?php if($tag!=$st&&!isset($tcate_url[$st])) echo 'class="unselected"'; ?>><?=$sv['title']?></a></li> 
    	<?php endif;?>
	<?php endforeach;?>
	</ul>
    	</div>
       <div class="tab-div-right"><?=$tcate_menu['title']?></div>
    </div>
</div>    
<?php endif; ?>
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr><td class="tab-underline"></td></tr>
		</table>