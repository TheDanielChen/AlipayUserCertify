<?php
return [
    "AlipayUserCertify" => [
        //支付宝身份认证网关地址
        "gatewayUrl" => "https://openapi.alipay.com/gateway.do",
        //商户私钥文件
        "privateKeyFile" => "/var/www/test/app/Libarys/Zhima/keys/private_key.pem",
        //芝麻公钥文件,参考：https://b.zmxy.com.cn/technology/openDoc.htm?relInfo=RSA_INFO_DOC
        "zmPublicKeyFile" => "/var/www/test/app/Libarys/Zhima/keys/public_key.pem",
        //数据编码格式
        "charset" => "UTF-8",
        //芝麻分配给商户的 appId
        "appId" => "1000000",
    ],

    // 欺诈验证
    "qzyz" => [
        "V_CN_NA"=>"查询不到身份证信息",
        "V_CN_NM_UM"=>"姓名与身份证号不匹配",
        "V_CN_NM_MA"=>"姓名与身份证号匹配",
        "V_PH_NA"=>"查询不到电话号码信息",
        "V_PH_CN_UM"=>"电话号码与本人不匹配",
        "V_PH_CN_MA_UL30D"=>"电话号码与本人匹配，30天内有使用",
        "V_PH_CN_MA_UL90D"=>"电话号码与本人匹配，90天内有使用",
        "V_PH_CN_MA_UL180D"=>"电话号码与本人匹配，180天内有使用",
        "V_PH_CN_MA_UM180D"=>"电话号码与本人匹配，180天内没有使用",
        "V_PH_NM_UM"=>"电话号码与姓名不匹配",
        "V_PH_NM_MA_UL30D"=>"电话号码与姓名匹配，30天内有使用",
        "V_PH_NM_MA_UL90D"=>"电话号码与姓名匹配，90天内有使用",
        "V_PH_NM_MA_UL180D"=>"电话号码与姓名匹配，180天内有使用",
        "V_PH_NM_MA_UM180D"=>"电话号码与姓名匹配，180天内没有使用",
        "V_EM_CN_UK"=>"EMAIL与本人关系未知",
        "V_EM_CN_UM"=>"EMAIL与本人不匹配",
        "V_EM_CN_MA"=>"EMAIL与本人匹配",
        "V_EM_PH_UK"=>"EMAIL与手机号码关系未知",
        "V_EM_PH_UM"=>"EMAIL与手机号码不匹配",
        "V_EM_PH_MA"=>"EMAIL与手机号码匹配",
        "V_BC_CN_UK"=>"银行卡号与本人关系未知",
        "V_BC_CN_UM"=>"银行卡号与本人不匹配",
        "V_BC_CN_MA_UL180D"=>"银行卡号与本人匹配，180天内有使用",
        "V_BC_CN_MA_UL360D"=>"银行卡号与本人匹配，360天内有使用",
        "V_BC_CN_MA_UM360D"=>"银行卡号与本人匹配，360天内没有使用",
        "V_BC_PH_UK"=>"银行卡号与手机号码关系未知",
        "V_BC_PH_UM"=>"银行卡号与手机号码不匹配",
        "V_BC_PH_MA_UL180D"=>"银行卡号与手机号码匹配，180天内有使用",
        "V_BC_PH_MA_UL360D"=>"银行卡号与手机号码匹配，360天内有使用",
        "V_BC_PH_MA_UM360D"=>"银行卡号与手机号码匹配，360天内没有使用",
        "V_AD_CN_UK"=>"地址与本人关系未知",
        "V_AD_CN_UM"=>"地址与本人不匹配",
        "V_AD_CN_MA_UL180D"=>"地址与本人匹配，180天内有使用",
        "V_AD_CN_MA_UL360D"=>"地址与本人匹配，360天内有使用",
        "V_AD_CN_MA_UM360D"=>"地址与本人匹配，360天内没有使用",
        "V_AD_PH_UK"=>"地址与手机号码关系未知",
        "V_AD_PH_UM"=>"地址与手机号码不匹配",
        "V_AD_PH_MA_UL180D"=>"地址与手机号码匹配，180天内有使用",
        "V_AD_PH_MA_UL360D"=>"地址与手机号码匹配，360天内有使用",
        "V_AD_PH_MA_UM360D"=>"地址与手机号码匹配，360天内没有使用",
        "V_MC_CN_UK"=>"MAC与本人关系未知",
        "V_MC_CN_UM"=>"MAC与本人不匹配",
        "V_MC_CN_MA"=>"MAC与本人匹配",
        "V_MC_PH_UK"=>"MAC与手机号码关系未知",
        "V_MC_PH_UM"=>"MAC与手机号码不匹配",
        "V_MC_PH_MA"=>"MAC与手机号码匹配",
        "V_IP_CN_UK"=>"IP与本人关系未知",
        "V_IP_CN_UM"=>"IP与本人不匹配",
        "V_IP_CN_MA"=>"IP与本人匹配",
        "V_IP_PH_UK"=>"IP与手机号码关系未知",
        "V_IP_PH_UM"=>"IP与手机号码不匹配",
        "V_IP_PH_MA"=>"IP与手机号码匹配",
        "V_IM_CN_UK"=>"IMEI与本人关系未知",
        "V_IM_CN_UM"=>"IMEI与本人不匹配",
        "V_IM_CN_MA"=>"IMEI与本人匹配",
        "V_IM_PH_UK"=>"IMEI与手机号码关系未知",
        "V_IM_PH_UM"=>"IMEI与手机号码不匹配",
        "V_IM_PH_MA"=>"IMEI与手机号码匹配",
        "V_WF_CN_UK"=>"WIFI-MAC与本人关系未知",
        "V_WF_CN_UM"=>"WIFI-MAC与本人不匹配",
        "V_WF_CN_MA"=>"WIFI-MAC与本人匹配",
        "V_WF_PH_UK"=>"WIFI-MAC与手机号码关系未知",
        "V_WF_PH_UM"=>"WIFI-MAC与手机号码不匹配",
        "V_WF_PH_MA"=>"WIFI-MAC与手机号码匹配",
    ],

    // 关注清单
    "gzqd" => [
        "R_CN_001"=>["身份证号击中网络欺诈风险名单","中风险"],
        "R_CN_002"=>["身份证号曾经被泄露","低风险"],
        "R_CN_003"=>["身份证号曾经被冒用","低风险"],
        "R_CN_004"=>["身份证号出现在风险关联网络","低风险"],
        "R_CN_JJ_01"=>["身份证当天在多个商户申请","中风险"],
        "R_CN_JJ_02"=>["身份证近一周（不包含当天）在多个商户申请","中风险"],
        "R_CN_JJ_03"=>["身份证近一月（不包含当天）在多个商户申请","中风险"],
        "R_PH_001"=>["手机号击中网络欺诈风险名单","中风险"],
        "R_PH_002"=>["手机号疑似多个用户共用","低风险"],
        "R_PH_003"=>["手机号疑似虚拟运营商小号","中风险"],
        "R_PH_004"=>["手机号疑似二次放号","高风险"],
        "R_PH_005"=>["手机失联风险高","高风险"],
        "R_PH_006"=>["手机稳定性弱","低风险"],
        "R_PH_JJ_01"=>["手机号当天在多个商户申请","中风险"],
        "R_PH_JJ_02"=>["手机号近一周（不包含当天）在多个商户申请","中风险"],
        "R_PH_JJ_03"=>["手机号近一月（不包含当天）在多个商户申请","中风险"],
        "R_BC_001"=>["银行卡击中网络欺诈风险名单","中风险"],
        "R_BC_002"=>["银行卡曾经被泄露","低风险"],
        "R_BC_003"=>["银行卡曾经被冒用","低风险"],
        "R_AD_001"=>["疑似虚假地址","低风险"],
        "R_MC_001"=>["疑似山寨手机MAC","中风险"],
        "R_MC_002"=>["MAC击中网络欺诈风险名单","中风险"],
        "R_MC_003"=>["手机MAC近期内不活跃","低风险"],
        "R_MC_004"=>["手机MAC较新  ","低风险"],
        "R_MC_005"=>["恶意攻击MAC","中风险"],
        "R_MC_006"=>["疑似中介MAC","中风险"],
        "R_MC_JJ_01"=>["当天多个用户通过该MAC申请","中风险"],
        "R_MC_JJ_02"=>["近一周（不包含当天）多个用户通过该MAC申请","中风险"],
        "R_MC_JJ_03"=>["近一月（不包含当天）多个用户通过该MAC申请","中风险"],
        "R_IP_001"=>["代理IP","中风险"],
        "R_IP_002"=>["服务器IP","低风险"],
        "R_IP_003"=>["热点IP","低风险"],
        "R_IP_004"=>["IP近期不活跃 ","低风险"],
        "R_IP_005"=>["IP较新","低风险"],
        "R_IP_006"=>["IP上聚集多个设备","低风险"],
        "R_IP_007"=>["IP上设备分布异常","低风险"],
        "R_IP_008"=>["疑似中介IP","中风险"],
        "R_IP_JJ_01"=>["当天多个用户通过该IP申请","中风险"],
        "R_IP_JJ_02"=>["近一周（不包含当天）多个用户通过该IP申请","中风险"],
        "R_IP_JJ_03"=>["近一月（不包含当天）多个用户通过该IP申请","中风险"],
        "R_IM_001"=>["IMEI击中网络欺诈风险名单","中风险"],
        "R_IM_002"=>["IMEI近期不活跃","低风险"],
        "R_IM_003"=>["IMEI较新","低风险"],
        "R_IM_004"=>["疑似虚假IMEI","中风险"],
        "R_IM_JJ_01"=>["当天多个用户通过该IMEI申请","中风险"],
        "R_IM_JJ_02"=>["近一周（不包含当天）多个用户通过该IMEI申请","中风险"],
        "R_IM_JJ_03"=>["近一月（不包含当天）多个用户通过该IMEI申请","中风险"],
    ],

];
