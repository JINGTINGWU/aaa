<?php 
if(isset($mm_js)):
	foreach($mm_js as $value):
		?><script src="<?=base_url()?>js/<?=$value?>.js"></script><?php
	endforeach;
endif;
?>

<?php if($P_this_view==$this_view):?>
<div id="scate_menu_div">
	<ul>
	<?php foreach($scate_menu as $st=>$sv):?>
    	
	<li class="<?=$tag==$st?'mmmm_tag_on':'mmmm_tag_off'?>" onclick="mmm_scate_change('<?=$st?>')" id="scate_<?=$st?>_tag"><?=$sv['title']?></li>
		
	<?php endforeach;?>
	</ul>
</div>    
<?php endif; ?>