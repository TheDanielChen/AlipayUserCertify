支付宝身份认证是支付宝根据用户信息返回风控风险以及用户信用评分，主要用于：`P2P网贷`,`租车`,`共享经济信用评分`,`旅行或者酒店类`等中，支付宝身份认证接口比较多，如果自己单独去开发，会浪费一定的时间，所以我集成了Laravel支付宝身份认证拓展，方便大家学习管理，如果由任何疑问，欢迎

#### 开发前的准备
1. 安装Laravel
1. 申请通过蚂蚁金服开放平台（open.alipay.com）
1. 创建一个应用并且获取基本配置信息，详细流程[开始接入](https://docs.open.alipay.com/20181012100420932508/quickstart/)

#### 安装拓展
1.在 `composer.json` 的 `require` 里面加入以下内容：
```composer
composer require "cstopery/alipay-user-certify:dev-master"
```

2.等待下载安装完成，需要在`config/app.php`中注册服务提供者同时注册下相应门面：
```php
'providers' => [
    //........
    Cstopery\AlipayUserCertify\AlipayUserCertifyServiceprovider::class,
],

'aliases' => [
    //..........
    'AlipayUserCertify'      => Cstopery\AlipayUserCertify\Facades\AlipayUserCertify::class,
],
```
服务注入以后，如果要使用自定义的配置，还可以发布配置文件到config目录：
```composer
php artisan vendor:publish
```

#### 使用方法

#### 支付宝认证

##### 1、支付宝认证初始化
```php
AlipayUserCertify::ZhimaCustomerCertificationInitialize("name","idcard");
```
请求参数：
- `name`代表用户姓名
- `idcard`代表身份证号码
返回参数：
```php
{
  "success"=>true,
  "certify_id"=>"ZM2017123123123123100500333662",
}
```
```html
https://docs.open.alipay.com/api_2/alipay.user.certify.open.initialize/
```
##### 2、支付宝认证开始认证
```php
AlipayUserCertify::ZhimaCustomerCertificationCertify($certify_id,$returnurl);
```
请求参数：
- `certify_id`为上一部中获取到的`certify_id`
- `returnurl`代表验证后转到的网址，可在下一步中获取参数
返回参数：
```html
https://docs.open.alipay.com/api_2/alipay.user.certify.open.certify/
```
将会返回授权链接，你将链接设置为a标签，给用户点击使用，注意：授权成功以后会返回您授权的地址，将会给你返回`$sign`和`$params`参数用于下面的获取参数

##### 3、根据获取的`$params`解密验签
```php
AlipayUserCertify::getResult($params,$sign);
```
本步也为第二步认证后返回结果，解密获取到基本参数,到这里可以存储，后期长期使用查询

参数说明：
- $params为上一部中授权返回的参数
- $sign为上一部中授权返回的参数

返回参数：
```php
[
  "passed" => "true",
  "certify_id" => "ZM201708023000000123400501230048",
]
```
##### 4、支付宝认证查询
```php
AlipayUserCertify::ZhimaCustomerCertificationQuery($certify_id);
```
请求参数：
- `certify_id`为上一部中验证后解密验签获取到的`certify_id`

返回参数：[参数说明](https://docs.open.alipay.com/api_2/alipay.user.certify.open.query/)
```php
{
  "success"=>true
  "channel_statuses"=>"[{"name"=>"FACE","status"=>"PASS"}]"
  "identity_info"=>"{"cert_name"=>"姓名","cert_no"=>"身份证","cert_type"=>"IDENTITY_CARD"}"
  "passed"=>"true"
}
```


好的，到这里全部接口完毕，注意：`open_id`，`certify_id`可以长期使用，做好留存，除非用户取消授权或者重新授权；后期会持续迭代，欢迎讨论以及给星！