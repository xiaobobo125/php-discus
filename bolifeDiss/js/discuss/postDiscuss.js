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
        var authorId = postDiscussPage.data.authorId;
        var editor = postDiscussPage.data.editor;
        var title = $('#postTitle').val();
        //alert(editor.txt.text());
        // $.ajax({
        //     url : app.URL.addPostUrl(),
        //     type : "POST",
        //     dataType: "json",
        //     contentType : "application/json;charset=UTF-8",
        //     data : JSON.stringify({
        //         authorId: authorId,
        //         title: title,
        //         htmlContent: editor.txt.html(),
        //         textContent: editor.txt.text(),
        //     }),
        //     success:function(result) {
        //         if (result && result['success']) {
        //             // 验证通过 刷新页面
        //             //window.location.reload();
        //             window.location.href = app.URL.discussUrl();
        //         } else {
        //             console.log(result.message);
        //         }
        //     },
        //     error:function(result){
        //         console.log(result.message);
        //     }
        // });
    },
};