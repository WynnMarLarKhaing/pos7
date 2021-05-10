<?php
class ReceipDetailPdf
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getReceipts()
    {
        $this->db->query('SELECT 
                            receipt_detail_pdf.*,
                            receipts_pdf.*,
                            customers.name as customer_name,
                            receipt_detail_pdf.updated_at as order_date
                        FROM receipt_detail_pdf 
                        LEFT JOIN receipts_pdf
                        ON receipt_detail_pdf.receipt_id = receipts_pdf.receipt_id
                        LEFT JOIN customers
                        ON receipt_detail_pdf.customer_id = customers.id
                        GROUP BY receipt_detail_pdf.receipt_id
                        ORDER BY receipt_detail_pdf.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceiptsToday()
    {
        $this->db->query('SELECT 
                            receipt_detail_pdf.*,
                            receipts_pdf.*,
                            customers.name as customer_name,
                            receipt_detail_pdf.updated_at as order_date
                        FROM receipt_detail_pdf
                        LEFT JOIN receipts_pdf
                        ON receipt_detail_pdf.receipt_id = receipts_pdf.receipt_id
                        LEFT JOIN customers
                        ON receipt_detail_pdf.customer_id = customers.id
                        WHERE DATE(receipt_detail_pdf.updated_at) = CURDATE()
                        GROUP BY receipt_detail_pdf.receipt_id
                        ORDER BY receipt_detail_pdf.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceiptDetail($receipt_id)
    {
        $this->db->query('SELECT 
                            receipt_detail_pdf.*,
                            receipts_pdf.sum_total,
                            customers.name as customer_name,
                            customers.name_zawgyi as customer_name_zawgyi,
                            stocks.name as stock_name,
                            stocks.name_zawgyi as stock_name_zawgyi
                        FROM receipt_detail_pdf 
                        LEFT JOIN receipts_pdf
                        ON receipt_detail_pdf.receipt_id = receipts_pdf.receipt_id
                        INNER JOIN stocks
                        ON receipt_detail_pdf.stock_id = stocks.stocks_shortcut_id
                        LEFT JOIN customers
                        ON receipt_detail_pdf.customer_id = customers.id
                        WHERE receipt_detail_pdf.receipt_id = :receipt_id
                        ORDER BY receipt_detail_pdf.disp_sort ASC');
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        return $this->db->resultSet();
    }

    public function addReceiptDetail($data)
    {
        $this->db->query("INSERT INTO receipt_detail_pdf (receipt_id, stock_id, customer_id, qty, customer_price, total, disp_sort, created_at, updated_at) VALUES (:receipt_id, :stock_id, :customer_id, :qty, :customer_price, :total, :disp_sort, :created_at ,:updated_at)");
        //Bind Values
        $this->db->bind(':receipt_id', $data['receipt_id']);
        $this->db->bind(':stock_id', $data['stock_id']);
        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':qty', $data['qty']);
        $this->db->bind(':customer_price', $data['customer_price']);
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
        $this->db->query("SELECT CASE WHEN MAX(receipt_id) IS NULL THEN 1 ELSE MAX(receipt_id) + 1 end as receipt_id FROM receipt_detail_pdf");
                        
        return $this->db->single();
    }
}
