<?php
/**
 * Created by PhpStorm.
 * User: mei
 * Date: 2018/1/11
 * Time: 17:33
 */

namespace Kubill\Emay;


use Illuminate\Support\Facades\Log;

class Emay
{
    public function __construct()
    {
        $this->YM_SMS_ADDR = config('emay.base_uri');
        $this->YM_SMS_SEND_URI = config('emay.send_uri');
        $this->YM_SMS_SEND_BATCH_URI = config('emay.send_batch_uri');
        $this->YM_SMS_GETBALANCE_URI = config('emay.getbalance_uri');
        $this->YM_SMS_APPID = config('emay.app_id');
        $this->YM_SMS_AESPWD = config('emay.aes_pwd');
        $this->EN_GZIP = config('emay.gzip');
    }

    /**
     * @param string $mobile 手机号
     * @param string $content 内容
     * @param string $timerTime 定时发送，默认立即发送，格式：yyyy-MM-dd HH:mm:ss
     * @param string $customSmsId 自定义消息ID，最长64位
     * @param string $extendedCode 扩展码，最长12位
     * @param int $validPeriodtime 请求时间
     */
    public function send($mobile, $content, $timerTime = "", $customSmsId = "", $extendedCode = "", $validPeriodtime = 120)
    {
        return $mobile;
        $timestamp = date('YmdHis');
        $sign = md5(config('emay.app_id') . config('emay.aes_pwd') . $timestamp);
        $data['appId'] = config('emay.app_id');
        $data['timestamp'] = $timestamp;
        $data['sign'] = $sign;
        $data['mobiles'] = $mobile;
        $data['content'] = config('sms_prefix') . $content;
        if ($timerTime !== '') {
            $data['timerTime'] = $timerTime;
        }
        if ($customSmsId !== '') {
            $data['customSmsId'] = $customSmsId;
        }
        if ($extendedCode !== '') {
            $data['extendedCode'] = $extendedCode;
        }
        if ($validPeriodtime !== 120) {
            $data['validPeriodtime'] = $validPeriodtime;
        }
        $uri = config('emay.base_uri') . config('emay.send_uri');
        $response = self::curlPost($uri, $data);
        $result = json_decode($response, true);
        return $result['code'] == 'SUCCESS' ? true : false;
    }

    private function curlPost($url, $data)
    {
        try {
            $data = http_build_query($data);
            $ch = curl_init();
            $timeout = 300;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            $handles = curl_exec($ch);
            curl_close($ch);
            return $handles;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new \Exception('接口调用异常');
        }
    }
}