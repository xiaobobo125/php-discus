/**
 * 模块JavaScript
 */
var postDiscussPage = {
    data:{
        authorId: 0,
        E: null,
        editor: null,
    },
    init: function (authorId) {
		postDiscussPage.data.authorId = 
        $('#postTitle').blur(function(){
            var value = $('#postTitle').val();
            if(value.length<5 || value.length > 25){
                alert("标题长度应该在6~25之间！");
            }
        });


        $('#postDiscussSubmitButton').click(function (e) {
            postDiscussPage.postDiscuss();
        });
        /**
         TODO::代码规范,文本编辑器
         */
        postDiscussPage.data.E = window.wangEditor;
        postDiscussPage.data.editor = new postDiscussPage.data.E('#editor'); 
        postDiscussPage.data.editor.create();
    },
    postDiscuss: function () {
		var content = $('#author').val();
        var editor = postDiscussPage.data.editor;
        var title = $('#postTitle').val();
        $.ajax({
            url : "./include/savePost.php",
            type : "POST",
            dataType: "json",
            data :{
                authorId: content,
                title: title,
                htmlContent: editor.txt.html(),
                textContent: editor.txt.text(),
            },
            success:function(result) {
                if (result || result['success']) {
                    // 验证通过 刷新页面
                    //window.location.reload();
                    window.location.href = "../bolifeDiss/discuss.php";
                } else {
                    console.log(result.message);
                }
            },
            error:function(result){
                console.log(result.message);
            }
        });
    },
};