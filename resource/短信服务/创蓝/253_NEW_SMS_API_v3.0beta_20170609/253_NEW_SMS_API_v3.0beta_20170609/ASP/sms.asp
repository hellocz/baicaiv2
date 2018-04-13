<%@LANGUAGE="VBSCRIPT" CODEPAGE="65001"%>
<%
Function Post(url,data)
	dim Https 
	set Https=server.createobject("MSXML2.XMLHTTP")
	Https.open "POST",url,false
	Https.setRequestHeader "Content-Type","application/json"
	Https.send data
	if Https.readystate=4 then
		dim objstream 
		set objstream = Server.CreateObject("adodb.stream")
		objstream.Type = 1
		objstream.Mode =3
		objstream.Open
		objstream.Write Https.responseBody
		objstream.Position = 0
		objstream.Type = 2
		objstream.Charset = "utf-8"
		Post = objstream.ReadText
		objstream.Close
		set objstream = nothing
		set https=nothing
	end if
End Function

dim target,post_data
''//请求地址请登录253云通讯自助通平台查看或者询问您的商务负责人获取
target = "http://xxx/msg/send/json"  
post_data="{""account"":""zensen"",""password"":""a."",""phone"":""18721755342"",""msg"":""Server.URLEncode(【253云通讯】您好，您的验证码是999999)"",""report"":""false""}"
response.Write(Post(target,post_data))
''//请自己解析Post(target,post_data)返回的json格式并实现自己的逻辑
%>