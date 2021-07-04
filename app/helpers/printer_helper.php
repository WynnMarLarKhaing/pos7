<?php

//Print
function printPdf()
{
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 002');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('times', 'BI', 20);

    // add a page
    $pdf->AddPage();

    // set some text to print
    $txt = <<<EOD
TCPDF Example 002

Default page header and footer are disabled using setPrintHeader() and setPrintFooter() methods.
EOD;

    // print a block of text using Write()
    $pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

    // ---------------------------------------------------------

    //Close and output PDF document
    $pdf->Output('example_002.pdf', 'D');
}

function printPdf1()
{
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,  array(300, 100), true, 'UTF-8', false);
    // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(10, 10, 10, true);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // ---------------------------------------------------------
    // set default font subsetting mode
    // $pdf->SetFont('mm3', '', 11);
    // $pdf->SetFont('ddd', '', 11);
    $pdf->SetFont('aaa', '', 11);
    // $pdf->SetFont('myanmar1', '', 11);
    $pdf->AddPage();

    $content = '';

    $content .= '
        <style>
            h3 {
                font-size: 24pt;
                text-decoration: underline;
            }
            table.first{
                border: 0.5px solid #000;
            }
            td.first-row{
                border: 1px solid #000;
                background-color:#C8C8C8;
            }   
            td.third-row{
                border: 1px solid #000;
            }
            td.second-row{
                border-left: 1px solid #000;
            }
            table.first td{
                line-height: 20px;
            }
        </style>
        
        <p>အန်တီလေး
            <br>Phone&nbsp;&nbsp;&nbsp;: 09-975708911
            <br>Address : ဘုရားစျေးအနီးဘုရားစျေးအနီး
        </p>
        <table class="first">
            <tr>
                <td align="center" width="30" class="first-row">NO</td>
                <td align="center" width="70" class="first-row">အမ်ိဳးအမည္</td>
                <td align="center" width="40" class="first-row">ႏွုန္း</td>
                <td align="center" width="40" class="first-row">QTY</td>
                <td align="center" width="50" class="first-row">စုစုေပါင္း</td>
            </tr>
            <tr>
                <td align="center" class="second-row">1</td>
                <td align="left" class="second-row">သံ</td>
                <td align="right" class="second-row">200</td>
                <td align="right" class="second-row">1</td>
                <td align="right" class="second-row">200</td>
            </tr>
            <tr>
                <td align="center" class="second-row">1</td>
                <td align="left" class="second-row">သံ</td>
                <td align="right" class="second-row">200</td>
                <td align="right" class="second-row">1</td>
                <td align="right" class="second-row">200</td>
            </tr>
            <tr>
                <td align="center" class="second-row">1</td>
                <td align="left" class="second-row">သံ</td>
                <td align="right" class="second-row">200</td>
                <td align="right" class="second-row">1</td>
                <td align="right" class="second-row">200</td>
            </tr>
            <tr>
                <td align="center" class="second-row">1</td>
                <td align="left" class="second-row">သံ</td>
                <td align="right" class="second-row">200</td>
                <td align="right" class="second-row">1</td>
                <td align="right" class="second-row">200</td>
            </tr>
            <tr>
                <td colspan="4" align="right" style="border-left-style: none;" class="third-row">TOTAL</td>
                <td class="third-row">200,000</td>
            </tr>
        </table>
    ';

    // $content .= fetch_data();
    // $content .= '</table>';
    $pdf->writeHTML($content);
    if (isset($_POST['create_pdf'])) {
        $pdf->Output('test.pdf', 'D');
    } else {
        $pdf->Output('test.pdf', 'I');
    }
}

function printReceipt($data, $type)
{
    $searchReplaceArray = array(
                            '0' => '၀', 
                            '1' => '၁',
                            '2' => '၂',
                            '3' => '၃',
                            '4' => '၄',
                            '5' => '၅',
                            '6' => '၆',
                            '7' => '၇',
                            '8' => '၈',
                            '9' => '၉'
                        );
     
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,  array(300, 100), true, 'UTF-8', false);
    $pdf->SetMargins(10, 10, 10, true);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // ---------------------------------------------------------
    $pdf->SetFont('aaa', '', 11);
    $pdf->AddPage();

    $content = '';

    $receipt_id = $data['receipt_id'];
    $customer_name_list = array_column($data['receipts'], 'customer_name_zawgyi');
    $customer_name = $customer_name_list[0];

    $updated_date_list = array_column($data['receipts'], 'updated_at');
    $updated_date = date_create($updated_date_list[0]);

    $content .= '
        <style>
            h3 {
                font-size: 24pt;
                text-decoration: underline;
            }
            table.first{
                border: 0.5px solid #000;
            }
            td.first-row{
                border: 1px solid #000;
                background-color:#C8C8C8;
            }   
            td.third-row{
                border: 1px solid #000;
                text-align: right;
            }
            td.second-row{
                border-left: 1px solid #000;
            }
            table.first td{
                line-height: 20px;
            }
        </style>
        
        <p>ေန႔စြဲ - '. date_format($updated_date ,"Y/m/d") .
            '<br>အမည္ - '. $customer_name .'
            <br>ဆိုင္ဖုန္း  -  ၀၉၇၈၂၄၄၅၁၁၈
            <br>No - '. $receipt_id .'
        </p>
        <table class="first">
            <tr>
                <td align="center" width="30" class="first-row">စဥ္</td>
                <td align="center" width="70" class="first-row">အမည္</td>
                <td align="center" width="40" class="first-row">ႏႈန္း</td>
                <td align="center" width="40" class="first-row">Qty</td>
                <td align="center" width="50" class="first-row">စုစုေပါင္း</td>
            </tr>
    ';

    $sum = 0;

    foreach($data['receipts'] as $key => $val){
        $total = round($val->total);

        $sum += round($val->total);

        $customer_price = str_replace(array_keys($searchReplaceArray), array_values($searchReplaceArray), $val->customer_price); 
        $qty = str_replace(array_keys($searchReplaceArray), array_values($searchReplaceArray), $val->qty + 0); 
        $total = str_replace(array_keys($searchReplaceArray), array_values($searchReplaceArray), $total); 
        $sum_total = str_replace(array_keys($searchReplaceArray), array_values($searchReplaceArray), $sum); 

        $content .= '
                        <tr>
                            <td align="center" class="second-row">'. ($key + 1) .'</td>
                            <td align="left" class="second-row">' .$val->stock_name_zawgyi. '</td>
                            <td align="right" class="second-row">' . $customer_price . '</td>
                            <td align="right" class="second-row">' . $qty . '</td>
                            <td align="right" class="second-row">' . $total . '</td>
                        </tr>
                    ';
    }

    $content .= '
                    <tr>
                        <td colspan="4" align="right" style="border-left-style: none;" class="third-row">စုစုေပါင္း</td>
                        <td class="third-row">'. str_replace(array_keys($searchReplaceArray), array_values($searchReplaceArray), $sum) .'</td>
                    </tr>
                ';

    $content .= '</table>';

    $pdf->writeHTML($content);

    $pdf->Output($receipt_id.'.pdf', $type);
}