<?php 
if(isset($mm_js)):
	foreach($mm_js as $value):
		?><script src="<?=base_url()?>js/<?=$value?>.js"></script><?php
	endforeach;
endif;
?>
<?php if($P_this_view==$this_view):?>

<div id="ccate_menu_div"  class="tabpage"><!-- mmmm_tag_on  mmmm_tag_off-->
	<ul>
	<?php foreach($ccate_menu as $st=>$sv):?>
    	<?php
			if($this->CM->InStr($st,"button_")):
				$ccm_click="ECP_Load_BK('".$sv['index']."','tcate_".$ccate_ptag."_div')";
			else:
				$ccm_click="mmm_ccate_change('".$st."','".$ccate_ptag."')";
			endif;/*mmm_ccate_change('<?=$st?>','<?=$ccate_ptag?>')*/
			if(isset($sv['onclick'])) $ccm_click=$sv['onclick'];
			if(isset($sv['noLink'])&&$sv['noLink']=='Y') $ccm_click='';
		?>
	<li ><a class="<?php if((!isset($first_tag)&&$tag==$st)){ echo 'selected';}else{ echo '';} ?>" onclick="<?=$ccm_click?>" id="ccate_<?=$st?>_tag" href="javascript:;"><?=$sv['title']?></a></li>
	<?php endforeach;?>
	</ul>
</div>    
<?php endif; ?>