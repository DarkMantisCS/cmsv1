<div class="title corners">
    <div class="padding" style="font-size:12px;"><h3>{TITLE}</h3></div>
</div>
{F_START}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="content padding">
	<tr>
		<td colspan="2">{MSG}</td>
	</tr>
	<tr>
		<td><strong>Enable Whitelist:</strong></td>
		<td>{F_ENABLED}</td>
	</tr>
	{F_HIDDEN}
	<tr>
		<td valign="top">
			<strong>IP Ranges:</strong><br />
			<small>Please Denote IP Ranges in the following manner: 255.255.255.*<br />An IP Range can contain 4 Subnet Masks, and therefore 4 groups of numbers / astrix's<br /><strong>Note:</strong> For security purposes, you cannot add *.*.*.* as a valid Range as this is the same as disabling this setting.</small>
		</td>
		<td valign="top">
        <!-- BEGIN ips -->
        {ips.F_IP}<br />
        <!-- END ips -->
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">{F_SUBMIT}{F_RESET}</td>
	</tr>
</table>
{F_END}