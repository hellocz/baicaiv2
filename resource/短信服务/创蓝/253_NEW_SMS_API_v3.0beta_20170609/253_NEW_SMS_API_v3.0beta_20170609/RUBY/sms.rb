# 说明：
# 以下代码只是为了方便客户测试而提供的示例代码，客户可以根据自己的需要另行编写
# 该代码仅供学习和研究接口使用，只是提供了一个参考

require 'net/http'  
require 'uri'  
require 'json'  
  
params = {  
    "account" => "",  
    "password" => "a.123456",  
    "phone" => "18721755342",   
    "msg" =>URI::escape("【253云通讯】您好，您的验证码是999999") 
}.to_json  
  
def send_data(url,data)  
    url = URI.parse(url)  
    req = Net::HTTP::Post.new(url.path,{'Content-Type' => 'application/json'})  
    req.body = data  
    res = Net::HTTP.new(url.host,url.port).start{|http| http.request(req)}  
  
    puts res.body                                                                                                  
end  
#请求地址请登录253云通讯自助通平台查看或者询问您的商务负责人获取
send_data('http://xxx/msg/send/json',params) 