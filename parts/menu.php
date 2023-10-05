<section class="cat_top">
    <div class="logo">
        <a href="<?php $this->options->siteUrl(); ?>">
	        <img class="avatar lazyload" src="<?php echo get_AvatarLazyload(); ?>" data-src="<?php echo $this->options->user_avatar?$this->options->user_avatar:get_user_avatar(1); ?>" alt="博主" />
        </a>
    </div>
    <div class="words">
        <a class="webtitle" href="<?php $this->options->siteUrl(); ?>">
            <?php $this->options->title(); ?>
        </a>
        <span class="description">
            <?php $this->options->description(); ?>
        </span>
    </div>
</section>
<section class="cat_menu cat_block">
    <ul class="left">
        <li class="item">
            <a class="title" href="<?php $this->options->siteUrl(); ?>">首页</a>
        </li>
        <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
        <?php if ($this->options->cat_menu_category_choose != 'off' && $category->have()): ?>
            <li class="item arrow">
                <div class="title">分类</div>
                <nav class="mainmenu_nav_child">
                    <?php while ($category->next()) : ?>
                        <?php if ($category->levels === 0) : ?>
                            <a href="<?php $category->permalink(); ?>">📂<?php $category->name(); ?></a>
                            <?php $children = $category->getAllChildren($category->mid); ?>
                            <?php if (!empty($children)) : ?>
                                <nav class="category_nav_child">
                                    <?php foreach ($children as $mid) : ?>
                                        <?php $child = $category->getCategory($mid); ?>
                                        <a href="<?php echo $child['permalink'] ?>" target="_blank"><?php echo $child['name']; ?></a>
                                    <?php endforeach; ?>
                                </nav>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </nav>
            </li>
        <?php endif; ?>
        <?php $pages = Typecho_Widget::widget('Widget_Contents_Page_List')->to($page);?>
        <?php while ($page->next()) :?>
            <div class="item">
                <div class="title">
                    <a href="<?php echo $page->permalink ?>" class="word" style="cursor:pointer;">
                        <?php echo $page->title ?>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
        <?php
            $blogUrl = $this->options->siteUrl;
            $linksUrl = $blogUrl . ($this->options->rewrite ? '' : 'index.php/') . 'links';
            $aboutUrl = $blogUrl . ($this->options->rewrite ? '' : 'index.php/') . 'archives';
        ?>
        <?php $plugin_export = Typecho_Plugin::export(); if (array_key_exists('Links', $plugin_export['activated'])): ?>
            <li class="item">
                <a class="title" href="<?php echo $linksUrl ?>">好友</a>
            </li>
        <?php endif; ?>
        
        <li class="item">
            <a class="title" href="<?php echo $aboutUrl ?>">归档</a>
        </li>
        
        <li class="item">
            <?php 
                $arr = array_values(array_filter(explode("\r\n", $this->options->cat_aside_bottom ?: '')));
                $arr[] = MMBKZ;
                foreach ($arr as $item) {
                    echo '<span class="bottom_infos">'.$item.'</span>';
                }
            ?>
        </li>
    </ul>
    <div class="right">
        <span class="anniu percentage" cat_title="回到顶部">
            <div class="num"></div>
        </span>
        <span class="anniu mobile_menu" cat_title="菜单">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"></path></svg>
        </span>
        <?php if($this->user->hasLogin()):?>
            <a class="anniu" href="<?php $this->options->adminUrl(); ?>" cat_title="管理" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.68735 4.00008L11.294 1.39348C11.6845 1.00295 12.3176 1.00295 12.7082 1.39348L15.3148 4.00008H19.0011C19.5533 4.00008 20.0011 4.4478 20.0011 5.00008V8.68637L22.6077 11.293C22.9982 11.6835 22.9982 12.3167 22.6077 12.7072L20.0011 15.3138V19.0001C20.0011 19.5524 19.5533 20.0001 19.0011 20.0001H15.3148L12.7082 22.6067C12.3176 22.9972 11.6845 22.9972 11.294 22.6067L8.68735 20.0001H5.00106C4.44877 20.0001 4.00106 19.5524 4.00106 19.0001V15.3138L1.39446 12.7072C1.00393 12.3167 1.00393 11.6835 1.39446 11.293L4.00106 8.68637V5.00008C4.00106 4.4478 4.44877 4.00008 5.00106 4.00008H8.68735ZM6.00106 6.00008V9.5148L3.51578 12.0001L6.00106 14.4854V18.0001H9.51578L12.0011 20.4854L14.4863 18.0001H18.0011V14.4854L20.4863 12.0001L18.0011 9.5148V6.00008H14.4863L12.0011 3.5148L9.51578 6.00008H6.00106ZM12.0011 16.0001C9.79192 16.0001 8.00106 14.2092 8.00106 12.0001C8.00106 9.79094 9.79192 8.00008 12.0011 8.00008C14.2102 8.00008 16.0011 9.79094 16.0011 12.0001C16.0011 14.2092 14.2102 16.0001 12.0011 16.0001ZM12.0011 14.0001C13.1056 14.0001 14.0011 13.1047 14.0011 12.0001C14.0011 10.8955 13.1056 10.0001 12.0011 10.0001C10.8965 10.0001 10.0011 10.8955 10.0011 12.0001C10.0011 13.1047 10.8965 14.0001 12.0011 14.0001Z"></path></svg>
            </a>
        <?php else: ?>
            <a class="anniu" href="/admin/login.php" cat_title="登录" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg>
            </a>
        <?php endif; ?>
        <span class="darkmode_percent">
            <span class="anniu tolight_anniu" cat_title="白天" style="<?php echo darkmode()?'':'display:none;'; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 18C8.68629 18 6 15.3137 6 12C6 8.68629 8.68629 6 12 6C15.3137 6 18 8.68629 18 12C18 15.3137 15.3137 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM11 1H13V4H11V1ZM11 20H13V23H11V20ZM3.51472 4.92893L4.92893 3.51472L7.05025 5.63604L5.63604 7.05025L3.51472 4.92893ZM16.9497 18.364L18.364 16.9497L20.4853 19.0711L19.0711 20.4853L16.9497 18.364ZM19.0711 3.51472L20.4853 4.92893L18.364 7.05025L16.9497 5.63604L19.0711 3.51472ZM5.63604 16.9497L7.05025 18.364L4.92893 20.4853L3.51472 19.0711L5.63604 16.9497ZM23 11V13H20V11H23ZM4 11V13H1V11H4Z"></path></svg>
            </span>
            <span class="anniu todark_anniu" cat_title="夜晚" style="<?php echo darkmode()?'display:none;':''; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 7C10 10.866 13.134 14 17 14C18.9584 14 20.729 13.1957 21.9995 11.8995C22 11.933 22 11.9665 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C12.0335 2 12.067 2 12.1005 2.00049C10.8043 3.27098 10 5.04157 10 7ZM4 12C4 16.4183 7.58172 20 12 20C15.0583 20 17.7158 18.2839 19.062 15.7621C18.3945 15.9187 17.7035 16 17 16C12.0294 16 8 11.9706 8 7C8 6.29648 8.08133 5.60547 8.2379 4.938C5.71611 6.28423 4 8.9417 4 12Z"></path></svg>
            </span>
        </span>
    </div>
    <div class="menu_off"></div>
</section>