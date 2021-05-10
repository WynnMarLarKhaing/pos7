<?php
class ReceiptPdf
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
                            receipt_detail_pdf.updated_at as order_date,
                            receipt_detail_pdf.save_type
                        FROM receipt_detail_pdf 
                        LEFT JOIN customers
                        ON receipt_detail_pdf.customer_id = customers.id
                        GROUP BY receipt_detail_pdf.receipt_id
                        ORDER BY receipt_detail_pdf.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceiptsToday()
    {
        $this->db->query('SELECT 
                            receipt_id,
                            customers.name as customer_name,
                            receipt_detail_pdf.updated_at as order_date,
                            receipt_detail_pdf.save_type
                        FROM receipt_detail_pdf 
                        LEFT JOIN customers
                        ON receipt_detail.customer_id = customers.id
                        WHERE DATE(receipt_detail.updated_at) = CURDATE()
                        GROUP BY receipt_detail_pdf.receipt_id
                        ORDER BY receipt_detail_pdf.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceipt($receipt_id)
    {
        $this->db->query('SELECT *,
                            customers.name as customer_name
                        FROM receipts_pdf 
                        LEFT JOIN customers
                        ON receipts_pdf.customer_id = customers.id
                        WHERE receipts_pdf.receipt_id = :receipt_id');
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        return $this->db->single();
    }

    public function addReceipt($data)
    {
        $this->db->query("INSERT INTO receipts_pdf (receipt_id, customer_id, sum_total, order_type, save_type, created_at, updated_at) VALUES (:receipt_id, :customer_id, :sum_total, :order_type, :save_type, :created_at ,:updated_at)");
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
        $this->db->query("UPDATE receipts_pdf SET customer_id = :customer_id , sum_total = :sum_total, save_type = :save_type , updated_at = :updated_at WHERE receipt_id = :receipt_id");
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
        $this->db->query("DELETE FROM receipt_detail_pdf WHERE receipt_id IN (:receipt_id)");
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
        $this->db->query("SELECT CASE WHEN MAX(receipt_id) IS NULL THEN 1 ELSE MAX(receipt_id) + 1 end as receipt_id FROM receipts_pdf");
                        
        return $this->db->single();
    }
}
