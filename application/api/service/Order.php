<?php
/**
 * Created by PhpStorm.
 * User: Eden
 * Date: 2018/2/25
 * Time: 10:44
 */

namespace app\api\service;

use app\api\model\OrderProduct;
use app\api\model\Product as ProductModel;
use app\api\model\UserAddress as UserAddressModel;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;

class Order {
    //客户端传过来的订单商品数组
    protected $oProducts;
    //根据客户端数据从数据库中查出的商品数组
    protected $products;
    //用户id
    protected $uid;

    public function place($uid,$oProducts){
        $this->oProducts=$oProducts;
        $this->uid=$uid;
        $this->products=$this->getProductsByOrder($oProducts);
        //生成订单状态信息(检测库存量)
        $orderStatus=$this->getOrderStatus();
        //判断库存
        if(!$orderStatus['pass']){
            $orderStatus['order_id']=-1;
            return $orderStatus;
        }
        //创建订单快照
        $orderSnap=$this->snapOrder($orderStatus);
        //创建订单并返回成功信息
        return $this->createOrder($orderSnap);

    }

    //创建下单方法
    private function createOrder($snap){
        $orderNo=$this->makeOrderNo();
        $order=new \app\api\model\Order();
        $order->user_id=$this->uid;
        $order->order_no=$orderNo;
        $order->total_price=$snap['orderPrice'];
        $order->total_count=$snap['totalCount'];
        $order->snap_img=$snap['snapImg'];
        $order->snap_name=$snap['snapName'];
        $order->snap_address=$snap['snapAddress'];
        $order->snap_items=json_encode($snap['oProductStatus']);
        $order->save();
        $orderId=$order->id;
        $create_time=$order->create_time;
        foreach ($this->oProducts as &$oProduct) {
            $oProduct['order_id'] = $orderId;
        }
        $orderProduct=new OrderProduct();
        $orderProduct->saveAll($this->oProducts);
        $result=[
            'order_no'=>$orderNo,
            'order_id'=>$orderId,
            'create_time'=>$create_time,
            'pass'=>true
        ];
        return $result;
    }

    //创建生成订单号方法
    public static function makeOrderNo(){
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }

    //创建订单快照
    private function snapOrder($orderStatus){
        $snap=[
            'orderPrice'=>0,
            'totalCount'=>0,
            'oProductStatus'=>[],
            'snapAddress'=>null,
            'snapName'=>'',
            'snapImg'=>'',
        ];
        $snap['orderPrice']=$orderStatus['orderPrice'];
        $snap['totalCount']=$orderStatus['totalCount'];
        $snap['oProductStatus']=$orderStatus['oProductStatusArray'];
        $snap['snapAddress']=json_encode($this->getUserAddress($this->uid));
        $snap['snapName']=$this->products[0]['name'];
        $snap['snapImg']=$this->products[0]['main_img_url'];
        if(count($this->products)>1){
            $snap['snapName'].='等';
        }
        return $snap;
    }

    //获取用户地址信息
    private function getUserAddress($uid){
        $userAddress= UserAddressModel::where('user_id','=',$uid)->find()->toArray();
        if(!$userAddress){
            throw new UserException([
                'msg'=>'您的收货地址未填写，下单失败',
                'errorCode'=>60001
            ]);
        }
        return $userAddress;
    }

    //获取订单的状态
    private function getOrderStatus(){
        $orderStatus=[
            //库存判定
            'pass'=>true,
            //订单总额
            'orderPrice'=>0,
            //订单中各商品的状态
            'oProductStatusArray'=>[],
            //订单中商品的总数量
            'totalCount'=>0
        ];
        foreach ($this->oProducts as $oProduct){
            $oProductStatus=$this->getOrderProductStatus($oProduct['product_id'],$this->products,$oProduct['count']);
            if(!$oProductStatus['haveStock']){
                $orderStatus['pass']=false;
            }
            $orderStatus['orderPrice']+=$oProductStatus['totalPrice'];
            $orderStatus['totalCount']+=$oProductStatus['count'];
            array_push($orderStatus['oProductStatusArray'],$oProductStatus);
//            $orderStatus['oProductStatusArray']=$oProductStatus;
        }
        return $orderStatus;
    }

    //获取订单中每项商品的状态
    private function getOrderProductStatus($oPId,$products,$oPCount){
        //订单中该项商品对应数据库查出的商品数组中的索引值
        $pIndex=-1;
        //订单中每项商品的状态
        $oProductStatus=[
            'id'=>null,
            //是否有库存
            'haveStock'=>false,
            'name'=>'',
            'count'=>'',
            'totalPrice'=>0
        ];
        //判断客户端所传的订单中的商品id在数据库中是否存在，同时判断订单中的该项商品对应查出的商品数组中的索引值
        for($i=0;$i<count($products);$i++){
            if($oPId==$products[$i]['id']){
                $pIndex=$i;
            }
        }
        if($pIndex==-1){
            throw new OrderException([
                'msg'=>'id为'.$oPId.'的商品不存在，创建订单失败'
            ]);
        }else{
            //通过索引值找到查出的商品数组中的商品，为订单中的该项商品状态赋值
            $product=$products[$pIndex];
            $oProductStatus['id']=$product['id'];
            $oProductStatus['name']=$product['name'];
            $oProductStatus['count']=$oPCount;
            $oProductStatus['totalPrice']=$product['price']*$oPCount;
            if($product['stock']-$oPCount>=0){
                $oProductStatus['haveStock']=true;
            }
        }
        return $oProductStatus;
    }

    //获取订单对应的数据库中的商品的记录
    private function getProductsByOrder($oProducts){
        $oPIds=[];
        //将订单中的商品id拼接为数组，用于查询数据库中的商品
        foreach ($oProducts as $oProduct){
            $oPIds[]=$oProduct['product_id'];
        }
        $oProducts=ProductModel::all($oPIds);
        return $oProducts;

    }
}