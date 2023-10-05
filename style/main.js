/* 打开侧栏 */
$(document).on('click','.mobile_menu',function() {
    $('.cat_menu .left').css('left','0');
    $('.menu_off').css('left','0');
});
$(document).on('click','.menu_off',function() {
    $('.cat_menu .left').css('left','-20rem');
    $('.menu_off').css('left','-100vw');
});
$(document).on('click','.cat_menu .item a',function() {
    $('.menu_off').click();
});


/* 昼夜模式 */
$(document).on('click','.todark_anniu',function() {
    $(this).hide();
    $('.tolight_anniu').show();
    $('html').addClass('darkmode');
    var date = new Date(); 
    date.setTime(date.getTime()+(3*60*60*1000));   
    document.cookie = "night=1;path=/;expires="+date.toGMTString();
});
$(document).on('click','.tolight_anniu',function() {
    $(this).hide();
    $('.todark_anniu').show();
    $('html').removeClass('darkmode');
    var date = new Date();
    date.setTime(date.getTime()+(3*60*60*1000));   
    document.cookie = "night=0;path=/;expires="+date.toGMTString();
});
/* 评论者头像 */
$(document).on('blur', '#toavatar', function(){
    var mail = $(this).val();
    $(".api_avatar").attr('src', 'https://cravatar.cn/avatar/' + $.md5(mail) +'?&d=mm');
});
$(function () {
    var moodall = "😀 😃 😄 😁 😆 😅 🤣 😂 🙂 🙃 😉 😊 😇 🥰 😍 🤩 😘 😗 😚 😙 😋 😛 😜 🤪 😝 🤑 🤗 🤭 🤫 🤔 🤐 🤨 😐 😑 😶 😏 😒 🙄 😬 🤥 😌 😔 😪 🤤 😴 😷 🤒 🤕 🤢 🤮 🤧 🥵 🥶 🥴 😵 🤯 🤠 🥳 😎 🤓 🧐 😕 😟 🙁 ☹️ 😮 😯 😲 😳 🥺 😦 😧 😨 😰 😥 😢 😭 😱 😖 😣 😞 😓 😩 😫 🥱 😤 😡 😠 🤬";
    var moodarr = moodall.split(" ");
    var mood = "<div class='comment_emoji_block'>";
        moodarr.forEach(function(element) {
            mood += "<span onclick=\"$('textarea.Comment_Textarea').val($('textarea.Comment_Textarea').val() + '" + element + "')\">" + element + "</span>";
        });
    mood += "</div>";
    $('textarea.Comment_Textarea').after(mood);
});
/* 滚动百分比 */
$(window).scroll(function(){
	let a = document.documentElement.scrollTop || window.pageYOffset,
		b = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight, document.body.offsetHeight, document.documentElement.offsetHeight, document.body.clientHeight, document.documentElement.clientHeight) - document.documentElement.clientHeight,
		result = Math.round(a / b * 100);
	if(result == 0){
	    $(".percentage").fadeOut();
	}else{
	    $(".percentage").fadeIn().css('display','flex');
	}
    $(".percentage .num").text(result);
});
$('body').on('click','.percentage',function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

/* 菜单滚动至窗口顶部加阴影 */
$(window).scroll(function() {
    var scrollTop = $(window).scrollTop();
    var catMenuTop = $('.cat_menu').offset().top;
    if (scrollTop == catMenuTop) {
        $('.cat_menu').css('box-shadow','var(--box-shadow)');
    } else {
        $('.cat_menu').css('box-shadow','unset');
    }
});

/* 加载更多文章 */
$(function () {
    if ($('.cat_archive_next a.next').length > 0) {
        var link = $('.cat_archive_next a.next').attr("href");
        $(".cat_archive_next").html("<span class='next' href='" + link + "'>more</span>");
    } else {
        $(".cat_archive_next").html("<span class='over'>已全部加载</span>");
    }
});
var isLoading = false;
$(window).on('scroll touchmove', function() {
    var A = Math.floor($(window).scrollTop()) + window.innerHeight;
    var B = $(document).height();
    if(!isLoading && Math.abs(A - B) < 50  && $('.cat_archive_next').find('.next').length > 0) {
        isLoading = true;
        setTimeout(function() {
            $('.cat_archive_next .next').click();
        }, 300);
    }
});
$('.main').on('click','.cat_archive_next .next',function() {
    $this = $(this);
    $this.addClass('loading').text("loading"); 
    var href = $this.attr('href');
    if (href != undefined) {
        $.ajax({
            url: href,
            type: 'get',
            error: function(request) {
            },
            success: function(data) {
                $this.removeClass('loading').text("more");
                
                var $res = $(data).find('.postlist');
                $('.postlist_out').append($res.fadeIn(500));
                var newhref = $(data).find('.cat_archive_next .next').attr('href');
                if (newhref != undefined) {
                    $('.cat_archive_next .next').attr('href', newhref);
                } else {
                    $('.cat_archive_next .next').remove();
                    $('.cat_archive_next').append('<span class="over">已全部加载</span>');
                }
                isLoading = false;
            }
        });
    }
    return false;
});

/* 点击回复某人 */
$('.main').on('click', '.cat_comment_reply', function () {
    $('.cat_cancel_comment_reply').show();
    $(".respond").appendTo($(".respond").parent().parent());
    $('.cat_comment_respond_form').css('outline','2px solid var(--theme-30)');
});

/* 取消回复某人 */
$('.main').on('click', '.cat_cancel_comment_reply', function () {
    $('.cat_cancel_comment_reply').hide();
    $('.cat_comment_respond_form').css('outline','none');
    return TypechoComment.cancelReply();
});

console.log("%c🌻 程序：Typecho | 主题：Sunny开源版 | 作者：火喵酱 | 官网：https://www.mmbkz.cn 🌻", "color:#fff; background: linear-gradient(270deg, #18d7d3, #68b7dd, #8695e6, #986fee); padding: 8px 15px; border-radius: 8px");




