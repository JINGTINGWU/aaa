<?php
if(!isset($up_da)):
	$o_up_da=$this->ECPM->m_right_tag['up_da'];
	if($proj_data['projstatus']==6):
		$o_up_da='disabled';
	endif;
			  if($o_up_da==''):
		  			$up_da = $this->QIM->is_project_modify($proj_data['jec_project_id'])?'':'disabled';
		      else:
			  	    $up_da = $o_up_da;
			  endif;	
endif;
?>
<script src="<?=$cal_url?>js/jscal2.js"></script>
<script src="<?=$cal_url?>js/lang/cn.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="<?=$cal_url?>css/steel/steel.css" />

<script type="text/javascript" src="<?=base_url()?>js/form_input.js"></script>
<style>
.mm_td_pad {
    padding-right: 2px;
}
</style>
<div id="search_area_div" class="mm_area_div_1">
    <form id="edit_form" method="post" action="<?=$form_url?>" target="phf">
        <table class="query-div" cellspacing="1" cellpadding="3">
            <tr>
                <td colspan="5" align="left" style="padding:0px;"></td>
            </tr>
            <tr>
                <td align="right">系統自動編號</td>
                <td id="frominputarea"><?=$main_op['value']['op']?></td>
                <td align="right">專案性質</td>
                <td colspan="2" id="frominputarea">
                    <?=$proj_data['projtype']=='1'?'標案':'專案'//$main_op['projtype']['op']?><input type="hidden"
                        id="projtype" name="projtype" value="<?=$proj_data['projtype']?>" /></td>
            </tr>
            <tr>
                <td align="right">公司別</td>
                <td id="frominputarea"><?=$main_op['jec_company_id']['op']?></td>
                <td align="right">專案年度</td>
                <td colspan="2" id="frominputarea"><?=$main_op['projyear']['op']?></td>
            </tr>
            <tr>
                <td align="right">*專案主持人(業務)</td>
                <td id="frominputarea">
                    <?=$main_op['jec_usersales_id']['op']?><?=$main_op['jec_usersales_id_title']['op']?><?=$main_op['jec_dept_id']['op']?>
                </td>
                <td align="right">*專案負責人</td>
                <td colspan="2" id="frominputarea">
                    <?=$main_op['jec_user_id']['op']?><?=$main_op['jec_user_id_title']['op']?>
                    (專案追蹤、承辦人、助理)</td>
            </tr>
            <tr>
                <td align="right">建檔人員(助理)</td>
                <td id="frominputarea"><?=$main_op['createdby']['op']?><?=$main_op['createdby_title']['op']?></td>
                <td align="right">建檔日期</td>
                <td colspan="2" id="frominputarea"><?=substr($main_data['created'],0,10)?></td>
            </tr>
            <tr>
                <td align="right">*客戶名稱</td>
                <td id="frominputarea">
                    <?=$main_op['jec_customer_id']['op']?><?=$main_op['jec_customer_id_title']['op']?></td>
                <td align="right">客戶案號</td>
                <td id="frominputarea" colspan="2"><?=$main_op['customerdoc']['op']?></td>
            </tr>
            <tr>
                <td align="right">*專案名稱</td>
                <td id="frominputarea"><?=$main_op['name']['op']?>
                    <!--<br/>(請勿使用'\','/',':','"','?','*','<','>','|'等特殊符號)-->
                </td>
                <td align="right">履約地點</td>
                <td id="frominputarea" colspan="2"><?=$main_op['address']['op']?></td>
            </tr>
            <tr>
                <td align="right">*起始日期</td>
                <td id="frominputarea"><?=$main_op['startdate']['op']?></td>
                <td align="right"><span id='enddate_star'>結束日期</span></td>
                <td id="frominputarea" colspan="2"><?=$main_op['enddate']['op']?><span id='enddate_desc'></span></td>
            </tr>

            <tr>
                <td align="right">備註說明</td>
                <td colspan="4" id="frominputarea"><?=$main_op['description']['op']?><input type="button" value="片語輸入"
                        onclick="thick_box('open','片語輸入','<?=site_url('ecp_common/phrase_search_div/description/')?>')" />
                </td>
            </tr>
            <tr>
                <td align="right"><span id='showdate_star'></span>開標日</td>
                <td id="frominputarea"><?=$main_op['showdate']['op']?>(請輸入第1次開標日,如有異動請再次修改)</td>
                <td align="right"><span id='tendertype_star'></span>標案類型</td>
                <td colspan="2" id="frominputarea"><?=$main_op['tendertype']['op']?></td>
            </tr>
            <tr>
                <td align="right">工程(採購)編號</td>
                <td id="frominputarea"><?=$main_op['value2']['op']?></td>
                <td align="right"><span id='description2_star'></span>管制編號</td>
                <td colspan="2" id="frominputarea"><?=$main_op['description2']['op']?>(若為專案-無管制編號,則填NA即可)</td>
                </td>
            </tr>
            <tr>
                <td align="right">工程(標的)名稱</td>
                <td id="frominputarea"><?=$main_op['name2']['op']?></td>
                <td align="right">預算金額(含稅)</td>
                <td colspan="2" id="frominputarea"><?=$main_op['description3']['op']?></td>
            </tr>

            <tr>
                <td align="right">得標日</td>
                <td id="frominputarea"><?=$main_op['getdate']['op']?></td>
                <td align="right"><span id='limitdate_star'></span>合約期限</td>
                <td colspan="2" id="frominputarea"><?=$main_op['limitdate']['op']?><span id='limitdate_desc'></span>
                </td>
            </tr>
            <tr>
                <td align="right">專案採購案號</td>
                <td colspan="4" id="frominputarea"><?=$main_op['efprojdept']['op']?><?=$main_op['efprojno']['op']?>
                    <!--<input type="button" value="..." onclick="PG_BK_Action('search_ef_proj',{})" <?=$up_da?> />-->
                    <?=$main_op['efprojname']['op']?> 預估支出金額：<?=$main_data['projcost']?></td>
            </tr>
            <tr>
                <td align="right">合約總價(含稅)</td>
                <td id="frominputarea"><?=$main_op['total']['op']?></td>
                <td align="right">成本係數</td>
                <td colspan="2" id="frominputarea"><?=$main_op['costrate']['op']?></td>
            </tr>
            <tr>
                <td align="right">發票金額(含稅)</td>
                <td id="frominputarea"><?=$main_op['totalvoucher']['op']?>(自動由ERP結帳單加總)</td>
                <td align="right">驗收金額(含稅)</td>
                <td colspan="2" id="frominputarea"><?=$main_op['totalaccept']['op']?></td>
            </tr>
            <tr>
                <td align="right">專案狀態</td>
                <td id="frominputarea"><?=$main_op['projstatus']['op']?><input type="button" value="確定要調整專案狀態"
                        onclick="pg_submit('edit_projstatus')" class="mm_submit_button"
                        <?=$this->ECPM->m_right_tag['up_da']?> <?=$up_da?> /></td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td align="right"></td>
                <td id="frominputarea"></td>
                <td colspan="4"><input type="button" value="確定要修改專案資料" onclick="pg_submit('def')"
                        class="mm_submit_button" <?=$up_da?> />
                    <a href='#' onclick="PG_BK_Action('updatexls')">重新產生履約備品清單xls檔</a></td>
            </tr>
            <tr>
                <td align="right">選擇範本</td>
                <td id="frominputarea"><?=$main_op['project_model']['op']?>
                    <!--<select   id="project_model" name="project_model"    ><option value="" selected>--請選擇--</option><option value="2" >台水-區處(工程標案)</option><option value="3" >台水-總處(小表統購)</option><option value="4" >北水-統購</option><option value="6" >市售標案</option><option value="7" >市售工程專案</option><option value="8" >政策性推廣專案</option><option value="9" >產品異常維謢案件</option><option value="10" >設計開發案</option><option value="11" >設計變更案</option><option value="13" >產品交接後之各單位執行事項</option><option value="14" >電路會議</option><option value="15" >電子小表量產規劃</option><option value="16" >台水-區處(物料標案)</option><option value="17" >台水-總處(大表統購)</option><option value="19" >DMA規劃設計專案</option><option value="20" >勞務專案</option><option value="21" >品保部SOP文件制/修訂</option></select>-->
                </td>
                <td colspan="3"><input id="btn_importtemp" class="mm_submit_button" type="button"
                        value="<?=$proj_data['isimporttemp']=='Y'?"已匯入範本資料":"將範本資料加入專案中"?>"
                        onclick="pg_submit('project_model')" <?=$proj_data['isimporttemp']=='Y'?'disabled':''?>></td>
            </tr>
        </table>
    </form>
</div>
<script>
var cal = Calendar.setup({
    onSelect: function(cal) {
        cal.hide()
    },
    showTime: true
});
cal.manageFields("startdate", "startdate", "%Y-%m-%d");
cal.manageFields("enddate", "enddate", "%Y-%m-%d");
cal.manageFields("showdate", "showdate", "%Y-%m-%d");
cal.manageFields("getdate", "getdate", "%Y-%m-%d");
cal.manageFields("limitdate", "limitdate", "%Y-%m-%d");

function pg_submit(type) {
    var info = Array();
    var othermsg = '';
    if (type == 'def' || type == 'project_model') {
        //			info[0]={id:'name',msg:'專案名稱不可空白',type:'ne'};
        //			info[1]={id:'startdate',msg:'起始日期不可空白',type:'ne'};
        //			info[2]={id:'startdate',msg:'結束日期不可空白',type:'ne'};
        //			info[3]={id:'jec_usersales_id_title',msg:'請選擇業務',type:'ne'};
        //			if($("#efprojdept").val()!=''){
        //				info[4]={id:'efprojno',msg:'請選擇專案採購編號',type:'ne'};
        //			}else{
        //				info[4]={id:'name',msg:'專案名稱不可空白',type:'ne'};
        //			}
        var errno = 0;
        info[errno++] = {
            id: 'name',
            msg: '專案名稱不可空白',
            type: 'ne'
        };
        info[errno++] = {
            id: 'startdate',
            msg: '起始日期不可空白',
            type: 'ne'
        };

        info[errno++] = {
            id: 'jec_customer_id_title',
            msg: '請選擇客戶',
            type: 'ne'
        };
        info[errno++] = {
            id: 'jec_user_id_title',
            msg: '請選擇專案負責人',
            type: 'ne'
        };
        info[errno++] = {
            id: 'jec_usersales_id_title',
            msg: '請選擇業務',
            type: 'ne'
        };
        if ($("#efprojdept").val() != '') {
            info[errno++] = {
                id: 'efprojno',
                msg: '請選擇專案採購編號',
                type: 'ne'
            };
        } else {
            info[errno++] = {
                id: 'name',
                msg: '專案名稱不可空白',
                type: 'ne'
            };
        }
        info[errno++] = {
            id: 'projtype',
            msg: '請選擇專案性質',
            type: 'nz'
        };
        info[errno++] = {
            id: 'jec_company_id',
            msg: '請選擇公司別',
            type: 'nz'
        };
        info[errno++] = {
            id: 'projyear',
            msg: '請選擇專案年度',
            type: 'nz'
        };
        if ($("#projtype").val() == 1) //標案
        {
            info[errno++] = {
                id: 'description2',
                msg: '管制編號不可空白',
                type: 'ne'
            };
            info[errno++] = {
                id: 'showdate',
                msg: '請輸入開標日，以利得標前準備工作展開',
                type: 'ne'
            };
            info[errno++] = {
                id: 'tendertype',
                msg: '請選擇標案類型',
                type: 'nz'
            };
            info[errno++] = {
                id: 'limitdate',
                msg: '請選擇合約期限',
                type: 'ne'
            };
        } else //專案
        {
            info[errno++] = {
                id: 'enddate',
                msg: '結束日期不可空白',
                type: 'ne'
            };
            info[errno++] = {
                sd_id: 'startdate',
                ed_id: 'enddate',
                msg: '結束日期不能小於起始日',
                type: 'sed'
            };
        }
        switch (type) {
            case 'def': //
                document.getElementById('project_model').value = '';
                break;
            case 'project_model':
                var projstatus = <?=$proj_data['projstatus']?>;
                info[errno++] = {
                    id: 'project_model',
                    msg: '請選擇專案範本',
                    type: 'ne'
                };
                if ($("#projtype").val() == 1) {
                    if (projstatus != 2) {
                        parent.ECP_Msg('專案狀態為 [得標後/專案開展] 時，才可使用範本匯入', -1, 'error');
                        return;
                    } else {
                        info[errno++] = {
                            id: 'getdate',
                            msg: '請輸入得標日，以利得標後工作展開',
                            type: 'ndz'
                        };
                    }
                }
                break;
        }
        document.getElementById('edit_form').action = "<?=$form_url?>";
        msg = fi_submit_check(info);
        if (msg == '') {
            document.getElementById('btn_importtemp').disabled = true;
            //data={ sales_name:$("#jec_usersales_id_title").val() };
            data = {
                cus_name: $("#jec_customer_id_title").val(),
                sales_name: $("#jec_usersales_id_title").val(),
                user_name: $("#jec_user_id_title").val()
            };
            AWEA_Ajax('<?=$check_proj_url?>', data, '');
        }
    }
    if (type == 'edit_projstatus') {
        document.getElementById('edit_form').action = "<?=$edit_projstatus_url?>";
        var val = document.getElementById('projstatus').options[document.getElementById('projstatus').selectedIndex]
            .value;
        var err = 0;
        if (val == 6) {
            //20201204行銷部告知允許結案
            //ECP_Msg('標案結案請至EF填寫「標案結案申請單」', -1, 'error');
            //othermsg = '標案結案請至EF填寫「標案結案申請單」';
            if( $("#efprojno").val() != '')
            {
                data = {
                wf_proj_id: $("#efprojno").val()
                };
                AWEA_Ajax('<?=$check_close_proj_url?>', data, '');
            }            
            //info[err++]={id:'totalvoucher',msg:'請輸入發票金額',type:'nz'};
        }
        
        <?php if($proj_data['projtype']=='1'):?>
         if (val == 2) {
            info[err++] = {
                id: 'customerdoc',
                msg: '請輸入客戶案號',
                type: 'nz'
            };
            info[err++] = {
                id: 'value2',
                msg: '請輸入工程(採購)編號',
                type: 'ne'
            };
            info[err++] = {
                id: 'name2',
                msg: '請輸入工程(標的)名稱',
                type: 'ne'
            };
            info[err++] = {
                id: 'showdate',
                msg: '請輸入開標日',
                type: 'ndz'
            };
            info[err++] = {
                id: 'getdate',
                msg: '請輸入得標日',
                type: 'ndz'
            };
            info[err++] = {
                id: 'limitdate',
                msg: '請輸入合約期限',
                type: 'ndz'
            };
            info[err++] = {
                id: 'description3',
                msg: '請輸入預算金額',
                type: 'nz'
            };
            info[err++] = {
                id: 'total',
                msg: '請輸入合約總價',
                type: 'nz'
            };
            info[err++] = {
                id: 'tendertype',
                msg: '請輸入標案類型',
                type: 'nz'
            };
        }
        <?php endif;?>
        msg = fi_submit_check(info);
        if (msg == '' && othermsg == '' ) {
            document.getElementById('edit_form').submit();
        }
    }
}

function PG_BK_Action(type, data) {
    var info = Array();
    switch (type) {
        case 'edit_proj_go':
            if (GetTagV(data, 'isexist') == 'Y') {
                $("#jec_customer_id").val(GetTagV(data, 'cus_id'));
                $("#jec_customer_id_title").val(GetTagV(data, 'cus_name'));
                $("#jec_user_id").val(GetTagV(data, 'user_id'));
                $("#jec_user_id_title").val(GetTagV(data, 'user_name'));
                $("#jec_usersales_id").val(GetTagV(data, 'sales_id'));
                $("#jec_usersales_id_title").val(GetTagV(data, 'sales_name'));
                $("#jec_dept_id").val(GetTagV(data, 'sales_dept'));
                document.getElementById('edit_form').submit();
            }
            break;
        case 'get_dept_id_by_saler':
            data = {
                user_id: $("#jec_usersales_id").val()
            };
            AWEA_Ajax('<?=$get_dept_url?>', data, '');
            break;
        case 'get_purchase_list_by_dept':
            data = {
                dept_id: $("#efprojdept").val()
            };
            $("#purchase_name_tag").html('');
            AWEA_Ajax('<?=$get_purchase_url?>', data, '');
            break;
        case 'get_purchase_name':
            var name = GetString(data, '>>', '');
            $("#purchase_name_tag").html(name);
            break;
        case 'change_dept_id':
            var dept_id = GetTagV(data, 'dept_id');
            $("#jec_dept_id").val(dept_id);
            break;
        case 'check_projno': //抓資料進來
            var deptno = $("#efprojdept").val();
            var projno = $("#efprojno").val();
            if (projno != '') {
                data = {
                    projdept: deptno,
                    projno: projno
                };
                AWEA_Ajax('<?=$check_projno_url?>', data, '');
            }
            break;
        case 'projno_check_result':
            var isexist = GetTagV(data, 'isexist');
            if (isexist == 'Y') {
                $("#efprojdept").val(GetTagV(data, 'projdept'));
                $("#efprojno").val(GetTagV(data, 'projno'));
                $("#efprojname").val(GetTagV(data, 'projname'));
            } else {
                alert("查無此專案");
                $("#efprojdept").val('');
                $("#efprojno").val('');
                $("#efprojname").val('');
            }
            break;
        case 'change_projdept':
            $("#efprojno").val('');
            $("#efprojname").val('');
            break;
        case 'search_ef_proj':
            var url = "<?=$search_ef_proj_url?>";
            var deptno = $("#efprojdept").val();
            if (deptno == '') deptno = '-';
            url = url + '/' + deptno + '/';
            window.open(url, '', 'width=650,height=600');
            break;
        case 'updatexls':
            data = {
                jec_project_id: <?=$key_id?>
            };
            AWEA_Ajax('<?=$get_updatexls_url?>', data, '');
            parent.ECP_Msg('已重新產生Excel檔', 999);
            break;
        case 'bk_close_proj':
            var non_sold=parseInt(GetTagV(data, 'non_sold'));
            if(non_sold>100)
            {
                parent.ECP_Msg('尚有未銷貨金額'+non_sold+', 不允許結案',-1,'error');
            }
            else
            {
                //parent.ECP_Msg('尚有未銷貨金額'+non_sold+', 可結案');
                document.getElementById('edit_form').submit();
            }
            break;
    }
}
$(document).ready(function() {
    if ($("#projtype").val() == 1) //標案
    {
        $("#project_model").attr('disabled', false);
        $('#project_model option')[0].selected = true;
        $('#enddate_star').text('竣工日期');
        $('#limitdate_star').text('*');
        $('#description2_star').text('*');
        $('#showdate_star').text('*');
        $('#enddate_desc').text('(竣工時再填入實際竣工日期)');
        $('#limitdate_desc').text('(預計完成日)');
        $('#tendertype_star').text('*');
    } else {
        $("#project_model").attr('disabled', true);
        $('#enddate_star').text('*結束日期');
        $('#limitdate_star').text('');
        $('#description2_star').text('');
        $('#showdate_star').text('');
        $('#enddate_desc').text('');
        $('#limitdate_desc').text('');
        $('#tendertype_star').text('');
    }
});
</script>
<div id="pl_search_div" style="display:none;background:#FFFFFF;position:absolute;top:0px;left:0px;">
    <iframe id="pl_search_list" name="pl_search_list" frameborder="0"
        style="border:1px solid #CCCCCC;width:600px;height:300px;"></iframe>
</div>
<input type="hidden" id="on_select" value="-1" />
<input type="hidden" id="select_status" value="N" />
<script>
var InputList = {
    on: 'cus',
    info: {
        cus: {
            search_list: 'pl_search_list',
            search_value: 'search_value',
            search_here: 'jec_customer_id_title',
            search_div: 'pl_search_div',
            url: '<?=base_url('ecp_common/search_select/customer/')?>',
            'input_id': 'jec_customer_id',
            'input_type': 'R',
            'width': 300,
            'title_id': 'jec_customer_id_title'
        },
        user: {
            search_list: 'pl_search_list',
            search_value: 'search_value',
            search_here: 'jec_user_id_title',
            search_div: 'pl_search_div',
            url: '<?=base_url('ecp_common/search_select/user/')?>',
            'input_id': 'jec_user_id',
            'input_type': 'R',
            'width': 160,
            'title_id': 'jec_user_id_title'
        },
        usersales: {
            search_list: 'pl_search_list',
            search_value: 'search_value',
            search_here: 'jec_usersales_id_title',
            search_div: 'pl_search_div',
            url: '<?=base_url('ecp_common/search_select/user/')?>',
            'input_id': 'jec_usersales_id',
            'input_type': 'R',
            'width': 120,
            'title_id': 'jec_usersales_id_title',
            'onchange': "get_dept_id_by_saler"
        },
        createdby: {
            search_list: 'pl_search_list',
            search_value: 'search_value',
            search_here: 'createdby_title',
            search_div: 'pl_search_div',
            url: '<?=base_url('ecp_common/search_select/user/')?>',
            'input_id': 'createdby',
            'input_type': 'R',
            'width': 160,
            'title_id': 'createdby_title'
        }
    },
    on_select: 'on_select',
    select_status: 'select_status',
    css_off_select: 'off_select',
    css_on_select: 'on_select',
    pg_list_on: 'N',
    blank_url: '<?=base_url('ecp_test/blank')?>',
    onfocus: ''
    //,input_type:'A' //A/R		
};
</script>
<script src="<?=base_url()?>js/PL_P.js"></script>