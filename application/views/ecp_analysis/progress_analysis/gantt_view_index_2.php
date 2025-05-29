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
		<style type="text/css">
			body {
				font-family: Helvetica, Arial, sans-serif;
				font-size: 13px;
				padding: 0 0 50px 0;
			}
			.contain {
				width: 800px;
				margin: 0 auto;
			}
			h1 {
				margin: 40px 0 20px 0;
			}
			h2 {
				font-size: 1.5em;
				padding-bottom: 3px;
				border-bottom: 1px solid #DDD;
				margin-top: 50px;
				margin-bottom: 25px;
			}
			table th:first-child {
				width: 150px;
			}
		</style>
		<link rel="stylesheet" href="<?=base_url()?>css/gantt_style.css" />
        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" />
        <link rel="stylesheet" href="http://taitems.github.com/UX-Lab/core/css/prettify.css" />
	<script src="<?=base_url()?>js/jquery-1.5.1.min.js"></script>
	<script src="<?=base_url()?>js/jquery.fn.gantt.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>
	<script src="http://taitems.github.com/UX-Lab/core/js/prettify.js"></script>

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

		$(function() {

			"use strict";

			$(".gantt").gantt({
				source:<?php echo $gantt_data;?>,
				navigate: "scroll",
				scale: "weeks",
				maxScale: "months",
				minScale: "days",
				itemsPerPage: 10,
				onItemClick: function(data) {
					
					//alert("Item clicked - show some details");
				},
				onAddClick: function(dt, rowId) {
					//alert("Empty space clicked - add an item!");
				}
			});
			
			$(".gantt").popover({
				selector: ".bar",
				title: "I'm a popover",
				content: "And I'm the content of said popover."
			});

			prettyPrint();

		});

    </script>

