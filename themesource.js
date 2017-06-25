if (document.cookie.indexOf("theme=") < 0)
{
        document.cookie = "theme=default.css";
}
var defaulttheme = document.getElementsByTagName("link").item(0);
var cookies = document.cookie;
var themeonward = cookies.substring(cookies.indexOf("theme=")) + ';';
var themecookie = themeonward.substring(6, themeonward.indexOf(';'));
if (themecookie != ';')
{
	defaulttheme.href = "config/themes/" + themecookie;
}
