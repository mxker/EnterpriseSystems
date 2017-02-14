<?php
namespace common\moyun\channel\logisticspaper;
use common\moyun\channel\logisticspaper\BaseLogisticspaper;
/**
 * Created by transport.
 * 
 * @FileName : Macroexpressco.php
 * @Author : fibst <ixiezhi@163.com>
 * @DateTime : 2016/11/25-11-25 16:12 
 */
class Macroexpressco extends BaseLogisticspaper{

    function __construct(){
        $this->pdf_obj = new \TCPDF('P', 'mm',  array(100, 150), true, 'UTF-8', false);
    }

    function get_logisticspaper($parcel_ids){
        $pdf = $this->pdf_obj;
        $pdf->SetCreator('洋姑妈');
        $pdf->SetAuthor('洋姑妈');
        $pdf->SetTitle('洋姑妈');
        $pdf->SetSubject('洋姑妈');
        $pdf->SetKeywords('洋姑妈');
        $pdf->SetDefaultMonospacedFont('courier');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(2,2,2,true);
        $pdf->SetAutoPageBreak( true, 2 );
        $pdf->SetFont('stsongstdlight', '', 8);
        foreach($parcel_ids as $parcel_id) {
            $parcel = $this->getParcel($parcel_id);
            $weight = $parcel['weight_p']>0?$parcel['weight_p']:$parcel['weight_m'];
            $goods_num = 0;//件数
            foreach($parcel['parcelGoods'] as $val){
                $goods_num+=$val['parcel_num'];
            }
            $sender_info = unserialize($parcel['sender_info']);
            $deliver_name = isset($sender_info['name']) ? $sender_info['name'] : 'Eu EXPRESS';
            $deliver_address = isset($sender_info['adress']) ?  $sender_info['adress'] : 'Frankfurt,Starkenburgstr.11-13';
            $receiver_info = unserialize($parcel['receiver_info']);
            $send_data = date('Y-m-d', time());
            $pdf->AddPage();
            $img1 = $this->_createBarcode($parcel['tracking_code_moyun'], 1, 20);
            $img2 = $this->_createBarcode($parcel['tracking_code_moyun'], 1, 20);
            $img3 = $this->_createBarcode($parcel['tracking_code_moyun'], 2, 25);
            $tbl = <<<EOF
        <table cellspacing="0" style="border:1px dashed #000;">
            <colgroup></colgroup>
            <colgroup></colgroup>
            <colgroup></colgroup>
            <colgroup></colgroup>
            <tbody>
            <tr>
                <td class="a" style="border-right: 1px dashed #000;font-size: 36px; font-family: serif;font-weight:bold;">SPS</td>
                <td colspan="3" style="text-align: center; font-family: serif;" height="10pt">{$img1}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border-top: 1px dashed #000;line-height: 16px;">
                    时间：{$send_data}
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    寄件人：{$deliver_name}
                </td>
            </tr>
            <tr>
                <td colspan="4" height="24">
                    {$deliver_address}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="border-top: 1px dashed #000;line-height: 18px;">
                    收件人：{$receiver_info['true_name']} {$receiver_info['mob_phone']}
                </td>
            </tr>
            <tr>
                <td colspan="4" style="line-height: 14px;"  height="30">
                    {$receiver_info['adress']}
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px dashed #000;line-height: 18px;">
                    付款方式:<br>
                    计费重量:
                </td>
                <td colspan="3" style="border-top: 1px dashed #000;line-height: 18px;">
                    收件人/代收人: <br>
                    签收时间:  ____年__月__日__时
                </td>
            </tr>
            <tr>
                <td>
                    报价金额:
                </td>
                <td colspan="3">
                    快递送达收货人地址，经收货人或收件人允许的代收人签字，视为送达
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px dashed #000;line-height: 18px;">
                    订单号:{$parcel['out_trade_no']}
                </td>
                <td style="border-top: 1px dashed #000;line-height: 18px;" >
                    件数:{$goods_num}件
                </td>
                <td style="border-top: 1px dashed #000;line-height: 18px;" >
                    重量:{$weight}KG
                </td>
            </tr>
            <tr>
                <td colspan="4" style="line-height: 16px;">
                    该件乃跨境直邮件，若无法派送, 请退回到成都双流EMS国际部
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px dashed #000;"></td>
                <td colspan="2" rowspan="1" style="font-family: serif;border-top: 1px dashed #000;">{$img2}</td>
                <td style="border-top: 1px dashed #000"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: 1px dashed #000;line-height: 16px;">
                    寄件人：
                </td>
                <td colspan="2" style="border-top: 1px dashed #000;line-height: 16px;">
                    收件人：
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    {$deliver_name}
                </td>
                <td colspan="2">
                   {$receiver_info['true_name']} {$receiver_info['mob_phone']}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                 {$deliver_address}
                </td>
                <td colspan="2" height="46">
                 {$receiver_info['adress']}
                </td>
            </tr>
            <tr><td colspan="4" style="border-top: 1px dashed #000"></td></tr>
            <tr>
                <td colspan="3" style="font-family: serif;">{$img3}</td>
                <td></td>
            </tr>
            </tbody>
        </table>
EOF;
            $pdf->writeHTML($tbl, true, false, false, false, '');
        }
        $pdf->Output('Macroexpressco.pdf', 'D');

    }
}