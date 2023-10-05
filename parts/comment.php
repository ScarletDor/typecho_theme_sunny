<div id="comments">
<?php $this->comments()->to($comments); ?>

<?php if ($this->allow('comment') && $this->options->cat_comment_allow != "off") : ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
            <form method="post" class="cat_block cat_comment_respond_form" action="<?php $this->commentUrl() ?>" data-type="text">
				<div class="top"> 
					<div class="replyavatar">
						<img class="avatar api_avatar" src="<?php
    						if(!empty(XMAIL)){
    						    echo get_AvatarByMail(XMAIL);
    						}else{
    							echo get_AvatarLazyload();
    						}
    					?>" alt="">
					</div>
					<div class="head">
						<div class="list">
							<input type="email" id="toavatar" value="<?php echo XMAIL ?>" autocomplete="off" name="mail" placeholder="邮箱" />
						</div>
						<div class="list">
							<input type="text" value="<?php echo XNAME ?>" autocomplete="off" name="author" maxlength="16" placeholder="昵称" />
						</div>
						<div class="list">
							<input type="url" value="<?php echo XSITE ?>" autocomplete="off" name="url" placeholder="站点" />
						</div>
					</div>
				</div>
                <div class="body">
                    <textarea name="text" value="" class="Comment_Textarea" placeholder="注意文明发言哦！"></textarea>
                </div>
                <div class="foot">
                    <div class="right">
                        <div id="cancel-comment-reply-link" class="cat_cancel_comment_reply send_anniu_style">取消</div>
                        <button type="submit" class="send_anniu_style"><?php _e('发表'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    <?php if ($comments->have()): ?>
        <?php $comments->listComments(); ?>
        
        <?php
            $comments->pageNav(
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z" fill="var(--main)"></path></svg>',
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M13.1714 12.0007L8.22168 7.05093L9.63589 5.63672L15.9999 12.0007L9.63589 18.3646L8.22168 16.9504L13.1714 12.0007Z" fill="var(--main)"></path></svg>',
                1,
                '...',
                array(
                    'wrapTag' => 'div',
                    'wrapClass' => 'cat_pagination_page',
                    'itemTag' => 'li',
                    'textTag' => 'a',
                    'currentClass' => 'active',
                    'prevClass' => 'prev',
                    'nextClass' => 'next'
                )
            );
        ?>
    <?php endif; ?>
<?php else: ?>
    <div id="comments_is_off">此页面评论区已关闭</div>
<?php endif; ?>
</div>








<?php function threadedComments($comments, $options) {
?>
 
<li id="li-<?php $comments->theId(); ?>" class="<?php 
if ($comments->levels > 0) {
    echo 'cat_comment_child';
} else {
    echo 'cat_comment_parent';
}
?> <?php if ($comments->authorId) {if ($comments->authorId == $comments->ownerId){?>huomiaoreply<?php }}?> ">

    <div class="cat_comment_replyout" replyout_id="<?php $comments->theId(); ?>">
        <div class="cat_comment_body" id="<?php $comments->theId(); ?>" data-coid="<?php $comments->coid() ?>">
            <!-- 头像 -->
            <div class="cat_comment_reply" reply_id="<?php $comments->theId(); ?>" onclick="return TypechoComment.reply('<?php $comments->theId(); ?>', <?php $comments->coid(); ?>);">
                <img class="avatar lazyload" src="<?php get_AvatarLazyload() ?>" data-src="<?php echo get_AvatarByMail($comments->mail); ?>" alt="头像" />
                <div class="replymengban">@</div>
            </div>
        
            <div class="content">
                <!-- 标签 -->
                <div class="user"<?php if ($comments->authorId && $comments->authorId == $comments->ownerId) echo 'align="right"'; ?>>
            		<!-- 标签上姓名 -->
            		<span class="comment_user_name">
                        <?php echo $comments->author ?>
                    </span>
                    <!-- @父级用户名 -->
                    <?php get_comment_at($comments->coid) ?>
                    <!-- 待审核 -->
                    <?php if ($comments->status === "waiting") : ?>
                        <p class="waiting" style="color:var(--theme-60);">（评论审核中...）</p>
                    <?php endif; ?>
                </div>
                <!-- 内容 -->
                <?php
                    $db  = Typecho_Db::get();
                    $counts = $db->fetchAll($db
                        ->select('mail','author','parent')
                        ->from('table.comments')
                        ->where('coid = ?', $comments->coid)
                    );
                    $parent = $counts[0]['parent'];
                    $mail = $counts[0]['mail'];
                    $author = $counts[0]['author'];
                ?>
                <!-- 获取父级评论的用户email和用户名 -->
                <?php
                    $db  = Typecho_Db::get();
                    $counts = $db->fetchAll($db
                        ->select('mail','author')
                        ->from('table.comments')
                        ->where('coid = ?', $parent)
                    );
                    $mail_parent = (!empty($counts) && isset($counts[0]['mail']))?$counts[0]['mail']:'';
                    $author_parent = (!empty($counts) && isset($counts[0]['author']))?$counts[0]['mail']:'';
                ?>
                <div class="substance <?php 
                    if($comments->authorId == $comments->ownerId){
                        echo 'iscat';
                    }else{
                        echo 'isfriend';
                    }
                    ?>">
                    <?php echo cat_reply($comments->content);?>
                </div>
                <!-- 时间 -->
                <div class="commentinfos"<?php if ($comments->authorId) {if ($comments->authorId == $comments->ownerId){?>align="right"<?php }}?>>
                    <time cat_title="<?php $comments->date('Y年n月j日 H:i'); ?>" class="date" datetime="<?php $comments->date('jS H:i'); ?>"><?php $comments->dateWord(); ?></time>
                    <?php echo ' · ' . get_AgentOS($comments->agent) . ' · ' . get_AgentBrowser($comments->agent); ?>
                </div>
            </div>
        </div>
    </div>
    
    
    
    
    
    
    <?php if ($comments->children) { ?>
        <div class="comment-children">
            <?php $comments->threadedComments($options); ?>
        </div>
    <?php } ?>
</li>
<?php } ?>