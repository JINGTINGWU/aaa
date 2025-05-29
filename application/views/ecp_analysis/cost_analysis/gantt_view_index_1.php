<style>
.mm_ganttRed {
	background-color: #F9C4E1;
}

.mm_ganttGreen {
	background-color: #D8EDA3;
}

.mm_ganttOrange {
	background-color: #FCD29A;
}

.mm_ganttGray {
	background-color:#666666;
}
.mm_ganttBlue {
	background-color:#99B3F4;
}
</style>
		<link rel="stylesheet" href="<?=base_url()?>css/gantt_style.css" />
	<script src="<?=base_url()?>js/jquery-1.5.1.min.js"></script>
	<script src="<?=base_url()?>js/jquery.fn.gantt.js"></script>

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

   <script>
	        jQuery(function () {
	        	//var dataPath = location.href.substring(0, location.href.lastIndexOf('/')+1); 
	        	$(".gantt").gantt({source:<?php echo $gantt_data;?>, navigate: 'scroll', scale: 'days', maxScale: 'weeks', minScale: 'days'/*, hollydays: ["\/Date(1293836400000)\/","\/Date(1294268400000)\/","\/Date(1303596000000)\/","\/Date(1306274400000)\/","\/Date(1304200800000)\/","\/Date(1304373600000)\/","\/Date(1307829600000)\/","\/Date(1308780000000)\/","\/Date(1313359200000)\/","\/Date(1320105600000)\/","\/Date(1320966000000)\/","\/Date(1324767600000)\/","\/Date(1324854000000)\/","\/Date(1325372400000)\/","\/Date(1325804400000)\/","\/Date(1333836000000)\/","\/Date(1336514400000)\/","\/Date(1335823200000)\/","\/Date(1335996000000)\/","\/Date(1338069600000)\/","\/Date(1339020000000)\/","\/Date(1344981600000)\/","\/Date(1351724400000)\/","\/Date(1352588400000)\/","\/Date(1356390000000)\/","\/Date(1356476400000)\/"]*/});

	        	
	        });

    </script>

