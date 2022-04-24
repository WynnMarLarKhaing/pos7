<?php
class SellReceipts extends Controller
{
    public function __construct()
    {
        // if (!isLoggedIn()) {
        //     redirect('/users/login');
        // }

        $this->receiptDetailModel = $this->model('SellReceipDetail');
        $this->receiptModel = $this->model('SellReceipt');
        $this->receiptDetailPdfModel = $this->model('SellReceipDetailPdf');
        $this->receiptPdfModel = $this->model('SellReceiptsPdf');
        $this->SellReceiptsTotal = $this->model('SellReceiptsTotal');
        $this->customerModel = $this->model('Customer');
        $this->stockModel = $this->model('Stock');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $receipts = $this->receiptDetailModel->getReceipts();

        $data = [
            'receipts' => $receipts
        ];
        // printPdf1();
        $this->view('sellReceipts/index', $data);
    }

    public function receiptsToday()
    {
        $receipts = $this->receiptDetailModel->getReceiptsToday();

        $sum = $this->receiptModel->getTotalToday();

        $data = [
            'receipts' => $receipts,
            'sum' => $sum,
        ];
        // printPdf1();
        $this->view('sellReceipts/receiptsToday', $data);
    }

    public function add()
    {
        $customers = $this->customerModel->getSellers();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //customer order
            $orderType = 1; 
            $customer_id = $_POST['customer_id'];

            if($_POST['temp_save']){
                //temporary save
                $saveType = 1; 
            }else if($_POST['save']){
                //save
                $saveType = 2; 
            }

            $lastInsertId = $this->receiptModel->getLastInsertId()->receipt_id;

            //Insert receipts
            $data = [
                'receipt_id'    => $lastInsertId,
                'customer_id'   => $customer_id,
                'sum_total'     => $_POST['sum_total'],
                'order_type'    => $orderType,
                'save_type'     => $saveType,
            ];

            if ($this->receiptModel->addReceipt($data)) {
                flash('post_message', 'Post Added');
            } else {
                die("Something went wrong!");
            }

            //Insert receipt_detail
            foreach($_POST['stock_id'] as $key => $stock_id) {
                if($stock_id && $_POST['qty'][$key]){
                    $data1 = [
                            'receipt_id'    => $lastInsertId,
                            'stock_id'      => $stock_id,
                            'customer_id'   => $customer_id,
                            'qty'           => $_POST['qty'][$key],
                            'customer_price'  => 0,
                            'total'           => $_POST['total'][$key] ? $_POST['total'][$key] : 0,
                            'disp_sort'     => $key + 1,
                        ];
                    if ($this->receiptDetailModel->addReceiptDetail($data1)) {
                        flash('post_message', 'Post Added');
                    } else {
                        die("Something went wrong!");
                    }
                }
            }
            // die();

            //Insert receipts
            $dataPdf = [
                'receipt_id'    => $lastInsertId,
                'customer_id'   => $customer_id,
                'sum_total'     => $_POST['sum_totalMm'],
                'order_type'    => $orderType,
                'save_type'     => $saveType,
            ];

            if ($this->receiptPdfModel->addReceipt($dataPdf)) {
                flash('post_message', 'Post Added');
            } else {
                die("Something went wrong!");
            }

            //Insert receipt_detail
            foreach($_POST['stock_id'] as $key => $stock_id) {
                if($stock_id && $_POST['qty'][$key]){
                    $dataPdf1 = [
                            'receipt_id'    => $lastInsertId,
                            'stock_id'      => $stock_id,
                            'customer_id'   => $customer_id,
                            'qty'           => $_POST['qtyMm'][$key],
                            'customer_price'  => 0,
                            'total'           => $_POST['totalMm'][$key],
                            'disp_sort'     => $key + 1,
                        ];
                    if ($this->receiptDetailPdfModel->addReceiptDetail($dataPdf1)) {
                        flash('post_message', 'Post Added');
                    } else {
                        die("Something went wrong!");
                    }
                }
            }

            //Insert sellreceipts_total
            foreach($_POST['total_stock_id'] as $key => $stock_id) {
                if($stock_id && $_POST['total_stock_qty'][$key]){
                    $dataPdf1 = [
                            'receipt_id'    => $lastInsertId,
                            'stock_id'      => $stock_id,
                            'qty'           => $_POST['total_stock_qty'][$key],
                            'disp_sort'     => $key + 1,
                        ];
                    if ($this->SellReceiptsTotal->addSellReceiptsTotal($dataPdf1)) {
                        flash('post_message', 'Post Added');
                    } else {
                        die("Something went wrong!");
                    }
                }
            }

            redirect('sellReceipts/receiptsToday');

        } else {

            $stocks = $this->stockModel->getStocks();

            $data = [
                'stocks' => $stocks,
                'customers' => $customers
            ];
        }

        $this->view('sellReceipts/add', $data);
    }

    public function edit($receipt_id)
    {
        $customers = $this->customerModel->getSellers();

        $receipt = $this->receiptModel->getReceipt($receipt_id);

        $receiptDetail = $this->receiptDetailModel->getReceiptDetail($receipt_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $orderType = 1; //customer order
            $customer_id = $_POST['customer_id'];

            if($_POST['temp_save']){
                $saveType = 1; //temporary save
            }else if($_POST['save']){
                $saveType = 2; //save
            }
            
            $data = [
                'receipt_id'    => $receipt_id,
                'customer_id'   => $_POST['customer_id'],
                'sum_total'     => $_POST['sum_total'],
                'order_type'    => $orderType,
                'save_type'     => $saveType,
            ];

            if ($this->receiptModel->updateReceipt($data)) {
                flash('post_message', 'Post Added');
                // redirect('sellReceipts/receiptsToday');
            } else {
                die("Something went wrong!");
            }

            //Reinsert receipt_detail
            if($this->receiptDetailModel->deleteReceiptDetail($receipt_id)){
                foreach($_POST['stock_id'] as $key => $stock_id) {
                    if($stock_id && $_POST['qty'][$key]){
                        $data1 = [
                            'receipt_id'    => $receipt_id,
                            'stock_id'      => $stock_id,
                            'customer_id'   => $customer_id,
                            'qty'           => $_POST['qty'][$key],
                            'customer_price'  => $_POST['customer_price'][$key],
                            'total'           => $_POST['total'][$key] ? $_POST['total'][$key] : 0,
                            'disp_sort'     => $key + 1,
                        ];
                        if ($this->receiptDetailModel->addReceiptDetail($data1)) {
                            flash('post_message', 'Post Added');
                            // redirect('sellReceipts/receiptsToday');
                        } else {
                            die("Something went wrong!");
                        }
                    }
                }
            }

            $data = [
                'receipt_id'    => $receipt_id,
                'customer_id'   => $_POST['customer_id'],
                'sum_total'     => $_POST['sum_totalMm'],
                'order_type'    => $orderType,
                'save_type'     => $saveType,
            ];

            if ($this->receiptPdfModel->updateReceipt($data)) {
                flash('post_message', 'Post Added');
                // redirect('sellReceipts/receiptsToday');
            } else {
                die("Something went wrong!");
            }

            //Reinsert receipt_detail
            if($this->receiptDetailPdfModel->deleteReceiptDetail($receipt_id)){
                foreach($_POST['stock_id'] as $key => $stock_id) {
                    if($stock_id && $_POST['qty'][$key]){
                        $data1 = [
                            'receipt_id'    => $receipt_id,
                            'stock_id'      => $stock_id,
                            'customer_id'   => $customer_id,
                            'qty'           => $_POST['qtyMm'][$key],
                            'customer_price'  => 0,
                            'total'           => $_POST['totalMm'][$key],
                            'disp_sort'     => $key + 1,
                        ];
                        if ($this->receiptDetailPdfModel->addReceiptDetail($data1)) {
                            flash('post_message', 'Post Added');
                            // redirect('sellReceipts/receiptsToday');
                        } else {
                            die("Something went wrong!");
                        }
                    }
                }
            }

            //Insert sellreceipts_total
            if($this->SellReceiptsTotal->deleteReceiptDetail($receipt_id)){
                foreach($_POST['total_stock_id'] as $key => $stock_id) {
                    if($stock_id && $_POST['total_stock_qty'][$key]){
                        $dataPdf1 = [
                                'receipt_id'    => $receipt_id,
                                'stock_id'      => $stock_id,
                                'qty'           => $_POST['total_stock_qty'][$key],
                                'disp_sort'     => $key + 1,
                            ];
                        if ($this->SellReceiptsTotal->addSellReceiptsTotal($dataPdf1)) {
                            flash('post_message', 'Post Added');
                        } else {
                            die("Something went wrong!");
                        }
                    }
                }
            }

            redirect('sellReceipts/receiptsToday');

        } else {

            $stocks = $this->stockModel->getStocks();

            $data = [
                'stocks'        => $stocks,
                'customers'     => $customers,
                'receipt'       => $receipt,
                'receiptDetail' => $receiptDetail,
            ];

        }
        $this->view('sellReceipts/edit', $data);
    }

    public function show($id)
    {
        $customer = $this->customerModel->getPostById($id);
        // $user = $this->userModel->getUserById($post->user_id);

        $data = [
            'customer' => $customer,
        ];
        $this->view('customers/show', $data);
    }

    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->receiptDetailModel->deleteReceipt($id)) {
                flash('post_message', 'Post deleted');
                redirect('customers');
            } else {
                die("Something went wrong");
            }
        } else {
            redirect('customers');
        }
    }

    public function download($receipt_id)
    {
        $receipts = $this->receiptDetailModel->getReceiptDetail($receipt_id);

        $receiptsTotal = $this->SellReceiptsTotal->getReceiptsTotal($receipt_id);

        $data = [
            'receipts' => $receipts,
            'receiptsTotal' => $receiptsTotal,
            'receipt_id' => $receipt_id,
        ];

        printSellReceipt($data, "D");
    }

    public function print($receipt_id)
    {
        $receipts = $this->receiptDetailModel->getReceiptDetail($receipt_id);

        $receiptsTotal = $this->SellReceiptsTotal->getReceiptsTotal($receipt_id);

        $data = [
            'receipts' => $receipts,
            'receiptsTotal' => $receiptsTotal,
            'receipt_id' => $receipt_id,
        ];

        printSellReceipt($data, "I");
    }
}
