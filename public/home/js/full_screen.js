    // 设置全屏
$('#alarm-fullscreen-toggler').on('click', function (e) {
    var element = document.documentElement;     // 返回 html dom 中的root 节点 <html>
    
    if(!$('body').hasClass('full-screen')) {
        $('body').addClass('full-screen');
        $('#alarm-fullscreen-toggler').addClass('active');
        // 判断浏览器设备类型
        if(element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen){   // 兼容火狐
            element.mozRequestFullScreen();
        } else if(element.webkitRequestFullscreen) {    // 兼容谷歌
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {   // 兼容IE
            element.msRequestFullscreen();
        }
        // 切换全屏按钮
        $('#alarm-fullscreen-toggler').attr('src','/home/images/close.png');
    } else {            // 退出全屏
        console.log(document);
        $('body').removeClass('full-screen');
        $('#alarm-fullscreen-toggler').removeClass('active');
        //  退出全屏
        if(document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
        // 切换全屏按钮
        $('#alarm-fullscreen-toggler').attr('src','/home/images/open.png');
    }
});