<?php
error_reporting(0);
session_start();
define('BASE_PATH',str_replace('\\','/',dirname(__FILE__))."/");
define('ROOT_PATH',str_replace('app/','',BASE_PATH));
define('DB_TYPE', 'sqlite'); //数据库类型
define('DB_NAME', ROOT_PATH.'app/db/e99dba9e1c.db'); //上线请更改数据库地址
define('TOKEN', '0e6d15df8781e');
/*** 请填写以下配置信息 ***/
$appid = '2021001189619402';  //https://open.alipay.com 账户中心->密钥管理->开放平台密钥，填写添加了电脑网站支付的应用的APPID
$notifyUrl = 'https://lzx.zendee.cn/app/pay.php';     //付款成功后的异步回调地址
$signType = 'RSA2';			//签名算法类型，支持RSA2和RSA，推荐使用RSA2
$rsaPrivateKey='MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCX4lEYXK/XfTAEE5+YpjeiPIv0ybUi4ZQ30b5egzkLoDa9/IQyNLCWm5bJZPBeysZ8c+GYHAw4UGqK4VSnF248O3yM0PH1+pXfe4Q3U95VKrdBuN3w3u5c10lQYDIhD1FNKn29lT2X8UHlWK195176D3NuQM2g7Jh+H+s3okLKV1KP1hiOB3ze/GDfk1Z5fvzURrfSc/GEu2Z4Itqkas+y47KaDpZ2rpq+lnPOkanDJVOz2//vn9pseLDY7JBz2zYJpAwPjRlY/VJMJR5KwD2x/CUAyElq1mDWyx7PorP7sJmBVaD6d7Lw25pYO1O7+1xyli/10essHda54zPP1a7tAgMBAAECggEAcfi31congVJFZ6m6BvgjozA/7Y42yFfxuvk/GvjpI5ozudj08h+rqzhRrAp8fQU4cEccr+HMIa3mZRS1SzU/2R7iVWCtUGGbeTncexAKNGp7XWv1zzvaLfy23QNyWnB+F6Oc+1g0AgJd6lXiyimGkapqef9SzkD8JRiajwLJj79LesBUj2JNbGQD8l7SRCjMijuBa/9sMd6w+O87TjL86gt+XU0Eiy8VNDGmM5VXucwKUlxud8b/S+/dbcdYE3aDQfqKaxISaQOI1/OM1kHhKtjcaeaPI8E550MrqOXXWl62v6mKr+gSrUztMPPMf8n/q8Jr+nJPjCrhBZ0WkIvlQQKBgQD3U7KlJrUFzelhuxUFc5qKDlpXIg1x0epeDUZWRPQR4BYUg/xDaja491kmM4CGXJPa5VkGRG1Tzh1TKNlpbsM9hLBfXTX3ZnZ/Uu4oOF9sqg0/MtI4Mzqh/265bu5Mcg1vj6H31dvMYnNSeJQb4UUxsfs1PguvWIBhaRAFj0YLhQKBgQCdNc86ZMGpmU6hSLBkD1cU++pWwmhEiRrVTPL2WMnrvd/oZZ21ttakbdhFbTKfyYm3CDd9c71qYO93z63XmXBuPwVpw+wZIkXD+UPDSYMP08tA80UNImjLh6hshPrTACMHIz87HD6vu//4AqEpZ+Ji0VXsazg3EPSVQ9d1b2iuSQKBgGhmXDJ6dE9O7ATlA6qZcdJ03I2LQkGZamTpFZe045HoFWnzjLioTREm1+rYMpiE26S6yylqGPwXNSm1RJDMwH1nVUvr/KvCBKMaTo2LvjwQTCcxPKucdFONjx+XQ9/hBOripmwHShCsPiHB5EMghCTGDFQdLLGHmimEP88Y+2hBAoGAA8fPe/AAWDu/kFFXLJDR30dPk1aJe1xwsMBw90ubT3f5cnU/HaeP8dRSZxkBJqaKEUS5UOL/oxdBqvfrjku6UGxjjO+RNemFE/lij8esxyyorp8rAe3Z50sT2cg43+oY7YsDckBzoXY76ZLmnUBKSWYPUughKfHWb+B5xfEv60ECgYEA8VyoZc3KFNjg/tE5kwkLotyifyCfJ2+w8yz8qo8VbmmcQfQ1LwCbhVqwRmpLoEijezDFmAK7h997C/inm5jXRi52u75XmjQs/ySfEfti+89ZVQSZ59g/QKYaGFIcnQFEwd18aie/EbkXG3W/h4nm0F3SjGJAT0xNV0ElJ18dsDA=';	
//支付宝公钥，账户中心->密钥管理->开放平台密钥，找到添加了支付功能的应用，根据你的加密类型，查看支付宝公钥
$alipayPublicKey='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAoXuKocpbOsi2D6bE31sQq2XP9iFhLpNARInxvzfi8hmZfstrBmBrd7g/fOCGa1jNdIjxZlQIkWK3a2D/r9fgnNbkxKpQX0SWU91Bn+Hk8qzj8PytRrCCUlLdFvSdNK3t/TR/lxtFS1vvsWpFtGW34tgm5BV7fZLxvOmS8dV23xj/zVLt0aNEKJqREg6UFjPJ6++n/QbsOf+eJ31l/PE1JTY3IAEZc1oxiHAgsDlT2uIlnoaVgk4ynSF9SfJJ+CwQpJBtCIIc3VpH/nhj78txmQanyUHz471ter1mBZUKJ52K9XTBsEZ429XufsMf4UOt2Qk7fzI3oRtPU92jkRZHZQIDAQAB';