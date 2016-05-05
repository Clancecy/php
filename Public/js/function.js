/**
 * Created by Chen on 2016/4/6.
 */



$(function(){
    $('#box').tree(
        {
            url:'{:U("Index/tree")}',
            lines:true,
        }
    );
});
