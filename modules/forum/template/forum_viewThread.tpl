<div class="content corners">
    <div class="title corners-top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
			<td align="left" valign="middle">
			<div class="float-left" style="margin: 5px 5px 0 5px;">
				<!-- BEGIN move -->
					<a href="{move.URL}"><img src="{move.IMG}" alt="{move.TEXT}" title="{move.TEXT}" /></a>
				<!-- END move -->
				
				<!-- BEGIN del -->
					&nbsp;<a href="{del.URL}"><img src="{del.IMG}" alt="{del.TEXT}" title="{del.TEXT}" /></a>
				<!-- END del -->
				
				<!-- BEGIN locked -->
					&nbsp;<a href="{locked.URL}"><img src="{locked.IMG}" alt="{locked.TEXT}" title="{locked.TEXT}" /></a> 
				<!-- END locked -->			
			</div>
			<div class="float-left">
				<h4>{THREAD_TITLE}</h4></td>
			</div>
			<td align="right" class="padding">				
				{JUMPBOX}
			</td>
		</tr></table>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="padding"><tr>
		<td align="left">{PAGINATION}</td>
		<td align="right">
		<!-- BEGIN reply -->
			<a href="{reply.URL}" class="button blue float-right"><span class="freply">{reply.TEXT}</span></a>
		<!-- END reply -->
		<!-- BEGIN qreply -->
			&nbsp;<a href="#qreply" class="button blue float-right"><span class="freply">{qreply.TEXT}</span></a>
		<!-- END qreply -->
		</td>
	</tr></table>
</div><br />
<div class="clear"></div>

<!-- BEGIN thread -->
{ANCHOR}
<table width="100%" border="0" cellspacing="1" cellpadding="2" class="content">
  <tr>
    <td valign="top" width="20%" class="{thread.ROW}" align="center">
	<div class="padding">
		{thread.AUTHOR_IO} {thread.AUTHOR}<br /> 
		{thread.USERTITLE}
	</div>
    {thread.AVATAR}
	<div class="padding">
		{thread.POSTCOUNT}<br />
		{thread.LOCATION}
	</div>
    </td>
    <td valign="top" class="{thread.ROW}">
    <div class="padding block">
        <div class="float-left">
            {thread.TIME}
        </div>
        <div class="float-right">
            <!-- BEGIN edit -->
                <a href="{thread.edit.URL}"{thread.edit.EIP}><img src="{thread.edit.IMG}" alt="{thread.edit.TEXT}" title="{thread.edit.TEXT}" /></a>
            <!-- END edit -->
            <!-- BEGIN del -->
                <a href="{thread.del.URL}"><img src="{thread.del.IMG}" alt="{thread.del.TEXT}" title="{thread.del.TEXT}" /></a> 
            <!-- END del -->
            <!-- BEGIN quote -->
                <a href="{thread.quote.QURL}"><img src="{thread.quote.IMG}" alt="{thread.quote.TEXT}" title="{thread.quote.TEXT}" /></a>
            <!-- END quote -->
        </div>
		<div class="clear"></div>
        <hr />
        <div class="padding" id="post_id_{thread.ID}">{thread.POST}</div>
    </div>
    <!-- BEGIN sig -->
	<div class="clear"></div>
    <div align="center"><img src="/{ROOT}images/h-divide.png" /></div><br />{thread.SIGNATURE}
    <!-- END sig -->
    </td>
  </tr>
  <tr>
    <td colspan="2" valign="top" class="{thread.ROW}">
    <div class="float-left">{thread.EDITED}</div>
    <div class="float-right">{thread.IP}</div>
    </td>
  </tr>
</table>
<!-- END thread -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="content padding"><tr>
	<td align="left">{PAGINATION}</td>
	<td align="right">
	<!-- BEGIN reply -->
		<a href="{reply.URL}" class="button blue float-right"><span class="freply">{reply.TEXT}</span></a>
	<!-- END reply -->
	</td>
</tr></table>

<!-- BEGIN qreply -->
<a name="qreply">&nbsp;</a>
<div class="content corners">
    <div class="title corners-top"><h4>{L_QUICK_REPLY}</h4></div>
	{F_START}
		{HIDDEN}
		<div id="preview" style="display:none;" class="preview"></div> 
		{F_QUICK_REPLY}
		<div class="clear"></div>
		<div class="float-right padding">{SUBMIT}</div>
		<div class="clear"></div>
	{F_END}
</div><br />
<!-- END qreply -->