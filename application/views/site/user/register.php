<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
        <h2>Register</h2>
    </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <h1>Đăng ký thành viên</h1>
        <form enctype="multipart/form-data" action="<?php echo site_url('user/register'); ?>" method="post"
              class="t-form form_action">
            <div class="form-row">
                <label class="form-label" for="param_email">Email:<span class="req">*</span></label>
                <div class="form-item">
                    <input value="<?php echo set_value('email'); ?>" name="email" id="email" class="input" type="text">
                    <div class="clear"></div>
                    <div id="email_error" class="error"><?php echo form_error('email'); ?></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-row">
                <label class="form-label" for="param_password">Mật khẩu:<span class="req">*</span></label>
                <div class="form-item">
                    <input name="password" id="password" class="input" type="password">
                    <div class="clear"></div>
                    <div id="password_error" class="error"><?php echo form_error('password'); ?></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-row">
                <label class="form-label" for="param_re_password">Gõ lại mật khẩu:<span class="req">*</span></label>
                <div class="form-item">
                    <input name="re_password" id="re_password" class="input" type="password">
                    <div class="clear"></div>
                    <div id="re_password_error" class="error"><?php echo form_error('re_password'); ?></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="form-row">
                <label class="form-label" for="param_name">Họ và tên:<span class="req">*</span></label>
                <div class="form-item">
                    <input value="<?php echo set_value('name'); ?>" name="name" id="name" class="input" type="text">
                    <div class="clear"></div>
                    <div id="name_error" class="error"><?php echo form_error('name'); ?></div>
                </div>
                <div class="clear"></div>
            </div>
            <!--<div class="form-row">
                <label class="form-label" for="param_phone">Số điện thoại:<span class="req">*</span></label>
                <div class="form-item">
                    <input value="" name="phone" id="phone" class="input" type="text">
                    <div class="clear"></div>
                    <div id="phone_error" class="error"></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-row">
                <label class="form-label" for="param_address">Địa chỉ:<span class="req">*</span></label>
                <div class="form-item">
                    <textarea name="address" id="address" class="input"></textarea>
                    <div class="clear"></div>
                    <div id="address_error" class="error"></div>
                </div>
                <div class="clear"></div>
            </div>-->
            <!-- <div class="form-row">
                 <label class="form-label" for="param_re_password">Ảnh đại diện:<span class="req">*</span></label>
                 <div class="form-item">
                     <input name="avata" id="avata" type="file">
                     <div class="clear"></div>
                     <div id="avata_error" class="error"></div>
                 </div>
                 <div class="clear"></div>
             </div>-->

            <div class="form-row">
                <label class="form-label">&nbsp;</label>
                <div class="form-item">
                    <input name="submit" value="Đăng ký" class="button" type="submit">
                </div>
            </div>
        </form>
        <div class="clear"></div>

    </div><!-- End box-content-center -->

</div>
