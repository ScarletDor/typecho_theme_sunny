<!-- 搜索 -->
<section class="cat_block">
    <div class="little_card_title">Search</div>
    <form class="search" method="post" action="<?php $this->options->siteUrl(); ?>" role="search">
		<input type="text" id="s" name="s" class="text" placeholder="输入关键字回车"/>
	</form>
</section>

<!-- 推荐文章 -->
<?php if($this->options->cat_aside_toppost): ?>
    <section class="cat_block">
        <div class="little_card_title">Recommend</div>
        <?php $cidArray = explode(",", $this->options->cat_aside_toppost); ?>
        <?php foreach ($cidArray as $i => $cid) :?>
            <?php $this->widget('Widget_Archive@hots' . $cid, 'pageSize=1&type=post', 'cid=' . $cid)->to($cat_post); ?>
            <a class="cat_recentcomment_list" href="<?php echo $cat_post->permalink; ?>">
                <div class="left">
                    <span class="num"><?php echo $i+1; ?></span>
                </div>
                <div class="right">
                    <div class="user">
                        <span class="name" style="-webkit-line-clamp: 2;"><?php echo $cat_post->title; ?></span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </section>
<?php endif; ?>


<!-- 标签云 -->
<section class="cat_block">
    <div class="little_card_title">Tags</div>
    <ul class="cat_categorymenu">
        <?php $this->widget('Widget_Metas_Tag_Cloud', array('sort' => 'count', 'ignoreZeroCount' => true, 'desc' => true, 'limit' => 20))->to($taglist); ?>
        <?php while ($taglist->next()): ?>
            <a href="<?php $taglist->permalink(); ?>"><?php $taglist->name(); ?><span style="font-size: x-small; color: var(--B);"><?php $taglist->count(); ?></span></a>
        <?php endwhile; ?>
    </ul>
</section>

<!-- 自定义 -->
<?php echo $this->options->cat_aside_middle?$this->options->cat_aside_middle:''; ?>

<!-- 近期评论 -->
<section class="recent_comments">
    <?php $this->widget('Widget_Comments_Recent@sidebar', 'ignoreAuthor=true')->to($item); $count = 0;?>
    <?php if ($item->have()) : ?>
        <?php while ($item->next() && $count < 4) : ?>
            <div class="cat_block cat_recentcomment_list">
                <div class="left">
                    <img class="avatar lazyload" src="<?php get_AvatarLazyload() ?>" data-src="<?php echo get_AvatarByMail($item->mail); ?>" alt="<?php $item->author(false) ?>" />
                </div>
                <div class="right" cat_title="来自《<?php $item->title() ?>》">
                    <div class="user">
                        <div class="name"><?php $item->author(false) ?></div>
                        <time cat_title="<?php $item->date('Y年n月j日 H:m'); ?>" class="smalltext"><?php echo get_lastyear($item->created);?></time>
                    </div>
                    <div class="reply">
                        <a href="<?php $item->permalink() ?>">
                            <?php echo cat_reply($item->content); ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php $count++; ?>
        <?php endwhile; ?>
    <?php else : ?>
        <div class="cat_block">😎小站还没有评论呢</div>
    <?php endif; ?>
        <div class="cat_block aside_info_card">
            <div class="little_card_title">Info</div>
            <?php 
                $arr = array_values(array_filter(explode("\r\n", $this->options->cat_aside_bottom ?: '')));
                $arr[] = MMBKZ;
                foreach ($arr as $item) {
                    echo '<p>'.$item.'</p>';
                }
            ?>
        </div>
</section>