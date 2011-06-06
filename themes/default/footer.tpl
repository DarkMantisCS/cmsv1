	</section>

	<footer>
		{L_PAGE_GEN}<br />{L_SITE_COPYRIGHT}<br />{L_TPL_INFO}
	</footer>
	<!-- BEGIN debug -->
	<div id="pageContent" class="grid_12 content">
		<!-- BEGIN graphs -->
		
		<div style="display:table; float:left; margin: 20px;">
			Query Exec Time<br />
			{debug.graphs.queryTimer}
		</div>
		
		<div style="display:table; float:left; margin: 20px;">
			Page Generation Time<br />
			{debug.graphs.pageGen}
		</div>
		
		<div style="display:table; float:left; margin: 20px;">
			Memory Usage<br />
			{debug.graphs.ramUsage}
		</div>
		
		<br />
		<!-- END graphs -->
		
		<table width="100%" border="0" cellspacing="1" cellpadding="4">
		  <tr class="thead padding">
			<td width="8%">Q Time</td>
			<td>Query</td>
		  </tr>
			{debug.CONTENT}
		</table>

		<table width="100%" border="0" cellspacing="1" cellpadding="4">
			<tr><td>{debug.LOG}</td></tr>
			<tr><td>{debug.DEBUG}</td></tr>
		</table>
	</div>    
<!-- END debug -->
</div>
<div id="bg-strip">&nbsp;</div>

{_JS_FOOTER}
</body>
</html>