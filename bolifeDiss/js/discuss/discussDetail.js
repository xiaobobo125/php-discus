/**
 * 模块JavaScript
 */
var discussDetailPage = {
    data:{
        post: null,
        comments: [],
        userId: 0,
    },
    init: function () {

        /**
         * 回复模态框关闭按钮触发
         */
        $('#cancelReplyBtn').click(function (e) {
            $('#replyModal').modal('hide');
        });
        /**
         * 回复模态框登录按钮触发
         */
        $('#confirmReplyBtn').click(function (e) {
            discussDetailPage.addReplyAction();
        });
    },
    addCommentsAction: function () {
        var userId = $('#userId').val();
        var post = $('#postId').val();
        var content = $('#commentContent').val();
        $.ajax({
            url : "./include/addComment.php",
            type : "POST",
            dataType: "json",
            data : {
                userId: userId,
                postId: post,
                content: content,
            },
            success:function(result) {
                if (result && result['success']) {
                    // 验证通过 刷新页面
                    window.location.reload();
                } else {
                    console.log(result.message);
                }
            },
            error:function(result){
                console.log(result.message);
            }
        });
    },
    /**
     * 回复模态框显示
     */
    showReplyModal: function(atuserId,commentId) {
        $('#replyCommentId').val(commentId);
        $('#replyAtuserId').val(atuserId);
        $('#replyModal').modal('show');
    },
    addReplyAction: function () {
        var post = $('#postId').val();
        var reuserId = $('#reuserId').val();
        var commentId = $('#replyCommentId').val();
        var atuserId = $('#replyAtuserId').val();
        var content = $('#replyContent').val();
        $.ajax({
            url : "./include/addReply.php",
            type : "POST",
            dataType: "json",
            data : {
                userId: reuserId,
                atuserId: atuserId,
                postId: post,
                commentId: commentId,
                content: content,
            },
            success:function(result) {
                if (result && result['success']) {
                    // 验证通过 刷新页面
                    window.location.reload();
                } else {
                    console.log(result.message);
                }
            },
            error:function(result){
                console.log(result.message);
            }
        });
    },
    addGood:function () {
        $('#good').css('color', 'red');
        var userId = discussDetailPage.data.userId;
        var post = discussDetailPage.data.post;
        // $.ajax({
        //     url: "/discuss/api/addGood",
        //     type : "POST",
        //     dataType: "json",
        //     contentType : "application/json;charset=UTF-8",
        //     data : JSON.stringify({
        //         accountId: userId,
        //         postId: post.id,
        //     }),
        //     success: function (data) {
        //         window.location.reload();
        //     },
        //     error: function () {
        //         alert("获取数据出错!");
        //     },
        // });
    },
    increaseViewCount: function(articleId) {
        if ($.cookie("viewId") != discussDetailPage.data.post.id || $.cookie("viewId") == null) {
            // $.ajax({
            //     async: false,
            //     type: "GET",
            //     url: app.URL.addViewUrl() + discussDetailPage.data.post.id,
            //     success: function (data) {
            //         console.log(data);
            //         $(".articleViewCount").html(data);
            //         $.cookie(
            //             "viewId",
            //             articleId,//需要cookie写入的业务
            //             {
            //                 "path": "/", //cookie的默认属性
            //             }
            //         );
            //     },
            //     error: function () {
            //         // alert("获取数据出错!");
            //     },
            // });
        }
    },
};