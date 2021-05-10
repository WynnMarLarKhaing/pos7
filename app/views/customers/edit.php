<?php require_once APPROOT . "/views/inc/header.php" ?>
<a href="<?php echo URLROOT; ?>/customers" class="btn btn-light"><i class="fa fa-backward"></i> ရှေ့စာမျက်နှာသို့</a>
<div class="card-body bg-light mt-3">
    <form action="<?php echo URLROOT; ?>/customers/edit/<?php echo $data['id']; ?>" method="post">
        <div class="form-group">
            <label for="name">name:<sup>*</sup></label>
            <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
            <span class="invalid-feedback"><?php echo (!empty($data['name_err'])) ? $data['name_err'] : ''; ?></span>
        </div>
        <div class="form-group">
            <label for="name">ပစ္စည်းအမည်(ဇော်ဂျီ)<sup>*</sup></label>
            <input type="text" name="name_zawgyi" class="form-control form-control-lg" value="<?php echo $data['name_zawgyi']; ?>">
        </div>
        <div class="form-group">
            <label for="phone">phone:<sup>*</sup></label>
            <input type="text" name="phone" class="form-control form-control-lg <?php echo (!empty($data['phone_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['phone']; ?>">
            <span class="invalid-feedback"> <?php echo (!empty($data['phone_err'])) ? $data['phone_err'] : ''; ?></span>
        </div>
        <div class="form-group">
            <label for="address">phone:<sup>*</sup></label>
            <input type="text" name="address" class="form-control form-control-lg" value="<?php echo $data['address']; ?>">
        </div>
        <input type="submit" class="btn btn-success" value="Update">
    </form>
</div>
<?php require_once APPROOT . "/views/inc/footer.php" ?>