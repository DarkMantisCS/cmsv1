<div id="comments">
    <div id="commentError">{_ERROR}</div>
    <div align="right">{COM_PAGINATION}</div>
    <div id="commentContents">
        <!-- BEGIN comment -->
            <div id="{comment.cID}"><br />
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
    </div>
    <div align="right">{COM_PAGINATION}</div>
{_NEW_COMMENT}
</div>