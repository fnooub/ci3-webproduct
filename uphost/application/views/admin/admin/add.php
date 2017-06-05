<?php
$this->load->view('admin/admin/head');
?>
<div class="wrapper">
    <div class="widget">

        <div class="title">
            <h6> Them quan tri Thành viên</h6>
        </div>
        <form class="form" id="form" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <div class="formRow">
                    <label class="formLeft" for="param_name">Tên:<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="name" id="param_name" _autocheck="true"
                                                    value="<?php echo set_value('name'); ?>" type="text"></span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"><?php echo form_error('name'); ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label class="formLeft" for="param_username">Username<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="username" value="<?php echo set_value('username'); ?>"
                                                    id="param_username" _autocheck="true" type="text"></span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"><?php echo form_error('username'); ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label class="formLeft" for="param_password">Password:<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="password" id="param_password" _autocheck="true"
                                                    type="password"></span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"><?php echo form_error('password'); ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label class="formLeft" for="param_re_password">Re-Password:<span class="req">*</span></label>
                    <div class="formRight">
                        <span class="oneTwo"><input name="re_password" id="param_re_password" _autocheck="true"
                                                    type="password"></span>
                        <span name="name_autocheck" class="autocheck"></span>
                        <div name="name_error" class="clear error"><?php echo form_error('re_password'); ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="formRow">
                    <label class="formLeft" for="param_re_password">Quyen:<span class="req">*</span></label>
                    <div class="formRight">
                        <?php foreach ($config_permissions as $controller => $actions): ?>
                            <div>
                                <label><b><?php echo $controller ?> :</b></label>
                                <?php foreach ($actions as $action): ?>
                                    <!-- them ngoac vuong thu 2 la de nhan dc mang cac quyen, neu ko no chi nhan la 1 bien va dai dien cho thoi -->
                                    <label> <input type="checkbox" name="permissions[<?php echo $controller ?>][]"
                                                   value="<?php echo $action ?>">
                                        <?php echo $action ?></label>
                                <?php endforeach; ?>
                            </div>
                            <div class="clear"></div>
                        <?php endforeach; ?>
                        <div name="name_error" class="clear error"><?php echo form_error('re_password'); ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </fieldset>
            <div class="formSubmit">
                <input value="Thêm mới" class="redB" type="submit">
                <input value="Hủy bỏ" class="basic" type="reset">
            </div>
        </form>
    </div>


</div>
