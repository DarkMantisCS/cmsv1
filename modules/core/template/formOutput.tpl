<section>
{FORM_START}
	<fieldset>	
		<legend class="title">{FORM_TITLE}</legend>
		<!-- BEGIN form_error -->
		<div class="boxred">{form_error.ERROR_MSG}</div>
		<div class="clear">&nbsp;</div>
		<!-- END form_error -->
		
		<!-- BEGIN field -->
		<div>
			<!-- BEGIN label -->
			<label for="{field.L_LABELFOR}">
			<!-- END label -->
				{field.L_LABEL}		
				<!-- BEGIN desc -->
				<br /><small>{field.F_INFO}</small>
				<!-- END desc -->
			<!-- BEGIN label -->
			</label>
			<!-- END label -->
			{field.F_ELEMENT}
		</div><div class="clear">&nbsp;</div>
		<!-- END field -->
		<div class="clear">&nbsp;</div>
		<div class="clear">&nbsp;</div>
		<div class="align-center"> {FORM_SUBMIT} {FORM_RESET} </div>
	</fieldset>
{FORM_END}
</section>