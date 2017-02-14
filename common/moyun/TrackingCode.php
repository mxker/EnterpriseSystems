<?php
namespace common\moyun;

class TrackingCode {
    /**
     * 根据包裹号码获取陌云流跟踪号
     * @param  int $id 包裹id
     * @return string     运单号
     */
    public static function getCode($id) {
        $code = self::getBaseCode('normal') . sprintf('%08d', $id);
        return $code;
    }

    /**
     * 获取陌云预分配物流号
     * @param  int $num 需要的物流号数量
     * @param int $member_id 用户id
     * @return ['start' => string, 'end' => string]      物流开始号与结束号
     */
    public static function getSegment($num, $member_id) {
        // TODO
        return ['start' => '', 'end' => ''];
    }

    /**
     * 获取基础号码格式
     * @param  string $type normal|segment
     * @return string       号码基础格式
     */
    private static function getBaseCode($type) {
        $prefix = '';
        switch ($type) {
        case 'normal':
            $prefix = 'SG0';
            break;
        case 'segment':
            $prefix = 'SG5';
            break;
        default:
            $prefix = false;
            break;
        }
        return $prefix;
    }
}