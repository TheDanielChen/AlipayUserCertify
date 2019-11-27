<?php 
namespace Cstopery\AlipayUserCertify;

//use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Cstopery\AlipayUserCertify\Libarys\Zmop\ZmopClient;
use Cstopery\AlipayUserCertify\Libarys\Zmop\AopClient;

// use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\ZhimaCreditScoreGetRequest;
// use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\ZhimaAuthInfoAuthorizeRequest;
// use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\ZhimaCreditWatchlistiiGetRequest;
// use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\ZhimaCreditAntifraudScoreGetRequest;
// use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\ZhimaCreditAntifraudVerifyRequest;
// use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\ZhimaCreditAntifraudRiskListRequest;
use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayUserCertifyOpenQueryRequest;
use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayUserCertifyOpenInitializeRequest;
use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayUserCertifyOpenCertifyRequest;
use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayFundAuthOrderAppFreezeRequest;
use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayFundAuthOrderUnfreezeRequest;
use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayFundAuthOperationDetailQueryRequest;
use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayTradePayRequest;
// use Cstopery\AlipayUserCertify\Libarys\Zmop\Request\AlipayTradeAppPayRequest;


class AlipayUserCertify
{
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */

    // 支付宝身份认证评分
    // public function ZhimaCreditScoreGetRequest($open_id)
    // {
    //     $config=Config::get("AlipayUserCertify.AlipayUserCertify");
    //     $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
    //     $request = new ZhimaCreditScoreGetRequest();
    //     $request->setChannel("apppc");
    //     $request->setPlatform("zmop");
    //     // transactionid需要自己生成的，保证每次请求唯一
    //     $request->setTransactionId(rand(100000000000000,999999999999999));// 必要参数 
    //     // 产品码是写死的
    //     $request->setProductCode("w1010100100000000001");// 必要参数 
    //     $request->setOpenId($open_id);// 必要参数 
    //     $response = $client->execute($request);
    //     return $response;
    // }

    // 支付宝身份认证参数解析
    public function getResult($params,$sign) {
        //从回调URL中获取sign参数，此处为示例值
        // 判断串中是否有%，有则需要decode
        $config=Config::get("AlipayUserCertify.AlipayUserCertify");
        $params = strstr($params,'%')?urldecode($params):$params;
        $sign = strstr($sign,'%')?urldecode($sign):$sign;
        
        $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
        $result = $client->decryptAndVerifySign($params, $sign);
        parse_str(@array_pop(explode('?', $result)), $a);
        return $a;
    }

    // 页面授权
//    public function ZhimaAuthInfoAuthorize($name,$idcard){
//        $config=Config::get("AlipayUserCertify.AlipayUserCertify");
//        $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
//        $request = new ZhimaAuthInfoAuthorizeRequest();
//        $request->setChannel("apppc");
//        $request->setPlatform("zmop");
//        $request->setIdentityType("2");// 必要参数
//        $request->setIdentityParam(json_encode(array("name"=>$name,"certType"=>"IDENTITY_CARD","certNo"=>$idcard)));// 必要参数
//        $request->setBizParams(json_encode(array("auth_code"=>"M_H5","channelType"=>"app","state"=>$idcard)));//
//        $url = $client->generatePageRedirectInvokeUrl($request);
//        return $url;
//    }

    // 行业关注名单
    // public function ZhimaCreditWatchlistiiGet($open_id){
    //     $config=Config::get("AlipayUserCertify.AlipayUserCertify");
    //     $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
    //     $request = new ZhimaCreditWatchlistiiGetRequest();
    //     $request->setChannel("apppc");
    //     $request->setPlatform("zmop");
    //     $request->setProductCode("w1010100100000000022");// 必要参数 
    //     $request->setTransactionId(rand(100000000000000,999999999999999));// 必要参数 
    //     $request->setOpenId($open_id);// 必要参数 
    //     $response = $client->execute($request);
    //     return $response;
    // }

    // 申请欺诈评分
    // public function ZhimaCreditAntifraudScoreGet($data){
    //     $config=Config::get("AlipayUserCertify.AlipayUserCertify");
    //     $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
    //     $request = new ZhimaCreditAntifraudScoreGetRequest();
    //     $request->setChannel("apppc");
    //     $request->setPlatform("zmop");
    //     $request->setProductCode("w1010100003000001100");// 必要参数 
    //     $request->setTransactionId(rand(100000000000000,999999999999999));// 必要参数 
    //     $request->setCertType("IDENTITY_CARD");// 必要参数 
    //     $request->setCertNo($data["idcard"]);// 必要参数 
    //     $request->setName($data["name"]);// 必要参数 
    //     $request->setMobile($data["phone"]);// 
    //     $request->setEmail($data["email"]);// 
    //     $request->setBankCard($data["bankcard"]);// 
    //     $request->setAddress($data["address"]);// 
    //     $request->setIp($data["ip"]);// ip地址
    //     $request->setMac($data["mac"]);// 物理地址
    //     $request->setWifimac($data["wifimac"]);// 
    //     $request->setImei($data["imei"]);// 
    //     $response = $client->execute($request);
    //     return $response;
    // }

    // 欺诈信息验证
    // public function ZhimaCreditAntifraudVerify($data){
    //     $config=Config::get("AlipayUserCertify.AlipayUserCertify");
    //     $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
    //     $request = new ZhimaCreditAntifraudVerifyRequest();
    //     $request->setChannel("apppc");
    //     $request->setPlatform("zmop");
    //     $request->setProductCode("w1010100000000002859");// 必要参数 
    //     $request->setTransactionId(rand(100000000000000,999999999999999));// 必要参数 
    //     $request->setCertType("IDENTITY_CARD");// 必要参数 
    //     $request->setCertNo($data["idcard"]);// 必要参数 
    //     $request->setName($data["name"]);// 必要参数 
    //     $request->setMobile($data["phone"]);// 
    //     $request->setEmail($data["email"]);// 
    //     $request->setBankCard($data["bankcard"]);// 
    //     $request->setAddress($data["address"]);// 
    //     $request->setIp($data["ip"]);// ip地址
    //     $request->setMac($data["mac"]);// 物理地址
    //     $request->setWifimac($data["wifimac"]);// 
    //     $request->setImei($data["imei"]);// 
    //     $response = $client->execute($request);
    //     return $response;
    // }

    // 欺诈关注清单
    // public function ZhimaCreditAntifraudRiskList($data){
    //     $config=Config::get("AlipayUserCertify.AlipayUserCertify");
    //     $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
    //     $request = new ZhimaCreditAntifraudRiskListRequest();
    //     $request->setChannel("apppc");
    //     $request->setPlatform("zmop");
    //     $request->setProductCode("w1010100003000001283");// 必要参数 
    //     $request->setTransactionId(rand(100000000000000,999999999999999));// 必要参数 
    //     $request->setCertType("IDENTITY_CARD");// 必要参数 
    //     $request->setCertNo($data["idcard"]);// 必要参数 
    //     $request->setName($data["name"]);// 必要参数 
    //     $request->setMobile($data["phone"]);// 
    //     $request->setEmail($data["email"]);// 
    //     $request->setBankCard($data["bankcard"]);// 
    //     $request->setAddress($data["address"]);// 
    //     $request->setIp($data["ip"]);// ip地址
    //     $request->setMac($data["mac"]);// 物理地址
    //     $request->setWifimac($data["wifimac"]);// 
    //     $request->setImei($data["imei"]);// 
    //     $response = $client->execute($request);
    //     return $response;
    // }
    
    // 支付宝认证查询
    public function ZhimaCustomerCertificationQuery($bizno){
        $config=Config::get("AlipayUserCertify.AlipayUserCertify");

        $aop = new AopClient();
        $aop->gatewayUrl = $config["gatewayUrl"];
        $aop->appId = $config["appId"];
        $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
        $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset=$config["charset"];
        $aop->format='json';
        $request = new AlipayUserCertifyOpenQueryRequest ();

        $bizCon = [
            'certify_id'=>$bizno
        ];

        $request->setBizContent(json_encode($bizCon,true));
        $obj = $aop->execute( $request); 


        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if($obj->$responseNode){
            return $obj->$responseNode;

        }

        return null;

        foreach ($obj as $paraKey => $paraValue) {
			//如果属性名以_reponse结尾，该属性对应的值为业务返回值
			if(strrchr($paraKey, "_response") == "_response"){
				return $paraValue;
			}
		}
        return null;



        $config=Config::get("AlipayUserCertify.AlipayUserCertify");
        $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
        $request = new AlipayUserCertifyOpenQueryRequest();
        // $request->setChannel("apppc");
        // $request->setPlatform("zmop");
        $request->setCertifyId($bizno);// 必要参数 
        $response = $client->execute($request);
        return $response;
    }

    // 支付宝认证初始化
    public function ZhimaCustomerCertificationInitialize($name,$idcard){
        $config=Config::get("AlipayUserCertify.AlipayUserCertify");

        // var_dump($config);
        $aop = new AopClient();
        $aop->gatewayUrl = $config["gatewayUrl"];
        $aop->appId = $config["appId"];
        $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
        $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset=$config["charset"];
        $aop->format='json';

        $request = new AlipayUserCertifyOpenInitializeRequest();

        $bizCon = [
            'outer_order_no' => strval(rand(100000000000000,999999999999999)),
            'biz_code' => 'FACE',
            'identity_param'=>['identity_type'=>'CERT_INFO','cert_type'=>'IDENTITY_CARD','cert_name'=>$name,'cert_no'=>$idcard],
            'merchant_config'=>['return_url'=>$config['authReturnUrl']]
        ];


        $request->setBizContent(json_encode($bizCon,true));
        $obj = $aop->execute ( $request); 

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if($obj->$responseNode){
            return $obj->$responseNode;

        }

        return null;


        foreach ($obj as $paraKey => $paraValue) {
			//如果属性名以_reponse结尾，该属性对应的值为业务返回值
			if(strrchr($paraKey, "_response") == "_response"){
				return $paraValue;
			}
		}
        return null;
        

        // old code 
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }

        $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
        $request = new AlipayUserCertifyOpenInitializeRequest();
        // $request->setChannel("apppc");
        // $request->setPlatform("zmop");
        // $request->setOuterOrderNo(rand(100000000000000,999999999999999));// 必要参数 
        // $request->setProductCode("w1010100000000002978");// 必要参数 
        $request->setBizCode("FACE");// 必要参数 
        $request->setIdentityParam(json_encode(array("identity_type"=>"CERT_INFO","cert_type"=>"IDENTITY_CARD","cert_name"=>$name,"cert_no"=>$idcard)));
        // 必要参数 
        $request->setMerchantConfig("{\"return_url\":\"".$config['authReturnUrl']."\"}");// 
        // $request->setExtBizParam("{}");// 必要参数 
        $response = $client->execute($request);
        return $response;
    }

    // 支付宝认证开始认证
    public function ZhimaCustomerCertificationCertify($bizno,$returnurl){
        $config=Config::get("AlipayUserCertify.AlipayUserCertify");

        $aop = new AopClient();
        $aop->gatewayUrl = $config["gatewayUrl"];
        $aop->appId = $config["appId"];
        $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
        $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset=$config["charset"];
        $aop->format='json';
        $request = new AlipayUserCertifyOpenCertifyRequest ();

        $bizCon = [
            'certify_id'=>$bizno
        ];

        $request->setBizContent(json_encode($bizCon,true));
        $obj = $aop->pageExecute( $request,'GET'); 

        return $obj;


        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if($obj->$responseNode){
            return $obj->$responseNode;

        }

        return null;

        $client = new ZmopClient($config["gatewayUrl"],$config["appId"],$config["charset"],$config["privateKeyFile"],$config["zmPublicKeyFile"]);
        $request = new AlipayUserCertifyOpenCertifyRequest();
        // $request->setChannel("apppc");
        // $request->setPlatform("zmop");
        $request->setCertifyId($bizno);// 必要参数 
        $request->setReturnUrl($returnurl);// 必要参数 
        $url = $client->generatePageRedirectInvokeUrl($request);
        return $url;
    }

    // 支付宝预授权
    public function AlipayFundAuthOrderAppFreeze($order_no,$total_price){

        $config=Config::get("AlipayUserCertify.AlipayUserCertify");

        $aop = new AopClient();
        $aop->gatewayUrl = $config["gatewayUrl"];
        $aop->appId = $config["appId"];
        $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
        $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset=$config["charset"];
        $aop->format='json';
        $aop->notifyUrl = $config["freeze_notify_url"];  // 注意这里要传 notifyUrl

        $request = new AlipayFundAuthOrderAppFreezeRequest();

        $bizCon = [

            'out_order_no'          =>  $order_no,  //商户订单号
            'out_request_no'        =>  $order_no.rand(100,999),  //请求流水号
            'order_title'           =>  '芝麻信用预授权冻结',        
            'amount'                =>  $total_price,  //预授权金额
            'product_code'          =>  'PRE_AUTH_ONLINE', //固定
            //'payee_logon_id'        =>  '15307124426',
            'payee_user_id'         =>  $config['pid'],  // payee_user_id  请传入  appid对应的pid
            'extra_param'           => '{"category":"TRAD_RENT_CAR"}',

        ];

        $request->setNotifyUrl($config["freeze_notify_url"]);


        $request->setBizContent(json_encode($bizCon,true));
        $obj = $aop->sdkExecute($request); 

        return $obj;

    }

    // 授权转支付
    public function AlipayTradePay($order_no,$total_price,$buyer_id,$auth_no,$mode=''){

        $config=Config::get("AlipayUserCertify.AlipayUserCertify");

        // var_dump($config);
        $aop = new AopClient();
        $aop->gatewayUrl = $config["gatewayUrl"];
        $aop->appId = $config["appId"];
        $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
        $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset=$config["charset"];
        $aop->format='json';

        $request = new AlipayTradePayRequest();

        $bizCon = [

            'out_trade_no'          =>  $order_no.rand(100,999),  //商户订单号
            'total_amount'          =>  $total_price,  //预授权金额
            'product_code'          =>  'PRE_AUTH_ONLINE', //固定
            'subject'               =>  '预授权转支付',        
            'buyer_id'              =>  $buyer_id,  
            'seller_id'             =>  $config['pid'], //固定
            'auth_no'               =>  $auth_no,
            'body'                  =>  '预授权转支付',
            //'auth_confirm_mode'     =>  'COMPLETE',  //auth_confirm_mode传入COMPLETE，无需调用解冻接口，支付宝端在扣款成功后会自动解冻剩余金额

        ];

        if($mode == 'COMPLETE'){
            $bizCon['auth_confirm_mode'] = 'COMPLETE';
        }

        $request->setBizContent(json_encode($bizCon,true));
        $obj = $aop->execute ( $request); 

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if($obj->$responseNode){
            return $obj->$responseNode;

        }

        return null;


    }

        // 支付宝预授权解冻
    public function AlipayFundAuthOrderUnFreeze($order_no,$auth_no,$total_price,$auth_mode=''){

        $config=Config::get("AlipayUserCertify.AlipayUserCertify");

        $aop = new AopClient();
        $aop->gatewayUrl = $config["gatewayUrl"];
        $aop->appId = $config["appId"];
        $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
        $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset=$config["charset"];
        $aop->format='json';
        // $aop->notifyUrl = $config["freeze_notify_url"];  // 注意这里要传 notifyUrl

        $request = new AlipayFundAuthOrderUnfreezeRequest();

        $bizCon = [

            'auth_no'          =>  $auth_no,  //授权单号
            'out_request_no'        =>  $order_no,  //请求流水号
            'remark'           =>  '预授权解冻',        
            'amount'                =>  $total_price,  //解冻预授权金额  

        ];

        if($auth_mode == 'CREDIT_AUTH'){//若订单为信用全免订单，extraParam必须传入
            $bizCon['extra_param'] = '{"unfreezeBizInfo":"{"bizComplete":"true"}"}';
        }

        // $request->setNotifyUrl($config["freeze_notify_url"]);

        $request->setBizContent(json_encode($bizCon,JSON_UNESCAPED_UNICODE));
        $obj = $aop->execute ( $request); 

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if($obj->$responseNode){
            return $obj->$responseNode;

        }

        return null;

    }

    // 支付宝预授权查询接口
    public function AlipayFundAuthOperationDetailQuery($auth_no,$operation_id){

        $config=Config::get("AlipayUserCertify.AlipayUserCertify");

        $aop = new AopClient();
        $aop->gatewayUrl = $config["gatewayUrl"];
        $aop->appId = $config["appId"];
        $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
        $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset=$config["charset"];
        $aop->format='json';
        // $aop->notifyUrl = $config["freeze_notify_url"];  // 注意这里要传 notifyUrl

        $request = new AlipayFundAuthOperationDetailQueryRequest();

        $bizCon = [

            'auth_no'          =>  $auth_no,  //授权单号
            'operation_id'        =>  $operation_id,  //请求流水号
            // 'remark'           =>  '预授权解冻',        
            // 'amount'                =>  $total_price,  //解冻预授权金额  

        ];


        // $request->setNotifyUrl($config["freeze_notify_url"]);

        $request->setBizContent(json_encode($bizCon,true));
        $obj = $aop->execute ( $request); 

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

        if($obj->$responseNode){
            return $obj->$responseNode;

        }

        return null;

    }

    //先支付后签约场景
    // public function AlipayTradeAppPay($order_no,$total_price){
    //     $config=Config::get("AlipayUserCertify.AlipayUserCertify");

    //     // var_dump($config);
    //     $aop = new AopClient();
    //     $aop->gatewayUrl = $config["gatewayUrl"];
    //     $aop->appId = $config["appId"];
    //     $aop->rsaPrivateKey = file_get_contents($config["privateKeyFile"]);
    //     $aop->alipayrsaPublicKey=file_get_contents($config["zmPublicKeyFile"]);
    //     $aop->apiVersion = '1.0';
    //     $aop->signType = 'RSA2';
    //     $aop->postCharset=$config["charset"];
    //     $aop->format='json';
    //     $aop->notify_url = $config["agreement_notify_url"];


    //     $request = new AlipayTradeAppPayRequest();

    //     $bizCon = [

    //         'out_trade_no'          =>  $order_no,  //商户订单号
    //         'total_amount'          =>  $total_price,  //预授权金额
    //         'product_code'          =>  'QUICK_MSECURITY_PAY', //固定
    //         'subject'               =>  '先支付后签约',        
    //         'agreement_sign_params' =>[
    //                 'personal_product_code' => 'CYCLE_PAY_AUTH_P',
    //                 'sign_scene'    => 'INDUSTRY|CARRENTAL',
    //                 'external_agreement_no' => $order_no,
    //                 'access_params' => [
    //                         'channel' => 'ALIPAYAPP'
    //                 ],
    //                 'period_rule_params' => [
    //                         'period_type' => 'MONTH',
    //                         'period' => 1,

    //                 ],
    //         ],

    //     ];

    //     $request->setBizContent(json_encode($bizCon,true));
    //     $obj = $aop->execute ( $request); 

    //     $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

    //     if($obj->$responseNode){
    //         return $obj->$responseNode;

    //     }

    //     return null;
    // }


}