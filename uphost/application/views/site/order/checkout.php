<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
        <h2>Thong tin khach hang</h2>
    </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <h1>So tien thanh toan : <b style="color: red"><?php echo number_format($amount);?></b></h1>
        <form enctype="multipart/form-data" action="<?php echo site_url('order/checkout'); ?>" method="post"
              class="t-form form_action">
            <div class="form-row">
                <label class="form-label" for="param_email">Email:<span class="req">*</span></label>
                <div class="form-item">
                    <input value="<?php echo isset($user->email)? $user->email : set_value('email'); ?>" name="email" id="email" class="input" type="text">
                    <div class="clear"></div>
                    <div id="email_error" class="error"><?php echo form_error('email'); ?></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-row">
                <label class="form-label" for="param_name">Họ và tên:<span class="req">*</span></label>
                <div class="form-item">
                    <input value="<?php echo isset($user->name)? $user->name : set_value('name'); ?>" name="name" id="name" class="input" type="text">
                    <div class="clear"></div>
                    <div id="name_error" class="error"><?php echo form_error('name'); ?></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="form-row">
                <label class="form-label" for="param_phone">Số điện thoại:<span class="req">*</span></label>
                <div class="form-item">
                    <input name="phone" id="phone" class="input" type="text" value="<?php echo isset($user->phone)? $user->phone : set_value('phone'); ?>">
                    <div class="clear"></div>
                    <div id="phone_error" class="error"><?php echo form_error('phone'); ?></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-row">
                <label class="form-label" for="param_address">Ghi chu:<span class="req">*</span></label>
                <div class="form-item">
                    <textarea name="message" id="message" class="input" ><?php echo set_value('message'); ?></textarea>
                    <div class="clear"></div>
                    <div id="address_error" class="error"><?php echo form_error('message'); ?></div>
                </div>
                <div class="clear"></div>
            </div>
            <p>Nhap dia chi va thoi gian giao hang</p>
            <div class="form-row">
                <label class="form-label" for="param_payment">Cong thanh toan:<span class="req">*</span></label>
                <div class="form-item">
                   <select name="payment">
                       <option value="">--- Lua chon cong thanh toan ---</option>
                       <option value="nganluong">Ngan Luong</option>
                       <option value="baokim">Bao Kim</option>
                       <option value="offline">Thanh toan khi nhan hang</option>
                   </select>
                    <div class="clear"></div>
                    <div id="payment_error" class="error"><?php echo form_error('payment'); ?></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-row">
                <label class="form-label">&nbsp;</label>
                <div class="form-item">
                    <input name="submit" value="Buy" class="button" type="submit">
                </div>
            </div>
        </form>
        <div class="clear"></div>

    </div><!-- End box-content-center -->

</div>
