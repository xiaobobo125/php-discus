/**
 * 模块JavaScript
 */
var discussPage = {
    data:{
        pageNum: 0,
        pageSize: 0,
        totalPageNum: 0,
        totalPageSize: 0,
        posts: [],
    },
    init: function (pageNum, pageSize, totalPageNum, totalPageSize, posts) {
        discussPage.data.pageNum = pageNum;
        discussPage.data.pageSize = pageSize;
        discussPage.data.totalPageNum = totalPageNum;
        discussPage.data.totalPageSize = totalPageSize;
        discussPage.data.posts = posts;
        //分页初始化
        discussPage.subPageMenuInit();
    },
};