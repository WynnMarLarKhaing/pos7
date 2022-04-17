<?php
class SellReceipDetail
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getReceipts()
    {
        $this->db->query('SELECT 
                            sellReceipt_detail.*,
                            sellReceipts.*,
                            customers.name as customer_name,
                            sellReceipt_detail.updated_at as order_date
                        FROM sellReceipt_detail 
                        LEFT JOIN sellReceipts
                        ON sellReceipt_detail.receipt_id = sellReceipts.receipt_id
                        LEFT JOIN customers
                        ON sellReceipt_detail.customer_id = customers.id
                        GROUP BY sellReceipt_detail.receipt_id
                        ORDER BY sellReceipt_detail.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceiptsToday()
    {
        $date = date('Y-m-d');
        $this->db->query("SELECT 
                            sellReceipt_detail.*,
                            sellReceipts.*,
                            customers.name as customer_name,
                            sellReceipt_detail.updated_at as order_date
                        FROM sellReceipt_detail
                        LEFT JOIN sellReceipts
                        ON sellReceipt_detail.receipt_id = sellReceipts.receipt_id
                        LEFT JOIN customers
                        ON sellReceipt_detail.customer_id = customers.id
                        WHERE DATE(sellReceipt_detail.updated_at) = '".$date."'
                        GROUP BY sellReceipt_detail.receipt_id
                        ORDER BY sellReceipt_detail.receipt_id DESC");
        return $this->db->resultSet();
    }

    public function getReceiptDetail($receipt_id)
    {
        $this->db->query('SELECT 
                            sellReceipt_detail.*,
                            sellReceipts.sum_total,
                            customers.name as customer_name,
                            customers.name_zawgyi as customer_name_zawgyi,
                            stocks.name as stock_name,
                            stocks.name_zawgyi as stock_name_zawgyi,
                            stocks.customer_price
                        FROM sellReceipt_detail 
                        LEFT JOIN sellReceipts
                        ON sellReceipt_detail.receipt_id = sellReceipts.receipt_id
                        INNER JOIN stocks
                        ON sellReceipt_detail.stock_id = stocks.stocks_shortcut_id
                        LEFT JOIN customers
                        ON sellReceipt_detail.customer_id = customers.id
                        WHERE sellReceipt_detail.receipt_id = :receipt_id
                        ORDER BY sellReceipt_detail.disp_sort ASC');
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        return $this->db->resultSet();
    }

    public function addReceiptDetail($data)
    {
        $this->db->query("INSERT INTO sellReceipt_detail (receipt_id, stock_id, customer_id, qty, customer_price, total, disp_sort, created_at, updated_at) VALUES (:receipt_id, :stock_id, :customer_id, :qty, :customer_price, :total, :disp_sort, :created_at ,:updated_at)");
        //Bind Values
        $this->db->bind(':receipt_id', $data['receipt_id']);
        $this->db->bind(':stock_id', $data['stock_id']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':customer_price', 0);
        $this->db->bind(':total', $data['total']);
        $this->db->bind(':disp_sort', $data['disp_sort']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->db->query("UPDATE customers SET name = :name , phone = :phone, address = :address WHERE id = :id");
        //Bind Values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPostById($id)
    {
        $this->db->query("SELECT * FROM customers WHERE id = :id");
        //Bind Values
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }

    public function deleteReceiptDetail($receipt_id)
    {
        $this->db->query("DELETE FROM sellReceipt_detail WHERE receipt_id IN (:receipt_id)");
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getLastInsertId()
    {
        $this->db->query("SELECT CASE WHEN MAX(receipt_id) IS NULL THEN 1 ELSE MAX(receipt_id) + 1 end as receipt_id FROM sellReceipt_detail");
                        
        return $this->db->single();
    }
}
