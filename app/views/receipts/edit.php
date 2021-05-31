<?php require_once APPROOT . "/views/inc/header.php" ?>
<a href="<?php echo URLROOT; ?>/receipts" class="btn btn-light"><i class="fa fa-backward"></i> ရှေ့စာမျက်နှာသို့</a>
<div class="card-body bg-light mt-3">
    <h4>ပစ္စည်းနံပါတ်များ</h4>
    </br>
    <div class="container">
        <div class="row">
            <?php foreach ($data['stocks'] as $key => $stock) : ?>
                <h5 class="ml-3"><span class="badge badge-warning" id='<?php echo $stock->stocks_shortcut_id;?>' data-name='<?php echo $stock->name;?>' data-customer_price='<?php echo $stock->customer_price;?>' data-non_customer_price='<?php echo $stock->non_customer_price;?>'><?php echo $stock->name . " = " . $stock->stocks_shortcut_id; ?></span></h5>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<form action="<?php echo URLROOT; ?>/receipts/edit/<?php echo $data['receipt']->receipt_id; ?>" method="post">
    <div class="mt-2 col-4">
        <?php if($data['receipt']->save_type): ?>
            <select class="form-control form-select" aria-label="Default select example" name="customer_id" id="customer_id">
                <option selected value="0">အထမ်းရွေးရန်</option>
                <?php foreach ($data['customers'] as $key => $customer) : ?>
                    <option value="<?php echo $customer->id;?>" <?php echo $customer->id == $data['receipt']->customer_id ? "selected" : "";?> ><?php echo $customer->name;?></option>
                <?php endforeach; ?>
            </select>
        <?php else: ?>
            <span>အမည် - <?= $data['receipt']->customer_name; ?></span>
        <?php endif; ?>
    </div>
    <div class="row mt-2">
        <?php if($data['receipt']->save_type): ?>
            <div class="col-12">
                <table class="table table-bordered" id="invoiceTable">
                    <thead>
                        <tr style="background: cornsilk;">
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">အမျိုးအမည်</th>
                        <th scope="col">အရေအတွက်</th>
                        <th scope="col">နှုန်း</th>
                        <th scope="col">စုစုပေါင်း</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['receiptDetail'] as $key => $receipt) : ?>
                        <?php $index = $key +1 ;?>
                        <tr>
                            <th scope="row"><?php echo $index;?></th>
                            <td><input type="text" class="form-control stocks_shortcut_id" name="stock_id[]" value="<?php echo $receipt->stock_id;?>" autocomplete="off"/></td>
                            <td><span id="name<?php echo $index;?>"><?php echo $receipt->stock_name;?></span></td>
                            <td>
                                <input type="text" class="form-control qty" id="qty<?php echo $index;?>" name="qty[]" value="<?php echo $receipt->qty + 0;?>" autocomplete="off"/>
                                <input type="hidden" class="form-control qtyMm" id="qtyMm<?php echo $index;?>" name="qtyMm[]"/>
                            </td>
                            <td>
                                <span id="price<?php echo $index;?>"><?php echo $receipt->customer_price;?></span>
                                <input type="hidden" class="form-control customer_price" id="customer_price<?php echo $index;?>" name="customer_price[]" value="<?php echo $receipt->customer_price;?>"/>
                                <input type="hidden" class="form-control customer_priceMm" id="customer_priceMm<?php echo $index;?>" name="customer_priceMm[]"/>
                            </td>
                            <td>
                                <span id="totalSpan<?php echo $index;?>"><?php echo $receipt->customer_price * $receipt->qty;?></span>
                                <input type="hidden" class="form-control total" id="total<?php echo $index;?>" name="total[]" value="<?php echo $receipt->total;?>"/>
                                <input type="hidden" class="form-control totalMm" id="totalMm<?php echo $index;?>" name="totalMm[]"/>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th scope="row"><?php echo $index + 1; ?></th>
                            <td><input type="text" class="form-control stocks_shortcut_id" name="stock_id[]" autocomplete="off" /></td>
                            <td><span id="name<?php echo $index + 1; ?>"></span></td>
                            <td>
                                <input type="text" class="form-control qty d-none" id="qty<?php echo $index + 1; ?>" name="qty[]" autocomplete="off"/>
                                <input type="hidden" class="form-control qtyMm" id="qtyMm<?php echo $index + 1;?>" name="qtyMm[]"/>
                            </td>
                            <td>
                                <span id="price<?php echo $index + 1; ?>"></span>
                                <input type="hidden" class="form-control customer_price" id="customer_price<?php echo $index + 1; ?>" name="customer_price[]"/>
                                <input type="hidden" class="form-control customer_priceMm" id="customer_priceMm<?php echo $index + 1;?>" name="customer_priceMm[]"/>
                            </td>
                            <td>
                                <span id="totalSpan<?php echo $index + 1; ?>">0</span>
                                <input type="hidden" class="form-control total" id="total<?php echo $index + 1; ?>" name="total[]" value="0"/>
                                <input type="hidden" class="form-control totalMm" id="totalMm<?php echo $index + 1;?>" name="totalMm[]"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered" style="margin-top:-17px;">
                    <tbody>
                        <tr>
                            <td>စုစုပေါင်း</td>
                            <td>
                                <span id="allSum"><?php echo $data['receipt']->sum_total; ?></span>
                                </span><input type="hidden" class="form-control" id="sum_total" name="sum_total" value="<?php echo $data['receipt']->sum_total; ?>"/>
                                <input type="hidden" class="form-control" id="sum_totalMm" name="sum_totalMm"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="col-12">
                <table class="table table-bordered" id="invoiceTable">
                    <thead>
                        <tr style="background: cornsilk;">
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">အမျိုးအမည်</th>
                        <th scope="col">အရေအတွက်</th>
                        <th scope="col">နှုန်း</th>
                        <th scope="col">စုစုပေါင်း</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['receiptDetail'] as $key => $receipt) : ?>
                        <?php $index = $key +1 ;?>
                        <tr>
                            <th scope="row"><?php echo $index;?></th>
                            <td>
                                <span><?php echo $receipt->stock_id;?></span>
                            </td>
                            <td><span id="name<?php echo $index;?>"><?php echo $receipt->stock_name;?></span></td>
                            <td>
                                <span><?php echo $receipt->qty + 0;?></span>
                            </td>
                            <td>
                                <span id="price<?php echo $index;?>"><?php echo $receipt->customer_price;?></span>
                                <input type="hidden" class="form-control customer_price" id="customer_price<?php echo $index;?>" name="customer_price[]" value="<?php echo $receipt->customer_price;?>"/>
                            </td>
                            <td>
                                <span id="totalSpan<?php echo $index;?>"><?php echo $receipt->customer_price * $receipt->qty;?></span>
                                <input type="hidden" class="form-control total" id="total<?php echo $index;?>" name="total[]" value="<?php echo $receipt->total;?>"/>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table class="table table-bordered" style="margin-top:-17px;">
                    <tbody>
                        <tr>
                            <td>စုစုပေါင်း</td>
                            <td>
                                <span id="allSum">0</span>
                                </span><input type="hidden" class="form-control" id="sum_total" name="sum_total" value="<?php echo $data['receipt']->sum_total; ?>"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div class= "text-right">
        <input type="submit" class="btn btn-danger" value="ခဏသိမ်းမည်" name="temp_save" id="temp_save">
        <input type="submit" class="btn btn-success" value="သိမ်းမည်" name="save" id="save">
    </div>
</form>
<?php require_once APPROOT . "/views/inc/footer.php" ?>
<script>
    $(document).ready(function(){
        allSum();

        var ids;
        var customer_id;
        $(document).on("focus",".stocks_shortcut_id",function(e){
            ids = $(this).closest('tr').index() + 2;
            var td = '<tr><th scope="row">' + ids + '</th><td><input type="text" class="form-control stocks_shortcut_id" name="stock_id[]" autocomplete="off" /></td><td><span id="name' + ids + '"></span></td><td><input type="text" class="form-control qty d-none" id="qty' + ids + '" name="qty[]" autocomplete="off"/><input type="hidden" class="form-control qtyMm" id="qtyMm' + ids + '" name="qtyMm[]"/></td><td><span id="price' + ids + '"></span><input type="hidden" class="form-control customer_price" id="customer_price' + ids + '" name="customer_price[]"/><input type="hidden" class="form-control customer_priceMm" id="customer_priceMm' + ids + '" name="customer_priceMm[]"/></td><td><span id="totalSpan' + ids + '"></span><input type="hidden" class="form-control total" id="total' + ids + '" name="total[]"/><input type="hidden" class="form-control totalMm" id="totalMm' + ids + '" name="totalMm[]"/></td></tr>';
            if($(this).parent().parent().is(':last-child')){
                $('#invoiceTable tr:last').after(td);
            }
        });

        $(document).on("input",".stocks_shortcut_id",function(e){
            customer_id = $("#customer_id").val();
            if(customer_id >= 1){
                var id = $(this).val();
                var index = $(this).closest('tr').index() + 1;
                if(id){
                    console.log("if");
                    var name = $("#" + id).data("name");
                    var customer_price = $("#" + id).data("customer_price");
                    if(name != undefined){
                        console.log("name exit");
                        console.log(index);
                        $("#name" + index).text(name);
                        $("#price" + index).text(customer_price);
                        $("#customer_price" + index).val(customer_price);
                        $("#qty" + index).removeClass('d-none');
                        $(".qty").trigger("input");
                        allSum();
                    }else{
                        console.log("name not exit");
                        $(this).focus();
                        $("#qty" + index).addClass('d-none');
                        $("#name" + index).text("");
                        $("#price" + index).text("");
                        $("#customer_price" + index).val("");
                        $("#totalSpan" + index).text("");
                        $("#total" + index).val("");
                    }
                }else{
                    console.log("else");
                    $(this).focus();
                    $("#qty" + index).addClass('d-none');
                    $("#name" + index).text("");
                    $("#price" + index).text("");
                    $("#customer_price" + index).val("");
                    $("#totalSpan" + index).text("");
                    $("#total" + index).val("");
                }
            }else{
                alert("အထမ်းအရင်ရွေးပါ...");
                $(this).val("");
                return false;
            }
        });

        $(document).on("input",".qty",function(e){
            var qty = $(this).val();
            var index = $(this).closest('tr').index() + 1;
            var customer_price = $("#price" + index).text();
            var mul = Math.round(qty * customer_price);
            $("#totalSpan" + index).text(mul);
            $("#total" + index).val(mul);
            allSum();
        });

        $("#temp_save").click(function(e){
            fontChangeMethodCall();
        });

        $("#save").click(function(e){
            fontChangeMethodCall();
        });

    });

    function allSum(){
        var sum = 0;
        $(".total").each(function() {
            sum += parseInt($(this).val());
        });
        $("#allSum").text(sum);
        $("#sum_total").val(sum);
    }

    function fontChangeMethodCall(){
        $(".total").each(function(index,item) {
            fontChange($(this).val());
            $("#totalMm" + (index + 1)).val(fontChange($(this).val()));
        });

        $(".qty").each(function(index,item) {
            fontChange($(this).val());
            $("#qtyMm" + (index + 1)).val(fontChange($(this).val()));
        });

        $(".customer_price").each(function(index,item) {
            fontChange($(this).val());
            $("#customer_priceMm" + (index + 1)).val(fontChange($(this).val()));
        });

        $("#sum_totalMm").val(fontChange($("#sum_total").val()));
    }

    function fontChange(value){
        const chars = value.split('');
        var x = '';
        $.each(chars, function(index, value) { 
            switch (value) { 
                case '0': 
                    x += 'o';
                    break;
                case '1': 
                    x += '၁';
                    break;
                case '2': 
                    x += '၂';
                    break;		
                case '3': 
                    x += '၃';
                    break;
                case '4': 
                    x += '၄';
                    break;
                case '5': 
                    x += '၅';
                    break;
                case '6': 
                    x += '6';
                    break;
                case '7': 
                    x += '၇';
                    break;
                case '8': 
                    x += '၈';
                    break;
                case '9': 
                    x += '၉';
                    break;
                case '.': 
                    x += '.';
                    break;
            }
        });
        return x;
    }
</script>