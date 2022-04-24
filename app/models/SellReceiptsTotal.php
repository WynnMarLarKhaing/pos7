<?php
class SellReceiptsTotal
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getReceiptsTotal($receipt_id)
    {
        $this->db->query('SELECT 
                            sellreceipts_total.*,
                            stocks.name as stock_name,
                            stocks.name_zawgyi as stock_name_zawgyi
                        FROM sellreceipts_total 
                        INNER JOIN stocks
                        ON sellreceipts_total.stock_id = stocks.stocks_shortcut_id
                        WHERE sellreceipts_total.receipt_id = :receipt_id
                        ORDER BY sellreceipts_total.disp_sort ASC');
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        return $this->db->resultSet();
    }

    public function getReceiptsToday()
    {
        $this->db->query('SELECT 
                            sellReceipt_detail_pdf.*,
                            sellReceipts_pdf.*,
                            customers.name as customer_name,
                            sellReceipt_detail_pdf.updated_at as order_date
                        FROM sellReceipt_detail_pdf
                        LEFT JOIN sellReceipts_pdf
                        ON sellReceipt_detail_pdf.receipt_id = sellReceipts_pdf.receipt_id
                        LEFT JOIN customers
                        ON sellReceipt_detail_pdf.customer_id = customers.id
                        WHERE DATE(sellReceipt_detail_pdf.updated_at) = CURDATE()
                        GROUP BY sellReceipt_detail_pdf.receipt_id
                        ORDER BY sellReceipt_detail_pdf.receipt_id DESC');
        return $this->db->resultSet();
    }

    public function getReceiptDetail($receipt_id)
    {
        $this->db->query('SELECT 
                            sellReceipt_detail_pdf.*,
                            sellReceipts_pdf.sum_total,
                            customers.name as customer_name,
                            customers.name_zawgyi as customer_name_zawgyi,
                            stocks.name as stock_name,
                            stocks.name_zawgyi as stock_name_zawgyi
                        FROM sellReceipt_detail_pdf 
                        LEFT JOIN sellReceipts_pdf
                        ON sellReceipt_detail_pdf.receipt_id = sellReceipts_pdf.receipt_id
                        INNER JOIN stocks
                        ON sellReceipt_detail_pdf.stock_id = stocks.stocks_shortcut_id
                        LEFT JOIN customers
                        ON sellReceipt_detail_pdf.customer_id = customers.id
                        WHERE sellReceipt_detail_pdf.receipt_id = :receipt_id
                        ORDER BY sellReceipt_detail_pdf.disp_sort ASC');
        //Bind Values
        $this->db->bind(':receipt_id', $receipt_id);

        return $this->db->resultSet();
    }

    public function addSellReceiptsTotal($data)
    {
        $this->db->query("INSERT INTO sellreceipts_total (receipt_id, stock_id, qty, disp_sort, created_at, updated_at) VALUES (:receipt_id, :stock_id, :qty, :disp_sort, :created_at ,:updated_at)");
        //Bind Values
        $this->db->bind(':receipt_id', $data['receipt_id']);
        $this->db->bind(':stock_id', $data['stock_id']);
        $this->db->bind(':qty', $data['qty']);
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
        $this->db->query("DELETE FROM sellreceipts_total WHERE receipt_id IN (:receipt_id)");
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
        $this->db->query("SELECT CASE WHEN MAX(receipt_id) IS NULL THEN 1 ELSE MAX(receipt_id) + 1 end as receipt_id FROM sellReceipt_detail_pdf");
                        
        return $this->db->single();
    }
}
