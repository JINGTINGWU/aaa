/**
 * 重新整理網頁, 依不同瀏覽器來決定語法, 讓垂直捲軸保持在原位
 */
function pagereload()
{
	var Sys = {};
	var ua = navigator.userAgent.toLowerCase();
	var s;
	(s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] : 
		(s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] : 
			(s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] : 
				(s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] : 
					(s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
	if (Sys.ie) history.go(0);
	if (Sys.firefox) location.reload();
	if (Sys.chrome) location.reload();
	if (Sys.opera) location.reload();
	if (Sys.safari) location.reload();
}
