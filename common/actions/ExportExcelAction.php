<?php
namespace common\actions;

use Yii;
use yii\base\Action;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\helpers\Json;
use frontend\models\Parcel;
use yii\helpers\Url;

class ExportExcelAction extends Action {


    public function init() {

    }

    /**
     * Runs the action.
     */
    public function run() {
        $parcel_ids = Yii::$app->request->post('parcel_id')?Yii::$app->request->post('parcel_id'):Yii::$app->request->get('parcel_id');
        if(Yii::$app->request->get('t')&&Yii::$app->request->get('t')=='json'){
            $parcel_ids = json_decode($parcel_ids,true);
        }
        try {
            if ($parcel_ids && is_array($parcel_ids)) {
                $parcels =[];
                foreach($parcel_ids as $parcel_id) {
                    $parcels[] = $this->getParcelLogisticChannel($parcel_id);
                }
                $this->exportExcel($parcels);
            } else {
                throw new Exception('请选择导出的运单号');
            }
        }catch (Exception $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
            Yii::$app->getResponse()->redirect(Url::to(['parcel/list']), 302);
        }

    }

    public function getParcelLogisticChannel($parcel_id){
        $session = Yii::$app->session->get('member');
        $conditon =[];
        if(isset($session['member_id'])&&$session['member_id']) {
            $conditon['my_parcel.member_id'] = $session['member_id'];
        }
        $conditon['my_parcel.parcel_id'] = $parcel_id;
        $parcelModel = new Parcel();
        $parcel = $parcelModel->getParcelDetail($conditon);
        $parcel['AddrSender'] = unserialize($parcel['sender_info']);
        $parcel['AddrReceiver'] = unserialize($parcel['receiver_info']);
        return $parcel;
    }


    public function exportExcel($data){
        $name = '转运运单';
        error_reporting(E_ALL);
        $objPHPExcel = new \PHPExcel();
        /*以下是一些设置 ，什么作者  标题啊之类的*/
        $objPHPExcel->getProperties()->setCreator("SuperB-Grace")
            ->setLastModifiedBy("SuperB-Grace")
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("运单数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
        $objPHPExcel->setActiveSheetIndex(0)
            //Excel的第A列，uid是你查出数组的键值，下面以此类推
            ->setCellValue('A1', '陌云运单号')
            ->setCellValue('B1', '序号')
            ->setCellValue('C1', '入库仓库')
            ->setCellValue('D1', '转运渠道编码')
            ->setCellValue('E1', '包裹重量（kg）')
            ->setCellValue('F1', '三方订单号')
            ->setCellValue('G1', '发件人')
            ->setCellValue('H1', '发件人电话')
            ->setCellValue('I1', '发件人国家')
            ->setCellValue('J1', '发件人地址')
            ->setCellValue('K1', '发件人邮编')
            ->setCellValue('L1', '收件人')
            ->setCellValue('M1', '收件人电话')
            ->setCellValue('N1', '收件人省市区')
            ->setCellValue('O1', '收件人地址')
            ->setCellValue('P1', '收件人邮编')
            ->setCellValue('Q1', '身份证号码')
            ->setCellValue('R1', '商品名称')
            ->setCellValue('S1', '品牌/型号/规格')
            ->setCellValue('T1', '数量')
            ->setCellValue('U1', '单位')
            ->setCellValue('V1', '单价（RMB）');
        foreach($data as $k => $v){
            $num=$k+2;
            $tpl = $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValue('A'.$num, $v['tracking_code_moyun'])
                ->setCellValue('B'.$num, $k+1)
                ->setCellValue('C'.$num, $v['name'])
                ->setCellValue('D'.$num, $v['code'])
                ->setCellValue('E'.$num, $v['weight_m'])
                ->setCellValue('F'.$num, ' '.$v['out_trade_no'])
                ->setCellValue('G'.$num, $v['AddrSender']['name'])
                ->setCellValue('H'.$num, ' '.$v['AddrSender']['mob_phone'])
                ->setCellValue('I'.$num, $v['AddrSender']['country'])
                ->setCellValue('J'.$num, $v['AddrSender']['adress'])
                ->setCellValue('K'.$num, $v['AddrSender']['postcode'])
                ->setCellValue('L'.$num, $v['AddrReceiver']['true_name'])
                ->setCellValue('M'.$num, ' '.$v['AddrReceiver']['mob_phone'])
                ->setCellValue('N'.$num, $v['AddrReceiver']['area_info'])
                ->setCellValue('O'.$num, $v['AddrReceiver']['adress'])
                ->setCellValue('P'.$num, $v['AddrReceiver']['postcode'])
                ->setCellValue('Q'.$num, ' '.$v['AddrReceiver']['idcard_number']);
                $i ='R';
                foreach($v['parcelGoods'] as $goods){
                    $tpl->setCellValue($i.$num, $goods['importCatalog']['name']);
                    $i++;
                    $tpl->setCellValue($i.$num, $goods['parcel_descript']);
                    $i++;
                    $tpl->setCellValue($i.$num, $goods['parcel_num']);
                    $i++;
                    $tpl->setCellValue($i.$num,$goods['importCatalog']['unit']);
                    $i++;
                    $tpl->setCellValue($i.$num, $goods['unit_price']);
                    $i++;
                }
        }
        $objPHPExcel->getActiveSheet()->setTitle('User');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getStyle('Q')->getNumberFormat()
            ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

}