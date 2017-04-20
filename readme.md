

### Laravel 5.1 微信APP支付 扩展使用教程

# wechat-pay-app
    微信APP支付-服务器端PHP SDK 
    精简的SDK代码,方便程序扩展使用
    官方文档说明: https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1
    微信APP支付流程: 服务器端下单 -> 生成预支付参数 -> APP通过预支付调起客户端支付
# 使用示例
### 生成APP支付参数示例代码

```
composer require yuxiaoyang/appwxpay
```

或者在你的 `composer.json` 的 require 部分中添加:
```json
 "yuxiaoyang/appwxpay": "~1.0"
```

下载完毕之后,直接配置 `config/app.php` 的 `providers`:

```php
//Illuminate\Hashing\HashServiceProvider::class,

Yuxiaoyang\Appwxpay\AppwxpayProvider::class,
```
控制器中使用 `AppwxpayController.php` :


```php

<?php


use \Yuxiaoyang\Appwxpay\Appwxpay;

class AppwxpayController extends Controller
{
    
    public $appwxpay;

    //获取支付报文json数据
    public function appwxpay()
    {

        //初始化配置参数
        $options = array(
            'appid'=>'******************',//填写微信分配的公众账号ID
            'mch_id'=>'**********',//填写微信支付分配的商户号
            'notify_url'=>'http://www.******.com/appwx/notify',//填写微信支付结果回调地址
            'key'=>'***********'//填写微信商户支付密钥
        );

        //创建示例对象
        $this->appwxpay = new Appwxpay($options);

        //设置下单参数
        $params['body'] = '商品描述';//商品描述
        $params['out_trade_no'] = rand(1000000000000000,9999999999999999);	//自定义的订单号
        $params['total_fee'] = '100';	//订单金额 只能为整数 单位为分
        $params['trade_type'] = 'APP';	//交易类型 APP

        //请求微信【统一下单】接口,成功会返回 预支付交易会话标识 prepay_id
        $result = $this->appwxpay->unifiedOrder($params);
        //dd($result);
        if(isset($result['prepay_id'])){
            //生成APP端调起支付所需的参数
            $data = $this->appwxpay->getAppPayParams($result['prepay_id']);
            return $data;
        }else{
            return $result;
        }

    }


}
