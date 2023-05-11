<?php
class BillModel extends Model
{
    public function getAllBill()
    {
        $sql = parent::$connection->prepare('SELECT * FROM `bill` WHERE 1');
        if (!empty(parent::select($sql))) {
            return parent::select($sql);
        }
        return null;
    }

    public function getAllBillByIdAccount($id_account)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `bill` WHERE `id_account`=?');
        $sql->bind_param("i", $id_account);
        if (!empty(parent::select($sql))) {
            return parent::select($sql);
        }
        return null;
    }
    public function getItemInBillByIdBill($idB)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `bill_product` WHERE `id_bill`=?');
        $sql->bind_param("i", $idB);
        if (!empty(parent::select($sql))) {
            return parent::select($sql);
        }
        return null;
    }
    public function creatBill($id_account, $bill_total, $phone_number, $order_notes, $receive_name, $receive_address, $bill_pttt, $array)
    {
        
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = getdate();
        $order_date = $date['hours'] . ":" . $date['minutes'] . ":" . $date['seconds'] . " - " . $date['weekday'] . " " . $date['mday'] . "/" . $date['mon'] . "/" . $date['year'];

        $sql = parent::$connection->prepare("INSERT INTO `bill`(`id_account`, `order_date`, `bill_total`, `phone_number`, `order_notes`, `receive_name`, `receive_address`, `bill_pttt`) VALUES (?,?,?,?,?,?,?,?)");
        $sql->bind_param("isissssi", $id_account, $order_date, $bill_total, $phone_number, $order_notes, $receive_name, $receive_address, $bill_pttt);
        $bool_bill = $sql->execute();
        if ($bool_bill) {
            $sql2 = parent::$connection->prepare("SELECT `id` FROM `bill` WHERE `id_account`=? AND `order_date`=?");
            $sql2->bind_param("is", $id_account, $order_date);
            $codeBill = parent::select($sql2)[0]['id'];
            $i = 0;
            for ($i=0; $i < count($array); $i++) { 
                $id_product = $array['id'][$i];
                $qty = $array['qty'][$i];
                $sql3 = parent::$connection->prepare('INSERT INTO `bill_product`(`id_bill`, `id_sp`, `qty`) VALUES (?,?,?)');
                $sql3->bind_param("iii", $codeBill, $id_product, $qty);
                $sql3->execute();
            }
            $cartModel = new CartModel();
            $cartModel->deleteAllProductInCart($id_account);
            return true;
        } else {
            return false;
        }
    }
    public function getAllAmount()
    {
        $sql = parent::$connection->prepare('SELECT sum(`bill_total`) as "amount" FROM `bill`');
        return parent::select($sql)[0]['amount'];
    }
    public function getBillPage($limit, $offset)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `bill`  ORDER BY `id` DESC LIMIT ? OFFSET ?');
        $sql->bind_param('ii', $limit, $offset);
        return parent::select($sql);
    }
    public function status($status){
        $sql = parent::$connection->prepare('SELECT * FROM `bill` WHERE `bill_status`=?');
        $sql->bind_param('i', $status);
        return parent::select($sql);
    }
    public function getBillByStatus($type_bill)
    {
        $sql = parent::$connection->prepare('SELECT * FROM `bill` WHERE `bill_status` = ?');
        $sql->bind_param('i', $type_bill);
        return parent::select($sql);
    }
    public function updateStatusBill($st,$id)
    {
        $sql = parent::$connection->prepare('UPDATE `bill` SET `bill_status`=? WHERE id = ?');
        $sql->bind_param('ii', $st,$id);
        $sql->execute();
    }
}
