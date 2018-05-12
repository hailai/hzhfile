$(function () {
    $("#content").on('click','.blog',function () {
        var thisitem = $(this);
        var itemid = thisitem.parent().parent().children().first().text();
        $.ajax({
            method:'GET',
            url:'fullarticle.php',
            data:{itemid:itemid}
        })
        .done(function(fullarticle){
            thisitem.html(fullarticle);
        });
    });
    $("#content").on('click','.comments-icon',function () {
        $(this).parent().parent().children().last().find("textarea").focus();
        
    });
    $("#content").on('click','.likes-icon',function () {
        var thisitem = $(this);
        var itemid = thisitem.parent().parent().parent().children().first().text();
        $.ajax({
            method:'GET',
            url:'addlikes.php',
            data:{itemid:itemid}
        })
        .done(function(likes){
            thisitem.parent().next().html(likes+'次赞');
        })
    });
    
    $("#content").on('click','.comment-sub',function () {
        var thisitem = $(this);
        var visitorName = $(this).prev().val();
        var visitorEmail = $(this).prev().prev().val();
        var visitorComments = $(this).parent().prev().val();
        var itemId = $(this).parent().prev().prev().text();
        if(visitorName== '' || visitorEmail=='' || visitorComments==''){alert("不能为空");return;}
    $.ajax({
        method:"GET",
        url:"comments.php",
        data:{comments_name:visitorName,comment_email:visitorEmail,comments_content:visitorComments,item_id:itemId}
    })
    .done(function(comments) {
        thisitem.parent().prev().val('');
        thisitem.prev().val('');
        thisitem.prev().prev().val('');
        thisitem.parent().parent().parent().prev().prev().html(comments);
        
     });    
    });
    var flag = 1;
    var mixed = 1;
    $(window).scroll(function(e){
        if(( ($(window).height()  + $(document).scrollTop() + 5)  >= $(document).height() )  && flag==1) {
            var time = 0;
            flag = 0;

            var lastitemclass = $("#content :last").attr("class");
            if(lastitemclass != 'endline') {
                loading_gif($("#content"));

                
                if(mixed == 1){
                    ajax_chunk('mixed');
                } else {
                    var firstitem = $(".content-block").first();
                    var firstitemlabel = firstitem.children(".item-label").text();
                    ajax_chunk(firstitemlabel);
                }
                var index = setInterval(function(){
                    time++;
                    if(time == 1) {
                        clearInterval(index);
                        flag = 1;
                    }
                },1000)
            }

        };
        
    });

    $(".mosters").first().click(function(){
        
        ajax_page('photo');
        mixed = 0;
        flag = 1;
    });

    $(".mosters").eq(1).click(function(){
        
        ajax_page('blog');
        mixed = 0;
        flag =1;
    });

    $("#search-box a").click(function(){
        var keyword = $("#search-box input").val();
        if(keyword == ''){
            alert('不能为空');
            return;
        }
        ajax_page(keyword);
    });

});

function ajax_page(label){
    $.ajax({
        method:"GET",
        url:"/itemchunk.php",
        data:{itemid:0,lastitemlabel:label}
    })
    .done(function(itemchunk){
        $("#content").html('');
        setTimeout(function(){
             $("#content").html(itemchunk);
        });
    });
}

function ajax_chunk(lastitemlabel){
    var lastitem = $(".content-block").last();
    var lastitemid = lastitem.children(".item-id").text();
    $.ajax({
        method:"GET",
        url:"/itemchunk.php",
        data:{itemid:lastitemid,lastitemlabel:lastitemlabel}
    })
     .done(function(itemchunk){
        if($(".loading").length > 0){
            setTimeout(function(){
                $(".loading").remove();
                $("#content").append(itemchunk);
            },600);

        }

        // console.log(itemchunk);
        
    });
}

function loading_gif(appenditem){
    /*var loadingGif = $("img");
    loadingGif.attr('style','display:inline-block;width:60px;height:60px;margin:0 auto;');
    loadingGif.attr('src','/upload/image/Loading_icon.gif');
    loadingGif.attr('class','loading');*/
    appenditem.append('<div class="loading"><img src="/upload/image/spin.gif"></div>');
}
