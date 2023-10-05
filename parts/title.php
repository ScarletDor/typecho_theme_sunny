<?php if(!$this->is('index')): ?>
    <!-- 标题 -->
    <div class="title_block cat_block">
        <!-- 文章页（标题） -->
        <?php if($this->is('post')): ?>
            <div class="title_block_title">
                <h1><?php echo $this->title ?></h1>
            </div>
        <!-- 页面（页面标题） -->
        <?php elseif($this->is('page')): ?>
            <div class="title_block_title">
                <h1><?php echo $this->title ?></h1>
            </div>
        <!-- 归档页 -->
        <?php elseif($this->is('archive')): ?>
            <!-- 归档图标 -->
            <?php
                if ($this->is('category')) {
                    $icon = '📂'.$this->archiveTitle;
                } elseif ($this->is('tag')) {
                    $icon = '🔖'.$this->archiveTitle;
                } elseif ($this->is('search')) {
                    $icon = '🔍'.$this->archiveTitle;
                } elseif ($this->is('date')) {
                    $icon = '📅'.$this->archiveTitle;
                } elseif ($this->is('author')) {
                    $icon = '👦'.$this->archiveTitle;
                } elseif ($this->request->getPathInfo() == '/links') {
                    $icon = '🙆友情链接';
                } elseif ($this->request->getPathInfo() == '/archives') {
                    $icon = '📁统计归档';
                } else {
                    $icon = '⚠️'.$this->archiveTitle;
                }
            ?>
            <!-- 归档标题 -->
            <div class="title_block_title">
                <?php echo '<h1>'.$icon.'</h1>'; ?>
            </div>
        <!-- 其他页 -->
        <?php else: ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
