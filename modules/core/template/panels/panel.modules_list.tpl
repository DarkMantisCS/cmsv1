{FORM_START}
<div class="content corners">
    <div class="title corners-top iblock">
        <h4 class="float-left">{L_FILTER_HOW}</h4>
        <div class="float-right padding">{FORM_SUBMIT} {FORM_RESET}</div>
    </div>
    <div class="padding">{F_FILTERS}</div>
</div><br />
{FORM_END}
<span style="font-size: 14px;"><strong>[</strong> {LETTER_TOGGLES} <strong>]</strong></span><br />

<div class="content">
<table width="100%" class="sorttable">
  <tr class="thead">
    <td class="padding" width="2%">&nbsp;</td>
    <td class="padding" width="30%">Module Name</td>
    <td class="padding" width="6%">Version</td>
    <td class="padding" width="10%">Author</td>
    <td class="padding" width="6%">Language</td>
    <td class="padding">Options</td>
  </tr>
<!-- BEGIN module -->
  <tr class="{module.ROW}">
    <td class="padding" valign="middle" align="center"><img src="{module.STATUS}" /></td>
    <td class="padding">{module.NAME}</td>
    <td class="padding">{module.VERSION}</td>
    <td class="padding">{module.AUTHOR}</td>
    <td class="padding">{module.LANG}</td>
    <td class="padding">{module.DEBUG}</td>
  </tr>
<!-- END module -->
</table>
</div>