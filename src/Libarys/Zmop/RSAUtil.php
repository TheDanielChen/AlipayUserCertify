<?php
namespace Cstopery\AlipayUserCertify\Libarys\Zmop;
/**
 * Created by Cstopery.
 * User: Cstopery
 * Date: 2015/9/28
 * Time: 19:11
 */

class RSAUtil{

    /**
     * 加签
     * @param $data 要加签的数据
     * @param $privateKeyFilePath 私钥文件路径
     * @return string 签名
     */
    public static function sign($data, $privateKeyFilePath) {
        $priKey = file_get_contents($privateKeyFilePath);
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n".
            wordwrap($priKey, 64, "\n", true).
            "\n-----END RSA PRIVATE KEY-----";

//        $res = openssl_get_privatekey($priKey);
        openssl_sign(self::getSignContent($data), $sign, $privateKey,OPENSSL_ALGO_SHA256);
//        openssl_free_key($privateKey);
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * Get signContent that is to be signed.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $data
     * @param bool  $verify
     *
     * @return string
     */
    public static function getSignContent(array $data, $verify = false): string
    {
//        $data = self::encoding($data, $data['charset'] ?? 'gb2312', 'utf-8');

        ksort($data);

        $stringToBeSigned = '';
        foreach ($data as $k => $v) {
            if ($verify && $k != 'sign' && $k != 'sign_type') {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
            if (!$verify && $v !== '' && !is_null($v) && $k != 'sign' && '@' != substr($v, 0, 1)) {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
        }

//        Log::debug('Alipay Generate Sign Content Before Trim', [$data, $stringToBeSigned]);

        return trim($stringToBeSigned, '&');
    }

    /**
     * Convert encoding.
     *
     * @author yansongda <me@yansonga.cn>
     *
     * @param string|array $data
     * @param string       $to
     * @param string       $from
     *
     * @return array
     */
    public static function encoding($data, $to = 'utf-8', $from = 'gb2312'): array
    {
        return Arr::encoding((array) $data, $to, $from);
    }

    /**
     * 验签
     * @param $data 用来加签的数据
     * @param $sign 加签后的结果
     * @param $rsaPublicKeyFilePath 公钥文件路径
     * @return bool 验签是否成功
     */
    public static function verify($data, $sign, $rsaPublicKeyFilePath) {
        //读取公钥文件
        $pubKey = file_get_contents($rsaPublicKeyFilePath);

        //转换为openssl格式密钥
//        $res = openssl_get_publickey($pubKey);

        $publicKey = "-----BEGIN PUBLIC KEY-----\n".
            wordwrap($pubKey, 64, "\n", true).
            "\n-----END PUBLIC KEY-----";

        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($data, base64_decode($sign), $publicKey);

        //释放资源
//        openssl_free_key($publicKey);

        return $result;
    }


    /**
     * rsa加密
     * @param $data 要加密的数据
     * @param $pubKeyFilePath 公钥文件路径
     * @return string 加密后的密文
     */
    public static function rsaEncrypt($data, $pubKeyFilePath){
        //读取公钥文件
        $pubKey = file_get_contents($pubKeyFilePath);
        //转换为openssl格式密钥
//        $res = openssl_get_publickey($pubKey);
        $pubKey = "-----BEGIN PUBLIC KEY-----\n".
            wordwrap($pubKey, 64, "\n", true).
            "\n-----END PUBLIC KEY-----";

//        $maxlength = RSAUtil::getMaxEncryptBlockSize($pubKey);
        $maxlength = 30;
        $output='';
        while(strlen($data)){
            $input= substr($data,0,$maxlength);
            $data=substr($data,$maxlength);
            openssl_public_encrypt($input,$encrypted,$pubKey);
            $output.= $encrypted;
        }
        $encryptedData =  base64_encode($output);
        return $encryptedData;
    }

    /**
     * 解密
     * @param $data 要解密的数据
     * @param $privateKeyFilePath 私钥文件路径
     * @return string 解密后的明文
     */
    public static function rsaDecrypt($data, $privateKeyFilePath){
        //读取私钥文件
        $priKey = file_get_contents($privateKeyFilePath);
        //转换为openssl格式密钥
//        $res = openssl_get_privatekey($priKey);
        $res = "-----BEGIN PUBLIC KEY-----\n".
        wordwrap($priKey, 64, "\n", true).
        "\n-----END PUBLIC KEY-----";
        $data = base64_decode($data);
        $maxlength = 30;
//        $maxlength = RSAUtil::getMaxDecryptBlockSize($res);
        $output='';
        while(strlen($data)){
            $input = substr($data,0,$maxlength);
            $data = substr($data,$maxlength);
            openssl_private_decrypt($input,$out,$res);
            $output.=$out;
        }
        return $output;
    }

    /**
     *根据key的内容获取最大加密lock的大小，兼容各种长度的rsa keysize（比如1024,2048）
     * 对于1024长度的RSA Key，返回值为117
     * @param $keyRes
     * @return float
     */
    public static function getMaxEncryptBlockSize($keyRes){
        $keyDetail = openssl_pkey_get_details($keyRes);
        $modulusSize = $keyDetail['bits'];
        return $modulusSize/8 - 11;
    }

    /**
     * 根据key的内容获取最大解密block的大小，兼容各种长度的rsa keysize（比如1024,2048）
     * 对于1024长度的RSA Key，返回值为128
     * @param $keyRes
     * @return float
     */
    public static function getMaxDecryptBlockSize($keyRes){
        $keyDetail = openssl_pkey_get_details($keyRes);
        $modulusSize = $keyDetail['bits'];
        return $modulusSize/8;
    }
}