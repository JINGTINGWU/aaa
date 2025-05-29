<!--
History:
3/13 Patrick:每頁筆數改為預設30筆,與30/50/100/不分頁
-->
<div class="mm_page_bar_div" style="margin-top:-10px;margin-bottom:-10px;"><table><tr><td width="180"><?php if(isset($pd['pp'])):?>每頁筆數：<a href="<?=$pd['perp_30_url']?>" <?=$pd['pp']==30?'class="mm_page_ob_on"':''?>>30</a>/<a href="<?=$pd['perp_50_url']?>" <?=$pd['pp']==50?'class="mm_page_ob_on"':''?>>50</a>/<a href="<?=$pd['perp_100_url']?>" <?=$pd['pp']==100?'class="mm_page_ob_on"':''?>>100</a>/<a href="<?=$pd['perp_0_url']?>" <?=$pd['pp']==0?'class="mm_page_ob_on"':''?>>不分頁</a><?php endif;?></td><td>&nbsp;<?=$pd['page']?>&nbsp;</td></tr></table></div>

<!--<a href="<?=$pd['ot_asc_url']?>" <?=$pd['ot']=='ASC'?'class="mm_page_ob_on"':''?> title="由小到大">▲</a><a <?=$pd['ot']=='DESC'?'class="mm_page_ob_on"':''?> href="<?=$pd['ot_desc_url']?>" title="由大到小">▼</a>-->
