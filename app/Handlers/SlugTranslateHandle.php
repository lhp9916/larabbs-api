<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandle
{
    /**
     * 利用百度翻译api来翻译生成slug
     * @param $text
     * @return string|void
     */
    public function translate($text)
    {
        //实例化 HTTP 客户端
        $http = new Client();

        //初始化配置信息
        $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $appId = config('services.baidu_translate.appid');
        $key = config('services.baidu_translate.key');
        $salt = time();

        //没有配置百度翻译，自动使用兼容的拼音方案
        if (empty($appId) || empty($key)) {
            return $this->pinyin($text);
        }

        $sign = md5($appId . $text . $salt . $key);
        $query = http_build_query([
            'q' => $text,
            'from' => 'zh',
            'to' => 'en',
            'appid' => $appId,
            'salt' => $salt,
            'sign' => $sign,
        ]);

        $response = $http->get($api . $query);
        $result = json_decode($response->getBody(), true);
        /*        array:3 [▼
                    "from" => "zh"
                    "to" => "en"
                    "trans_result" => array:1 [▼
                        0 => array:2 [▼
                            "src" => "怎样记歌词"
                            "dst" => "How to remember the lyrics"
                        ]
                  ]
        ]*/
        if (isset($result['trans_result'][0]['dst'])) {
            return str_slug($result['trans_result'][0]['dst']);
        }
        return $this->pinyin($text);

    }

    public function pinyin($text)
    {
        $pinyin = app(Pinyin::class);
        return str_slug($pinyin->permalink($text));
    }
}