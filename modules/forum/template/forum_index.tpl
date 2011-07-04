<div id="sortable_forums" style="width: 100%">
<!-- BEGIN forum -->
<div id="cat_{forum.ID}" class="content catClear corners">
    <div class="title iblock corners-top">
      <!-- BEGIN expand -->
    	<div class="float-left catIcon">
            <img src="{forum.EXPAND}" id="img_{forum.ID}" onclick="javascript:toggleMenu({forum.ID});" type="function" mode="{forum.MODE}" name="{forum.ID}" />
        </div>
      <!-- END expand -->
    	<div class="float-left catName">
        	<h4>{forum.CAT}</h4>
        </div>
    </div>
	<div id="f_{forum.ID}" style="{forum.DISPLAY}">
    <table width="100%" border="0" cellspacing="1" cellpadding="5">
    <!-- BEGIN row -->
      <tr class="{forum.row.ROW}">
        <td width="4%" rowspan="2" valign="middle" align="center"><img src="{forum.row.CAT_ICO}" /></td>
        <td colspan="2">
            <span class="float-left bold"><a href="{forum.row.URL}">{forum.row.CAT}</a></span>
            <!-- BEGIN subs -->
            <span class="float-right">
                <!-- BEGIN cats -->
                <img src="{forum.row.subs.cats.IMG}" /> <a href="{forum.row.subs.cats.URL}">{forum.row.subs.cats.NAME}</a> 
                <!-- END cats -->
            </span>
            <!-- END subs -->
        </td>
      </tr>
      <tr class="{forum.row.ROW}">
        <td>
            {forum.row.DESC}<br />
            <span class="float-left"><strong>{forum.row.L_TCOUNT}:</strong> {forum.row.T_COUNT} | <strong>{forum.row.T_PCOUNT}:</strong> {forum.row.P_COUNT}</span>
            <span class="float-right">{forum.row.L_MODS} {forum.row.C_MODS}</span>
        </td>
        <td width="40%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center"><a href="{forum.row.LP_URL}">{forum.row.LP_TITLE}</a> {forum.row.LP_AUTHOR}<br />{forum.row.LP_TIME}</td>
                <td>{forum.row.LP_REPLY}</td>
            </tr>
            </table>
        </td>
      </tr>
    <!-- END row -->
    </table>
	</div>
	<div class="clear"></div>
</div>
<!-- END forum -->
</div>

<!-- BEGIN stats -->
<br />
<div class="content corners">
    <div class="title padding corners-top"><h4 style="margin: 0;">{stats.L_STATS}</h4></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="padding">
      <tr>
        <td>
        {stats.TOTAL_USERS}
        <hr size="1" style="color: rgb(10, 10, 10);" />
        {stats.USER24}<br />
        {stats.LEGEND}
        <hr size="1" style="color: rgb(10, 10, 10);" />
        <strong>{stats.L_THREADS}</strong>: {stats.C_THREADS} | 
		<strong>{stats.L_POSTS}</strong>: {stats.C_POSTS} | 
		<strong>{stats.L_USERS}</strong>: {stats.C_USERS} | 
		<strong>{stats.L_NEWUSER}</strong>: {stats.C_NEWUSER}
        </td>
      </tr>
    </table>
	<div class="clear"></div>
</div>
<!-- END stats -->
<br />
<table border="0" cellspacing="1" cellpadding="1" align="right" class="content" style="width: 45%;">
  <tr>
    <td class="row_color1" align="center"><img src="{I_NO_POSTS}" /></td>
    <td class="row_color1">{L_NO_POSTS}</td>
    <td class="row_color2" align="center"><img src="{I_NEW_POSTS}" /></td>
    <td class="row_color2">{L_NEW_POSTS}</td>
    <td class="row_color1" align="center"><img src="{I_LOCKED}" /></td>
    <td class="row_color1">{L_LOCKED}</td>
  </tr>
</table>
<div class="clear"></div>
