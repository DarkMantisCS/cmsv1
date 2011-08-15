{MSG}

{FORM_START}{HIDDEN_FIELDS}
<div class="content corners">
    <div class="title corners-top iblock">
        <h4 class="float-left"></h4>
        <div class="float-right padding">{SELECT}</div>
    </div>
    <div id="contentTarget" class="padding">
        {POPULATE_FORM}
    </div>
    <div id="contentTarget" class="padding">
        {SUBMIT} {RESET}
    </div>
    <div class="clear"></div>
</div><br />
{FORM_END}

<div style="display:none;">
<div id="hiddenForm" style="display:none;">{HFORM}</div>
</div>