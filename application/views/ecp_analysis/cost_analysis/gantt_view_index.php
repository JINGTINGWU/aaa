<style>
.mm_ganttRed {
	background-color: #8F0000;
}

.mm_ganttGreen {
	background-color: #b3cf6f;
}

.mm_ganttOrange {
	background-color: #ff7e24;
}

.mm_ganttGray {
	background-color:#666666;
}
.mm_ganttBlue {
	background-color:#99B3F4;
}
</style>
		<script src="<?=base_url()?>js/jquery-1.5.1.min.js" type="text/javascript"></script>
		<script src="<?=base_url()?>js/jquery.fn.gantt.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?=base_url()?>css/gantt_style.css" type="text/css" media="screen" />
        <script type="text/javascript">
        
	        jQuery(function () {
			
				var dataPath="<?=base_url()?>js/<?=$js_name?>.js";  
				//alert(dataPath);  
	        	$(".gantt").gantt({source: dataPath})
	        });
        
        </script>
        <div><br /><table><tr>
        <?php foreach($task_type as $value):?>
        <?php
			if($value['id']!=1):
				?><td width="80" align="right" style="padding-right:3px;"><?=$value['name']?></td><td class="mm_<?=$color_info[$value['id']]?>" style="width:15px;height:15px;border:#333333 1px solid;"></td><?php
			endif;
		?>
        <?php endforeach;?>
        </tr></table></div>

<div id="search_area_div" class="mm_area_div_1">
    	<div class="gantt">
		</div>
</div>
