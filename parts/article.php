<?php if($this->is('single')): ?>

    <article itemscope itemtype="http://schema.org/BlogPosting" class="line-numbers" data-prismjs-copy='' cid="<?php echo $this->cid; ?>">
        <!-- 文章过期提醒 -->
        <?php if ($this->is('post') && floor((time() - ($this->modified)) / 86400) > 90) : ?>
            <div class="post_overtime">
                ⚠️ 本文最后更新于<?php echo date('Y年m月d日', $this->modified); ?>，已经过了<?php echo floor((time() - ($this->modified)) / 86400); ?>天没有更新，若内容或图片失效，请留言反馈
            </div>
        <?php endif; ?>
        <div class="post_content" itemprop="articleBody">
            <?php cat_article_changetext($this, $this->user->hasLogin()) ?>
        </div>
        <!-- 文章页底 -->
        <div class="article_end">
            <span>By <?php $this->author(); ?></span>
            <span>On <time datetime="<?php $this->date('Y年n月j日'); ?>" itemprop="datePublished"><?php $this->date('Y年n月j日'); ?></time></span>
        </div>
    </article>
    
    
<?php elseif($this->is('archive') || $this->is('index')): ?>

    <!-- 归档图标 -->
    <?php if ($this->request->getPathInfo() == '/links') :?>
        <div class="links_part_grid">
        <?php
            Links_Plugin::output('<a class="links_part_grid_item cat_block" href="{url}" target="_blank">
                <img class="lazyload avatar" src="'.get_AvatarLazyload(false).'" data-src="{image}"/>
                <span class="links_author">{name}</span>
                <p class="links_description">{title}</p>
            </a>');
        ?>
        </div>
    <?php elseif ($this->request->getPathInfo() == '/archives') :?>
        <div class="cat_guidang">
            <?php $this->widget('Widget_Contents_Post_Recent', 'pageSize=10000')->to($cat_post);
                $year=0; $mon=0; $i=0; $j=0;
                $output = '<div class="cat_block">';
                while($cat_post->next()):
                    $year_tmp = date('Y',$cat_post->created);
                    $mon_tmp = date('n',$cat_post->created);
                    $y=$year; $m=$mon;
                    if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
                    if ($year != $year_tmp && $year > 0) $output .= '</ul>';
                    if ($year != $year_tmp) {
                        $year = $year_tmp;
                        $output .= '<h3 style="text-align: center;padding: 2rem;">📁 '. $year .' 年</h3><ul>'; 
                    }
                    if ($mon != $mon_tmp) {
                        $mon = $mon_tmp;
                        $output .= '<li><div style="padding-left: 4.2rem;">📅 '. $year .' 年 '. $mon .' 月</div><ul class="cat_block">';
                    }
                    $output .= '<li class="item"><span>'.date('j日',$cat_post->created).'</span><a href="'.$cat_post->permalink .'">'. 
                $cat_post->title .'</a></li>';
                endwhile;
                $output .= '</ul></li></ul></div>';
                echo $output;
            ?>
        </div>
    <?php else :?>
        <!-- 正文 -->
        <div class="postlist_out">
            <?php $n = 0; while ($this->next()): ?>
                <div class="postlist cat_block" style="animation-delay: <?php echo 200 * $n; ?>ms;" itemscope itemtype="http://schema.org/BlogPosting">
    
                    <?php
                        $content = $this->content;
                        $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
                        preg_match_all($pattern, $content, $matches);
                        
                        $imageCount = count($matches[1]);
                        $maxImages = min($imageCount, 9);
                    ?>
                    
                    <!-- 头部 -->
                    <div class="postlist_head">
                        <a href="<?php echo $this->author->permalink ?>"><img class="avatar lazyload" src="<?php echo get_AvatarLazyload(); ?>" data-src="<?php echo get_AvatarByMail($this->author->mail) ?>" alt="博主" /></a>
                        <div class="middle">
                            <div class="top">
                                <?php echo $this->author->screenName; ?>
                            </div>
                            <div class="bottom">
                                <span cat_title="<?php echo date("Y年n月j日",$this->created)?>"><?php echo get_lastyear($this->created); ?></span>
                                <?php if(time() - $this->created <= 259200): ?>
                                     · <span style="color:#ff000099;">NEW!</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
    
    
                    <!-- 信息部分 -->
                    <div class="postlist_info">
                        
                        <!-- 标题 -->
                        <div class="postlist_title">
                            <span class="postlist_title_arrow">»</span>
                            <a href="<?php echo $this->permalink ?>">
                                <?php $this->title() ?>
                            </a>
                        </div>
                        
                        <!-- 图集/摘要 -->
                        <?php if($imageCount == 0):?>
                            <!-- 显示摘要 -->
                            <div class="postlist_abstract">
                                <?php echo get_Abstract($this,300); ?>
                            </div>
                        <?php else:?>
                            <div class="postlist_album" num="<?php echo $imageCount;?>">
                                <?php
                                    for ($i = 0; $i < $maxImages; $i++) {
                                        echo '<span data-fancybox="gallery'.$this->cid.'" class="postlist_gallery" href="'.$matches[1][$i].'"><img class="lazyload postlist_img" src="'.get_Lazyload().'" data-src="'.$matches[1][$i].'" alt="'.$this->title.'">';
                                        if ($imageCount > 9 && $i == 8) {
                                            echo '<span class="mask"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path></svg>'.($imageCount - 9).'</span>';
                                        }
                                        echo '</span>';
                                    }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- 标签 -->
                        <div class="postlist_tags" itemprop="keywords" >
                            <span class="pinglun">评论<?php $this->commentsNum('0', '1', '%d'); ?></span>
                            <?php $this->tags(' ', true, ''); ?>
                        </div>
                        
                    </div>
                        
                </div>
            <?php $n++; endwhile; ?>
        </div>
        <!-- more -->
        <div class="cat_archive_next">
            <?php $this->pageLink('more','next'); ?>
        </div>
        
    <?php endif; ?>
    
<!-- 其他页 -->
<?php else: ?>
<?php endif; ?>