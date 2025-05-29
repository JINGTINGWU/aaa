<style>
.mm_cal{
	width:90%;
	border:#CCCCCC 2px solid;
}
.mm_cal th{
	height:30px;
	font-weight:bolder;
	padding-left:5px;
	text-align:left;
}
.mm_cal td{
	height:40px;
	padding-left:3px;
	padding-top:3px;
	border:#CCCCCC 1px solid;
	vertical-align:top;
}
.s-date2{
	color:#FF0000;
}
.cal_today{
	background:#CCCCCC;
}
.nodate{
	color:#CCCCCC;
}
.mm_cal_content a{
	text-decoration:none; 
}
.mm_cal_content td{
	border:none;
	text-align:left;
}
.mm_cal_content th{
	border:none;
	vertical-align:top;
}
.mm_start_projtask{
	color:#0033FF;
}
.mm_end_projtask{
	color:#FF0000;
}
.mm_mid_projtask{
	color:#333333;
}
.mm_done_projtask{
	color:#CCCCCC;
}
.more a:hover{
	color:#FF0000;
}
</style>

<div>
	<table width="90%" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="3" style="height:0px;padding:0px;"></td>
    	</tr>
    	<tr><td>公告日期</td><td>公告內容</td><td>發表人</td></tr>
        <?php foreach($ann_list as $value):?>
        <tr><td><?=substr($value['startdate'],0,10)?></td><td><?=$value['name']?></td><td><?=$value['issue_name']?></td></tr>
        <?php endforeach;?>
        
    </table>
</div>
<br />
<!--
<div>
	<table  width="90%" class="detail-div" cellspacing="1" cellpadding="3">
    	<tr>
    		<td colspan="3" style="height:0px;padding:0px;"></td>
    	</tr>
    	<tr><td>通知日期</td><td>通知內容</td><td>通知類型</td></tr>
        <?php foreach($notice_list as $value):?>
        <tr><td><?=substr($value['noticetime'],0,10)?></td><td><?=$value['emailcontent']?></td><td><?=$noticetype_pdb[$value['noticetype']]?></td></tr>
        <?php endforeach;?> 
    </table>
    <div style="text-align:right"><a href="<?=base_url('ecp_work/inform_item_mng/inform_list_index/list/-1/')?>">More</a></div>
</div>
-->

<div align="center">
<div>
<table width="90%">
<tr><td colspan="3" align="center"><?=date('Y-m-d')?></td></tr>
<tr><td><?=$pre_year?>&nbsp;&nbsp;</td><td align="center"><a href="<?=$pre_month?>"> <?=$pre_month_title?>月</a>&nbsp;&nbsp;<<&nbsp;&nbsp;&nbsp;&nbsp; <?=$this_month_title?>月 &nbsp;&nbsp;&nbsp;&nbsp;>>&nbsp;&nbsp;<a href="<?=$next_month?>"><?=$next_month_title?>月</a></td><td align="right">&nbsp;&nbsp;<?=$next_year?></td></tr></table></div>
<table cellpadding="0" cellspacing="0" class="mm_cal">
                  <tr>
                    
                    <th>週一</th>
                    <th>週二</th>
                    <th>週三</th>
                    <th>週四</th>
                    <th>週五</th>
                    <th>週六</th>
                    <th>週日</th>
                  </tr>
                  <?php $today=date('Y-m-d'); $w_sd_time=strtotime($w_sd['sd']); $w_sdno=date('d',mktime(0,0,0,date('m',$w_sd_time),date('d',$w_sd_time),date('Y',$w_sd_time))); $w_edno=0; $e_day=0; for($i=1;$i<=$week_info['week_num'];$i++):  ?><!--for($i=1;$i<=$week_info['week_num'];$i++):-->
                  <tr>
                  	<?php
						for($j=1;$j<=7;$j++): $e_done=false;//($j=0;$j<7;$j++)
							if($i==1)://start_w//1
								if($week_info['start_w']>$j||($week_info['start_w']==0&&$j!=7)): $e_done=true;
									?><td class="<?=($pre_year_month.$w_sdno)==$today?'cal_today':'nodate'?>">
									
								<table class="mm_cal_content">
                                <tr><th class="more"><?=$w_sdno?><br /><?php if(isset($cal_detail[$pre_year_month.$w_sdno])&&count($cal_detail[$pre_year_month.$w_sdno])>$eday_max_row):?><a  href="<?=base_url('ecp_work/self_calendar_mng/calendar_list_index/list/-1/'.$pre_year_month.$w_sdno.'/DESC/0/Assign_Date/')?>">More</a><?php endif;?></th><td>
                                <?php
								if(isset($cal_detail[$pre_year_month.$w_sdno])):
									?>
									<div>
                                    <?php
										foreach($cal_detail[$pre_year_month.$w_sdno] as $eno=>$edv):
											if($eno<$eday_max_row):
											?><a class="<?=$edv['css']?>" href="<?=base_url('ecp_work/self_calendar_mng/calendar_list_index/list/-1/'.$pre_year_month.$w_sdno.'/DESC/0/Assign_Date/')?>"><?=(int)$edv['jec_projtask_id']>0?$edv['task_name']:$edv['name']?></a><br /><?php
											endif;
										endforeach;
									?>
                                    </div>
									<?php
								endif;
								?>
                                </td></tr>
                                </table>
                                    </td><?php
									$w_sdno++;
								endif;
							endif;
							if($i==$week_info['week_num']):
								if($week_info['end_w']<$j&&$week_info['end_w']!=0): $e_done=true; $w_edno++;//
									?><td class="nodate">
									
								<table class="mm_cal_content">
                                <tr><th class="more"><?=$w_edno?><br /><?php if(isset($cal_detail[$next_year_month.'0'.$w_edno])&&count($cal_detail[$next_year_month.'0'.$w_edno])>$eday_max_row):?><a href="<?=base_url('ecp_work/self_calendar_mng/calendar_list_index/list/-1/'.$next_year_month.'0'.$w_edno.'/DESC/0/Assign_Date/')?>">More</a><?php endif;?></th><td>
                                <?php
								if(isset($cal_detail[$next_year_month.'0'.$w_edno])):
									?>
									<div>
                                    <?php
										foreach($cal_detail[$next_year_month.'0'.$w_edno] as $eno=>$edv):
											if($eno<$eday_max_row):
											?><a  class="<?=$edv['css']?>" href="<?=base_url('ecp_work/self_calendar_mng/calendar_list_index/list/-1/'.$next_year_month.'0'.$w_edno.'/DESC/0/Assign_Date/')?>"><?=(int)$edv['jec_projtask_id']>0?$edv['task_name']:$edv['name']?></a><br /><?php
											endif;
										endforeach;
									?>
                                    </div>
									<?php
								endif;
								?>
                                </td></tr>
                                </table>
                                    </td><?php
								endif;
							endif;
							if($e_done==false):
								$e_day++;
								$e_full_date=date("Y-m-",strtotime($today_sd)).$this->CM->FormatData($e_day,"number",2);
								?><td class="<?=$e_full_date==$today?'cal_today':''?>">
                                <div class="<?=($j==7||$j==6)?'s-date2':'s-date'?>">
								<table class="mm_cal_content">
                                <tr><th class="more" ><?=$e_day?><br /><?php if(isset($cal_detail[$e_full_date])&&count($cal_detail[$e_full_date])>$eday_max_row):?><a href="<?=base_url('ecp_work/self_calendar_mng/calendar_list_index/list/-1/'.$e_full_date.'/DESC/0/Assign_Date/')?>">More</a><?php endif;?></th><td>
                                <?php
								if(isset($cal_detail[$e_full_date])):
									?>
									<div>
                                    <?php
										foreach($cal_detail[$e_full_date] as $eno=>$edv):
											if($eno<$eday_max_row):
											?><a  class="<?=$edv['css']?>" href="<?=base_url('ecp_work/self_calendar_mng/calendar_list_index/list/-1/'.$e_full_date.'/DESC/0/Assign_Date/')?>"><?=(int)$edv['jec_projtask_id']>0?$edv['task_name']:$edv['name']?></a><br /><?php
											endif;
										endforeach;
									?>
                                    </div>
									<?php
								endif;
								?>
                                </td></tr>
                                </table>
								
								</div>

                                </td><?php
							endif;
						endfor; 
					?>
                  </tr>                  
                  <?php endfor;?>
                </table>
</div>  
      