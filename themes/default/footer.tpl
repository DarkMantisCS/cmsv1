		</div>
	</section>

	<footer>
		{L_PAGE_GEN}<br />{L_SITE_COPYRIGHT}<br />{L_TPL_INFO}
	</footer>
	<!-- BEGIN debug -->
	<div id="pageContent" class="grid_12" style="width:100%">
		<table width="100%" border="0" cellspacing="1" cellpadding="4" class="content">
		  <tr class="thead padding">
			<td width="8%">Q Time</td>
			<td>Query</td>
		  </tr>
			{debug.CONTENT}
		</table>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
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