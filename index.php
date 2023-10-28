<?php
/**
 * 轻奢极简，极速响应，记录每日新鲜事
 *
 * @package 🌻 Sunny
 * @author 火喵酱
 * @version 2023.开源版
 * @link https://www.mmbkz.cn
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<?php if ($this->request->getPathInfo() == '/links' || $this->request->getPathInfo() == '/archives'){
    $this->response->setStatus(200);
}?>
<?php
    define("XNAME", ($this->user->hasLogin() ? $this->user->screenName : $this->remember('author', true)));
    define("XMAIL", $this->user->hasLogin() ? $this->user->mail : $this->remember('mail', true));
    define("XSITE", $this->user->hasLogin() ? $this->user->url : $this->remember('url', true));
    define("MMBKZ", 'Powered by<a href="https://typecho.org/" target="_blank" cat_title="使用Typecho建站"> Typecho </a> & <a href="https://store.mmbkz.cn" target="_blank" cat_title="基于🌻Sunny1.0主题"> Sunny </a>');
?>
<html lang="zh-CN" class="<?php echo darkmode()?'darkmode':'';?>">
    <head>
        <meta charset="utf-8" />
        <meta name="renderer" content="webkit">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no, viewport-fit=cover, maximum-scale=1, minimum-scale=1">
        <title><?php
            if ($this->request->getPathInfo() == '/links') {
                echo '友情链接 - ';
            }elseif ($this->request->getPathInfo() == '/archives') {
                echo '文章归档 - ';
            }else {
                $this->archiveTitle(array(
                    'category' => '分类 %s 下的文章',
                    'search' => '包含关键字 %s 的文章',
                    'tag' => '标签 %s 下的文章',
                    'author' => '%s 发布的文章'
                ), '', ' - ');
            }
            $this->options->title();
        ?></title>
        <link rel="shortcut icon" href="<?php echo $this->options->cat_favicon ? $this->options->cat_favicon : 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text x=%22-0.125em%22 y=%22.9em%22 font-size=%2290%22>🌻</text></svg>' ?>" />
        <meta http-equiv="Cache-Control" content="no-transform" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <meta name="format-detection" content="telephone=no,email=no,adress=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
        <meta name="author" content="<?php echo max(Typecho_Db::get()->fetchRow(Typecho_Db::get()->select('screenName')->from('table.users')->where('uid = ?', '1'))); ?>" />
        <meta name="theme-color" content="<?php echo $this->options->user_themecolor ? $this->options->user_themecolor : '#ff6a6a'; ?>">


        <?php if ($this->is('single')) : ?>
            <meta name="keywords" content="<?php echo htmlspecialchars($this->keywords); ?>" />
            <meta name="description" content="<?php echo htmlspecialchars($this->description); ?>" />
            <?php $this->header('keywords=&description='); ?>
        <?php elseif ($this->is('archive')) : ?>
            <?php if ($this->request->getPathInfo() == '/links') : ?>
                <meta name="description" content="友情链接" />
            <?php elseif ($this->request->getPathInfo() == '/archives') : ?>
                <meta name="description" content="<?php $this->options->description();?>" />
            <?php else : ?>
                <meta name="description" content="<?php $this->options->title() . $this->archiveTitle() ?>" />
            <?php endif; ?>
            <?php $this->header('description='); ?>
        <?php else : ?>
            <?php $this->header(); ?>
        <?php endif; ?>
        <link rel="stylesheet" href="<?php $this->options->themeUrl('style/fancybox.css'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('style/main.css'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('style/article.css'); ?>">
        <link rel="stylesheet" href="<?php $this->options->themeUrl('style/prism.css'); ?>">
        <?php echo $this->options->cat_user_header ? $this->options->cat_user_header : '' ?>
        <?php echo $this->options->cat_user_css ? '<style>' . $this->options->cat_user_css . '</style>' : '' ?>
        <style>
            @font-face {
                font-family: 'user';
                font-weight: normal;
                font-style: normal;
                font-display: swap;
                src: url('<?php echo $this->options->cat_user_font?$this->options->cat_user_font:''; ?>');
            }
            html {
            	--theme: <?php echo ($this->options->user_themecolor ? $this->options->user_themecolor : '#ff6a6a') ?>;
            	--theme-10: <?php echo ($this->options->user_themecolor ? $this->options->user_themecolor . '1a' : '#ff6a6a1a') ?>;
            	--theme-30: <?php echo ($this->options->user_themecolor ? $this->options->user_themecolor . '4d' : '#ff6a6a4a') ?>;
            	--theme-60: <?php echo ($this->options->user_themecolor ? $this->options->user_themecolor . '99' : '#ff6a6a99') ?>;
            	--theme-80: <?php echo ($this->options->user_themecolor ? $this->options->user_themecolor . 'cc' : '#ff6a6acc') ?>;
            }
        </style>
        <script src="<?php $this->options->themeUrl('style/jquery.min.js'); ?>"></script>
    </head>
    <body>
        <div class="main_screen">
            <?php $this->need('parts/menu.php'); ?>
            <div class="main">
                <main class="main_body">
                    <?php $this->need('parts/title.php'); ?>
                    <?php $this->need('parts/article.php'); ?>
                    <div class="comment_part">
                        <?php if($this->is('single')): ?>
                            <?php $this->need('parts/comment.php'); ?>
                        <?php endif; ?>
                    </div>
                </main>
                <aside class="main_sidebar">
                    <?php $this->need('parts/sidebar.php'); ?>
                </aside>
            </div>
        </div>
        <!-- 灯箱 -->
        <script src="<?php $this->options->themeUrl('style/fancybox.umd.js'); ?>"></script>
        <!-- jq_md5 -->
        <script src="<?php $this->options->themeUrl('style/jquery.md5.min.js'); ?>"></script>
        <!-- 懒加载 -->
        <script src="<?php $this->options->themeUrl('style/lazysizes.min.js'); ?>"></script>
        <!-- main -->
        <script src="<?php $this->options->themeUrl('style/main.js'); ?>"></script>
        <script src="<?php $this->options->themeUrl('style/prism.js'); ?>"></script>
        <script src="<?php $this->options->themeUrl('style/instantpage.js'); ?>" type="module"></script>
        <?php $this->footer(); ?>
        <script>
            <?php echo $this->options->cat_user_js; ?>
        </script>
        <?php echo $this->options->cat_user_beforebody ? $this->options->cat_user_beforebody : '' ?>
    </body>
</html>