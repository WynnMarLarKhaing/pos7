<?php
class SellReceiptsPdf
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
                            sellReceipt_detail_pdf.updated_at as order_date,
                            sellReceipt_detail_pdf.save_type
                        FROM sellReceipt_detail_pdf 
                        LEFT JOIN customers
                        ON sellReceipt_detail_pdf.customer_id = customers.id
                        GROUP BY sellReceipt_detail_pdf.receipt_id
                        ORDER BY sellReceipt_detail_pdf.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceiptsToday()
    {
        $this->db->query('SELECT 
                            receipt_id,
                            customers.name as customer_name,
                            sellReceipt_detail_pdf.updated_at as order_date,
                            sellReceipt_detail_pdf.save_type
                        FROM sellReceipt_detail_pdf 
                        LEFT JOIN customers
                        ON receipt_detail.customer_id = customers.id
                        WHERE DATE(receipt_detail.updated_at) = CURDATE()
                        GROUP BY sellReceipt_detail_pdf.receipt_id
                        ORDER BY sellReceipt_detail_pdf.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceipt($receipt_id)
    {
        $this->db->query('SELECT *,
                            customers.name as customer_name
                        FROM sellReceipts_pdf 
                        LEFT JOIN customers
                        ON sellReceipts_pdf.customer_id = customers.id
                        WHERE sellReceipts_pdf.receipt_id = :receipt_id');
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        return $this->db->single();
    }

    public function addReceipt($data)
    {
        $this->db->query("INSERT INTO sellReceipts_pdf (receipt_id, customer_id, sum_total, order_type, save_type, created_at, updated_at) VALUES (:receipt_id, :customer_id, :sum_total, :order_type, :save_type, :created_at ,:updated_at)");
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
        $this->db->query("UPDATE sellReceipts_pdf SET customer_id = :customer_id , sum_total = :sum_total, save_type = :save_type , updated_at = :updated_at WHERE receipt_id = :receipt_id");
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
        $this->db->query("DELETE FROM sellReceipt_detail_pdf WHERE receipt_id IN (:receipt_id)");
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
        $this->db->query("SELECT CASE WHEN MAX(receipt_id) IS NULL THEN 1 ELSE MAX(receipt_id) + 1 end as receipt_id FROM sellReceipts_pdf");
                        
        return $this->db->single();
    }
}
