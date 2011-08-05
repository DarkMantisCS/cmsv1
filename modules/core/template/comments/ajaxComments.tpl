<!-- BEGIN comment -->
<script> Effect.SlideDown('{comment.cID}'); </script>
<div id="{comment.cID}" style="display:none;"><br />
<div class="comment corners padding {comment.ROW}">
    <div class="clear">
    	<div class="float-left">Posted By: {comment.AUTHOR} on {comment.POSTED}</div>
    	<!-- BEGIN functions -->
        <a href="{comment.functions.URL}" id="btnRM" cmntId="{comment.ID}" class="float-right button remove">x</a>
        <!-- END functions -->
    </div><br /><br />
    <blockquote class="comments">{comment.POST}</blockquote>
</div>
</div>
<!-- END comment -->