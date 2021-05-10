<?php
class Receipt
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getReceipts()
    {
        $this->db->query('SELECT 
                            receipt_id,
                            customers.name as customer_name,
                            receipt_detail.updated_at as order_date,
                            receipt_detail.save_type
                        FROM receipt_detail 
                        LEFT JOIN customers
                        ON receipt_detail.customer_id = customers.id
                        GROUP BY receipt_detail.receipt_id
                        ORDER BY receipt_detail.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceiptsToday()
    {
        $this->db->query('SELECT 
                            receipt_detail.receipt_id,
                            receipts.sum_total
                            customers.name as customer_name,
                            receipt_detail.updated_at as order_date,
                            receipt_detail.save_type
                        FROM receipt_detail
                        LEFT JOIN receipts
                        ON receipt_detail.receipt_id = receipts.receipt_id 
                        LEFT JOIN customers
                        ON receipt_detail.customer_id = customers.id
                        WHERE DATE(receipt_detail.updated_at) = CURDATE()
                        GROUP BY receipt_detail.receipt_id
                        ORDER BY receipt_detail.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getTotalToday()
    {
        $date = date('Y-m-d');
        $this->db->query("SELECT SUM(sum_total) sum_total
                        FROM receipts
                        WHERE DATE(receipts.updated_at) = '". $date ."'");
        return $this->db->single();
    }

    public function getReceipt($receipt_id)
    {
        $this->db->query('SELECT *,
                            customers.name as customer_name
                        FROM receipts 
                        LEFT JOIN customers
                        ON receipts.customer_id = customers.id
                        WHERE receipts.receipt_id = :receipt_id');
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        return $this->db->single();
    }

    public function addReceipt($data)
    {
        $this->db->query("INSERT INTO receipts (receipt_id, customer_id, sum_total, order_type, save_type, created_at, updated_at) VALUES (:receipt_id, :customer_id, :sum_total, :order_type, :save_type, :created_at ,:updated_at)");
        //Bind Values
        $this->db->bind(':receipt_id', $data['receipt_id']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':sum_total', $data['sum_total']);
        $this->db->bind(':order_type', $data['order_type']);
        $this->db->bind(':save_type', $data['save_type']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateReceipt($data)
    {
        $this->db->query("UPDATE receipts SET customer_id = :customer_id , sum_total = :sum_total, save_type = :save_type , updated_at = :updated_at WHERE receipt_id = :receipt_id");
        //Bind Values
        $this->db->bind(':receipt_id', $data['receipt_id']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':sum_total', $data['sum_total']);
        $this->db->bind(':save_type', $data['save_type']);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

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

    public function deleteReceipt($receipt_id)
    {
        $this->db->query("DELETE FROM receipt_detail WHERE receipt_id IN (:receipt_id)");
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
        $this->db->query("SELECT CASE WHEN MAX(receipt_id) IS NULL THEN 1 ELSE MAX(receipt_id) + 1 end as receipt_id FROM receipts");
                        
        return $this->db->single();
    }
}
