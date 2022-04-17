<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/customers">အထမ်းများ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/stocks">ပစ္စည်းစာရင်းများ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/receipts/receiptsToday">ယနေ့အဝယ်</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/receipts">အဝယ်စာရင်းများ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/receipts/add">အဝယ်အသစ်ထည့်မယ်</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="clearBuyHistory" href="<?php echo URLROOT; ?>/customers/clear">အဝယ်ဘောင်ချာတွေရှင်းမယ်</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-md navbar-light mb-3" style="background-color: lightgrey;">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/sellers">ဒိုင်များ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/sellReceipts">အရောင်းစာရင်းများ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT; ?>/sellReceipts/add">အရောင်းအသစ်ထည့်မယ်</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-none" id="clearSellHistory" href="<?php echo URLROOT; ?>/sellers/clear">အရောင်းဘောင်ချာတွေရှင်းမယ်</a>
                </li>
            </ul>
        </div>
    </div>
</nav>