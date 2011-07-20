<div class="content corners">
    <div class="title corners-top iblock">
		<h4 class="float-left">{JB_TITLE}</h4>
	</div>
	<div>
        <div class="padding iblock" style="width:98%">
            <div style="float:left;">{JB_FORM_START}{JUMPBOX}{JB_EDIT} {JB_DELETE}{JB_FORM_END}</div>
            <div style="float:right;">{ADD_FORM_START}{HID_INPUT}{ADD_SUBMIT}{ADD_FORM_END}</div>
        </div>
        <!-- BEGIN group -->
        <fieldset><legend class="padding">{group.NAME} {group.BTNS}</legend>
        {name.DUMP}
            <table width="100%" border="0" cellspacing="2" cellpadding="1">
            <!-- BEGIN cat -->
              <tr class="{group.cat.ROW}">
                <td class="padding" width="15%" valign="top"><strong>{group.cat.NAME}</strong></td>
                <td width="5%" rowspan="3" align="center">{group.cat.BTNS}</td>
              </tr>
              <tr class="{group.cat.ROW}">
                <td valign="top" class="content padding">{group.cat.DESC}</td>
              </tr>
              <tr class="{group.cat.ROW}">
                <td valign="top" class="padding">{group.cat.L_MOVE_TO} {group.cat.MOVE_TO}</td>
              </tr>
            <!-- END cat -->
            </table>
        </fieldset><br />
        <!-- END group -->
    </div>
</div>