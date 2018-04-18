$(function () {
    $("a[name='del']").click(function () {
        var del = confirm('您确认要删除吗？');
        if(del) {
            var itemId = $(this).parent().prev().prev().prev().prev().text();
            $.ajax({
                method:"GET",
                url:"delete.php",
                data:{itemid:itemId},
                dataType: "json"
            })
                .done(function (pages) {
                    if(pages.st == 1){
                        $("table[name='jkls'] tbody").load("pages.php");
                    }else{
                        alert("删除失败");
                        console.log(pages.st);
                    }
                })
        }

    })
    $("a[name='mod']").click(function () {
        /*var tbody = $(this).parent().parent().parent();
        console.log($("table[name='jkls'] tbody"));*/
        // var json = {"status":0}
        // console.log(json.status);
    })

    $("input:radio[name='label']").click(function(){
        var label = $("input:radio[name='label']:checked").val();
        if(label == 'photo') {
            $("#photo-block").attr('style','display:block');
            $("#blog-block").attr('style','display:none');
        } else {
            $("#photo-block").attr('style','display:none');
            $("#blog-block").attr('style','display:block');
        }
    })
    
})