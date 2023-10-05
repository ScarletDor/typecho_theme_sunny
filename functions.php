<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor', 'edit');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor', 'edit');
class Editor
{
    public static function edit()
    {
        echo "<link rel='stylesheet' href='" . Helper::options()->themeUrl . '/style/option.css' . "'>";
        echo "<script src='" . Helper::options()->themeUrl . '/style/editor.js' . "'></script>";

    }
}

function get_AgentBrowser($agent)
{
	if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
		$outputer = 'IE浏览器';
	} else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
		$outputer = '火狐浏览器';
	} else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Edge';
	} else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
		$outputer = '360极速';
	} else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Edge';
	} else if (preg_match('/UC/i', $agent)) {
		$outputer = 'UC浏览器';
	} else if (preg_match('/QQ/i', $agent, $regs) || preg_match('/QQ Browser\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'QQ浏览器';
	} else if (preg_match('/UBrowser/i', $agent, $regs)) {
		$outputer = 'UC浏览器';
	}else if (preg_match('/BIDU/i', $agent, $regs)) {
        $outputer = '百度浏览器';
    } else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Opera';
	} else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Chrome';
	} else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Safari';
	} else {
		$outputer = 'Chromium';
	}
	return $outputer;
}
function get_AgentOS($agent)
{
	$os = "Linux";
	if (preg_match('/windows/i', $agent)) {
		$os = 'Windows';
	} else if (preg_match('/android/i', $agent)) {
		$os = 'Android';
	} else if (preg_match('/ubuntu/i', $agent)) {
		$os = 'Ubuntu';
	} else if (preg_match('/iPhone/i', $agent)) {
		$os = 'iPhone';
	} else if (preg_match('/mac/i', $agent)) {
		$os = 'MacOS';
	} else {
		$os = 'Linux';
	}
	return $os;
}
/* 时间更替（当年） ok */
function get_lastyear($date){
    $d = new Typecho_Date(Typecho_Date::gmtTime());
    $now = $d->format('Y-m-d H:i:s');
    $t = strtotime($now) - $date;
    
    $time_units = array(
        31536000 => '年',
        2592000 => '月',
        604800 => '周',
        86400 => '天',
        3600 => '小时',
        60 => '分钟',
        1 => '秒'
    );
    
    foreach ($time_units as $unit => $label) {
        if ($t >= $unit) {
            $value = floor($t / $unit);
            return $value . $label . '前';
        }
    }
}
/* 获取头像懒加载图 ok */
function get_AvatarLazyload($type = true)
{
	$str = 'data:image/png;base64,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';
	if ($type) echo $str;
	else return $str;
}
/* 通过邮箱生成头像地址 ok */
function get_AvatarByMail($mail)
{
	$mailLower = strtolower($mail);
	$md5MailLower = md5($mailLower);
	$qqMail = str_replace('@qq.com', '', $mailLower);
	if (strstr($mailLower, "qq.com") && is_numeric($qqMail) && strlen($qqMail) < 11 && strlen($qqMail) > 4) {
		return 'https://q1.qlogo.cn/g?b=qq&nk=' . $qqMail . '&s=100';
	} else {
    	return 'https://cravatar.cn/avatar/' . $md5MailLower . '?&d=mm&s=200';
	}
};
/* 自定义头像 */
function get_user_avatar($user)
{
    if (Helper::options()->cat_Index_user_avatar){
        $str = Helper::options()->cat_Index_user_avatar;
    }else{
        $db  = Typecho_Db::get();
        $row = $db->fetchRow($db
            ->select('mail')
            ->from('table.users')
            ->where('uid = ?', $user)
        );
        $mail = max($row);
        if(!empty($row)){
            $str = get_AvatarByMail($mail);    
        }else{
            $str = get_AvatarLazyload();
        }
    }
	return $str;
}
/* 获取全局懒加载图 ok */
function get_Lazyload($type = true)
{
    return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}

function time_ago($ptime) {
    $etime = time() - $ptime;
    if ($etime < 1) {
        return '刚刚';
    }
    $interval = array (
        12 * 30 * 24 * 60 * 60 => '年',
        30 * 24 * 60 * 60 => '个月',
        7 * 24 * 60 * 60 => '周',
        24 * 60 * 60 => '天',
        60 * 60 => '小时',
        60 => '分钟',
        1 => '秒'
    );
    foreach ($interval as $seconds => $unit) {
        $duration = floor($etime / $seconds);
        if ($duration >= 1) {
            return $duration . $unit . '前';
        }
    }
}
function darkmode(){
    $darkmode = false;
    if(isset($_COOKIE['night'])){
        $darkmode = ($_COOKIE['night'] == 1) ? true : false;
    }elseif(Helper::options()->cat_darkmode && Helper::options()->cat_darkmode != 'auto'){
        $darkmode = (Helper::options()->cat_darkmode == 'dark') ? true : false;
    }else{
        $darkmode = (date("H") < 6 || date("H") >= 18) ? true : false;
    }
    return $darkmode;
}

function cat_check_XSS($text)
{
    $isXss = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',  
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $isXss = true;
                break;
            }
        }
    } else {
        $isXss = true;
    };
    return $isXss;
}

function cat_reply($text,$word = true)
{
    if (cat_check_XSS($text)) {
        $text = "该回复疑似异常，已被系统拦截！";
    }
    if($word == true){
        $text = strip_tags($text, "<img>");
    }else{
        $text = rtrim(strip_tags($text), "\n");
    }
    return $text;
}

function get_comment_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent,status')->from('table.comments')
        ->where('coid = ?', $coid));
    $mail = "";
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author,status,mail')->from('table.comments')
            ->where('coid = ?', $parent));
        $author = (!empty($arow) && isset($arow['author']))?$arow['author']:'';
        $mail = (!empty($arow) && isset($arow['mail']))?$arow['mail']:'';
        if($author && $arow['status'] == "approved"){
            echo '<a style="font-size: 0.75rem;display: inline; color: var(--colorC);" href="#comment-' . $parent . '">@' . $author . '</a>';
        }
    }
}

function cat_article_changetext($post, $login){
    $content = $post->content;
    $cid = $post->cid;
    $content = strtr($content, array(
        "{x}" => '✅',
        "{ }" => '☑️'
    ));
    $content = preg_replace('/{{([\s\S]*?)}{([\s\S]*?)}}/', '<span class="e" cat_title="${2}">${1}</span>' , $content);
    $content = preg_replace('/{cat_localmusic name="([\s\S]*?)" url="([\s\S]*?)"}/', '<cat_music><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 3V17C20 19.2091 18.2091 21 16 21C13.7909 21 12 19.2091 12 17C12 14.7909 13.7909 13 16 13C16.7286 13 17.4117 13.1948 18 13.5351V5H9V17C9 19.2091 7.20914 21 5 21C2.79086 21 1 19.2091 1 17C1 14.7909 2.79086 13 5 13C5.72857 13 6.41165 13.1948 7 13.5351V3H20ZM5 19C6.10457 19 7 18.1046 7 17C7 15.8954 6.10457 15 5 15C3.89543 15 3 15.8954 3 17C3 18.1046 3.89543 19 5 19ZM16 19C17.1046 19 18 18.1046 18 17C18 15.8954 17.1046 15 16 15C14.8954 15 14 15.8954 14 17C14 18.1046 14.8954 19 16 19Z"></path></svg>${1}</span><audio style="width:100%;" src="${2}" controls>浏览器不支持音频播放。</audio></cat_music> ', $content);
    $content = preg_replace('/{cat_webmusic name="([\s\S]*?)" id="([\s\S]*?)"}/', '<cat_music><span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10.4222 11.375C10.1278 12.4026 10.4341 13.4395 11.2058 14.0282C12.267 14.8376 13.7712 14.3289 14.0796 13.0331C14.1599 12.6958 14.1833 12.311 14.1067 11.9767C13.8775 10.9756 13.586 9.98862 13.3147 8.98094C11.9843 9.13543 10.7722 10.1533 10.4222 11.375ZM15.9698 11.0879C16.2427 12.1002 16.2553 13.1053 15.8435 14.0875C14.7148 16.7784 11.1215 17.2286 9.26951 14.9136C7.96829 13.2869 7.99065 10.953 9.32982 9.18031C10.1096 8.14796 11.1339 7.47322 12.3776 7.12595C12.5007 7.09159 12.6241 7.058 12.7566 7.02157C12.6731 6.60736 12.569 6.20612 12.5143 5.79828C12.3375 4.48137 13.026 3.29477 14.2582 2.7574C15.4836 2.22294 16.9661 2.54204 17.7889 3.51738C18.1936 3.99703 18.183 4.59854 17.7631 4.98218C17.3507 5.359 16.7665 5.32761 16.3276 4.89118C16.0809 4.64585 15.8185 4.45112 15.451 4.45569C14.9264 4.46223 14.4642 4.87382 14.5058 5.39329C14.5432 5.86105 14.6785 6.32376 14.8058 6.77892C14.8276 6.85679 15.0218 6.91415 15.1436 6.9321C16.4775 7.12862 17.6476 7.66332 18.6165 8.60769C21.1739 11.1006 21.4772 15.1394 19.2882 18.0482C17.7593 20.0797 15.6785 21.2165 13.1609 21.4567C8.53953 21.8977 4.49683 18.9278 3.46188 14.3992C2.5147 10.2551 4.8397 5.83074 8.79509 4.25032C9.38067 4.01635 9.93787 4.21869 10.1664 4.74827C10.3982 5.28546 10.147 5.83389 9.55552 6.09847C7.18759 7.15787 5.73935 8.9527 5.34076 11.5215C4.80806 14.9546 6.99662 18.2982 10.3416 19.2428C13.0644 20.0117 15.9994 19.0758 17.6494 16.9123C19.2354 14.8328 19.0484 11.8131 17.2221 10.0389C16.7172 9.54838 16.1246 9.21455 15.3988 9.02564C15.5974 9.74151 15.7879 10.4136 15.9698 11.0879Z"></path></svg>${1}</span><audio style="width:100%;" src="https://music.163.com/song/media/outer/url?id=${2}.mp3" controls>浏览器不支持音频播放。</audio></cat_music>', $content);
    $content = preg_replace('/{cat_video key="([\s\S]*?)"}/','<cat_article_video><video width="100%" controls="controls"><source src="${1}" type="video/mp4"></video></cat_article_video>',$content);
    $content = preg_replace('/{cat_bili p="([\s\S]*?)" key="([\s\S]*?)"}/', '<cat_article_video><iframe src="https://www.bilibili.com/blackboard/html5mobileplayer.html?bvid=${2}&amp;page=${1}&amp;as_wide=1&amp;danmaku=0&amp;hasMuteButton=1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe></cat_article_video>', $content);
    $content = preg_replace('/<p><cat_article_video([\s\S]*?)<\/cat_article_video><\/p>/', '<cat_article_video${1}</cat_article_video>', $content);
    $content = preg_replace('/{cat_tips_success}([\s\S]*?){\/cat_tips_success}/', '<div class="cat_tips cat_tips_success">${1}</div>', $content);
    $content = preg_replace('/{cat_tips_info}([\s\S]*?){\/cat_tips_info}/', '<div class="cat_tips cat_tips_info">${1}</div>', $content);
    $content = preg_replace('/{cat_tips_warning}([\s\S]*?){\/cat_tips_warning}/', '<div class="cat_tips cat_tips_warning">${1}</div>', $content);
    $content = preg_replace('/{cat_tips_error}([\s\S]*?){\/cat_tips_error}/', '<div class="cat_tips cat_tips_error">${1}</div>', $content);
    $db = Typecho_Db::get();
    $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $cid)->where('mail = ?', $post->remember('mail', true))->limit(1));
    if ($hasComment || $login) {
        $content = strtr($content, array("{cat_hide}" => "<div class='cat_block'><div class='cat_article_show_word'>此处内容回复后可见，现已为您显示</div>", "{/cat_hide}" => "</div>"));
    } else {
        $content = preg_replace('/{cat_hide[^}]*}([\s\S]*?){\/cat_hide}/', '<cat_article_hide>此处内容，需回复之后可见</cat_article_hide>', $content);
    }
    $content = preg_replace('/<img src([\s\S]*?)title="([\s\S]*?)">/', '<cat_post_image><img src="' . get_Lazyload() . '" class="postimg isfancy lazyload" data-src${1}></cat_post_image>', $content);
    $content = preg_replace('/<p><cat_post_image([\s\S]*?)<\/cat_post_image><\/p>/', '<cat_post_image${1}</cat_post_image>', $content);
    $content = preg_replace('/<img src="(.*?)" class="(.*?)" data-src="(.*?)" alt="(.*?)"(.*?)>/', '<span data-fancybox="gallery" data-caption="${4}" href="${3}"><img src="${1}" class="${2}" data-src="${3}" alt="${4}"></span>', $content);
    echo $content;
}

function get_Abstract($item, $num)
{
	$abstract = "";
	if ($item->password) {
		$abstract = "⚠️此文章已加密";
	} else {
		if ($item->fields->post_abstract) {
			$abstract = $item->fields->post_abstract;
		} else {
			$abstract = strip_tags($item->excerpt);
			$abstract = preg_replace('/\-o\-/', '', $abstract);
            $abstract = preg_replace('/{[^{]+}/', '', $abstract);
		}
	}
	if ($abstract === '') $abstract = "⚠️此文章暂无简介";
	return mb_substr($abstract, 0, $num);
}

function themeConfig($form)
{
?>
<link rel='stylesheet' href='<?php echo Helper::options()->themeUrl . '/style/option.css'; ?>'>
<div class="theme_title">🌻𝕾𝖚𝖓𝖓𝖞</div>


<?php
/* 备份还原 https://blog.zezeshe.com/archives/typecho-templates-backup-restore-pro.html */
$str1 = explode('/themes/', Helper::options()->themeUrl);
$str2 = explode('/', $str1[1]);
$name=$str2[0];
$db = Typecho_Db::get();
$sjdq=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name));
$ysj = isset($sjdq['value'])?$sjdq['value']:'';
if(isset($_POST['type'])) {
	if($_POST["type"]=="备份模板设置数据") {
		if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'))) {
			$update = $db->update('table.options')->rows(array('value'=>$ysj))->where('name = ?', 'theme:'.$name.'bf');
			$updateRows= $db->query($update);
			echo '<div class="typecho-option" style="display: block;color:white;background:green;">备份已更新，请等待自动刷新！如果等不到请点击';
			?>    
			<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
			<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);
			</script>
			<?php
		} else {
			if($ysj) {
				$insert = $db->insert('table.options')
				    ->rows(array('name' => 'theme:'.$name.'bf','user' => '0','value' => $ysj));
				$insertId = $db->query($insert);
				echo '<div class="typecho-option" style="display: block;color:white;background:green;">备份完成，请等待自动刷新！如果等不到请点击';
				?>    
				<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
				<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);
				</script>
				<?php
			}
		}
	}
	if($_POST["type"]=="还原模板设置数据") {
		if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'))) {
			$sjdub=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'));
			$bsj = $sjdub['value'];
			$update = $db->update('table.options')->rows(array('value'=>$bsj))->where('name = ?', 'theme:'.$name);
			$updateRows= $db->query($update);
			echo '<div class="typecho-option" style="display: block;color:white;background:green;">检测到模板备份数据，恢复完成，请等待自动刷新！如果等不到请点击';
			?>    
			<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
			<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2000);
			</script>
			<?php
		} else {
			echo '<div class="typecho-option" style="display: block;color:white;background:red;">没有模板备份数据，恢复不了哦！</div>';
		}
	}
	if($_POST["type"]=="删除备份数据") {
		if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:'.$name.'bf'))) {
			$delete = $db->delete('table.options')->where ('name = ?', 'theme:'.$name.'bf');
			$deletedRows = $db->query($delete);
			echo '<div class="typecho-option" style="display: block;color:white;background:green;">删除成功，请等待自动刷新，如果等不到请点击';
			?>    
			<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
			<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);
			</script>
			<?php
		} else {
			echo '<div class="typecho-option" style="display: block;color:white;background:orange;">不用删了！备份不存在！！</div>';
		}
	}
}
?>
<div class="typecho-option" style="display: block;">
    <label class="typecho-label">欢迎使用Sunny主题</label>
    <div class="description">
        <li><h3>您使用的是Sunny开源版，可任意修改本主题，但请勿去除本模块、以及控制台中的版权信息。</h3></li>
        <li>本主题支持<u>Hanny的Links插件</u>，开启自动生成友链页面，<a href="//www.imhan.com/archives/typecho-links/" target="_blank">点此去官网</a>下载插件。也可在喵喵聊天群内群文件下载。</li>
        <li>作者：<a href="https://www.mmbkz.cn/" target="_blank">火喵酱</a></li>
        <li>官网：<a href="https://www.mmbkz.cn/sunny.html" target="_blank">https://www.mmbkz.cn/sunny.html</a></li>
        <li>Github仓库：<a href="https://github.com/ScarletDor/typecho_theme_sunny" target="_blank">https://github.com/ScarletDor/typecho_theme_sunny</a></li>
        <li>官群：103659317</li>
        <li>　</li>
        <li style="color:green">喵喵很努力用心的制作了这款主题，如果您喜欢，仅需一杯低价拿铁的价格就可以入手这款主题的正式版。<br>如果您想请喵喵喝更高级的拿铁，欢迎随时打赏喵喵！打赏时标明您的身份，喵喵会记录到博客里的！</li>
        <li>　</li>
    </div>
    <div style="display:flex;flex-direction: row;">
        <img src="data:image/webp;base64,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" alt=""/>
        <img src="data:image/webp;base64,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" alt=""/>
    </div>
</div>

<div class="typecho-option" style="display: block;">
    <label class="typecho-label">备份选项</label>
    <form class="protected home" action="?<?php echo $name; ?>bf" method="post">
        <input type="submit" name="type" class="cat_block backup_botton backup_botton_green" value="备份模板设置数据" />
        <input type="submit" name="type" class="cat_block backup_botton backup_botton_green" value="还原模板设置数据" />
        <input type="submit" name="type" class="cat_block backup_botton backup_botton_red" value="删除备份数据" />
        <div class="description">说明：在更换主题之后，因为typecho特性，所有的设置内容均会消失。因此在更换主体之前请先备份。日常也请养成随手备份的习惯。</div>
    </form>
</div>

<?php
    /* 自定义favicon */
    $cat_favicon = new Typecho_Widget_Helper_Form_Element_Text(
        'cat_favicon',
        null,
        null,
        '设置网站favicon',
        '介绍：输入favicon地址，使用ico格式'
    );
    $form->addInput($cat_favicon);
    
    /* 自定义主题色 */
    $user_themecolor = new Typecho_Widget_Helper_Form_Element_Text(
        'user_themecolor',
        NULL,
        NULL,
        '自定义主题色',
        '介绍：可以选择一种自定义主题色（六位字符不要带透明度）<br>
         说明：开头需带 “ # ” ，默认主题色为 #ff6a6a（淡红色）'
    );
    $form->addInput($user_themecolor);

    /* 自定义主题色 */
    $user_avatar = new Typecho_Widget_Helper_Form_Element_Text(
        'user_avatar',
        NULL,
        NULL,
        '自定义顶部头像',
        '介绍：填入自定义顶部要显示的头像图片地址'
    );
    $form->addInput($user_avatar);

    /* 昼夜模式 */
    $cat_darkmode = new Typecho_Widget_Helper_Form_Element_Select(
        'cat_darkmode',
        array(
            'auto' => '自动',
            'light' => '白天',
            'dark' => '夜晚'
        ),
        'auto',
        '昼夜模式',
        '介绍：自动模式6:00-18:00为白天，否则为夜晚；前台用户手动修改有效期为三小时。'
    );
    $form->addInput($cat_darkmode->multiMode());

    /* 关闭所有评论 */
    $cat_comment_allow = new Typecho_Widget_Helper_Form_Element_Select(
        'cat_comment_allow',
        array(
            'on' => '开启所有评论区',
            'off' => '关闭所有评论区'
        ),
        'on',
        '评论区开关',
        '介绍：页面单独的评论区开关请在页面内单独设置'
    );
    $form->addInput($cat_comment_allow->multiMode());
    
    $cat_aside_toppost = new Typecho_Widget_Helper_Form_Element_Text(
        'cat_aside_toppost',
        NULL,
        NULL,
        '侧栏推荐文章',
        '介绍：填写推荐文章的cid，中间使用半角逗号分隔，不填则不显示。
         示例：6,8,9'
    );
    $form->addInput($cat_aside_toppost);

    $cat_aside_middle = new Typecho_Widget_Helper_Form_Element_Textarea(
        'cat_aside_middle',
        NULL,
        NULL,
        '侧栏自定义内容',
        '介绍：可填写侧栏中间自定义内容，位于最后部分之前<br>
         说明：可使用cat_block属性为需要的部分添加外框。<br>
         示例：&lt;section class="cat_block"&gt;自定义内容&lt;/section&gt;'
    );
    $form->addInput($cat_aside_middle);
    
    $cat_aside_bottom = new Typecho_Widget_Helper_Form_Element_Textarea(
        'cat_aside_bottom',
        NULL,
        NULL,
        '底部备案信息',
        '介绍：显示在侧栏底部，可填写icp备案号等内容。<br>
         说明：一行一句内容。<br>
         关于：<span style="color:red;">切莫删除主题版权信息，可以让更多人了解这款主题！感谢♥</span>'
    );
    $form->addInput($cat_aside_bottom);

    $cat_user_font = new Typecho_Widget_Helper_Form_Element_Text(
        'cat_user_font',
        NULL,
        NULL,
        '自定义字体',
        '介绍：请填写自定义字体地址，使用cdn地址时，需自行解决跨域问题。'
    );
    $form->addInput($cat_user_font);
    
    $cat_user_css = new Typecho_Widget_Helper_Form_Element_Textarea(
        'cat_user_css',
        NULL,
        NULL,
        '自定义css',
        '介绍：请填写自定义CSS内容，填写时无需填写style标签<br>
         示例：.cat_block,article{outline: 1px solid var(--A);}'
    );
    $form->addInput($cat_user_css);
    
    $cat_user_js = new Typecho_Widget_Helper_Form_Element_Textarea(
        'cat_user_js',
        NULL,
        NULL,
        '自定义js',
        '介绍：请填写自定义JS内容，填写时无需填写script标签'
    );
    $form->addInput($cat_user_js);

    $cat_user_header = new Typecho_Widget_Helper_Form_Element_Textarea(
        'cat_user_header',
        NULL,
        NULL,
        '&lt;head&gt;&lt;/head&gt;标签内自定义内容',
        '介绍：此处用于在&lt;head&gt;&lt;/head&gt;标签里增加自定义内容<br>
         例如：可以填写引入第三方css等'
    );
    $form->addInput($cat_user_header);
    
    $cat_user_beforebody = new Typecho_Widget_Helper_Form_Element_Textarea(
        'cat_user_beforebody',
        NULL,
        NULL,
        '&lt;/body&gt;标签前自定义内容',
        '介绍：此处用于在&lt;/body&gt;标签前增加自定义内容<br>
         例如：可以填写引入第三方js等'
    );
    $form->addInput($cat_user_beforebody);
}