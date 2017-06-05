<?php
// do da gui bien toan cuc this->data vao tat ca cac phan trong layout, nen nhan duoc
$price_from_select = isset($price_from) ? intval($price_from) : 0;
$price_to_select = isset($price_to) ? intval($price_to) : 0;
?>
<div class="box-left">
    <div class="title tittle-box-left">
        <h2> Tìm kiếm theo giá </h2>
    </div>
    <div class="content-box"><!-- The content-box -->
        <form class="t-form form_action" method="get" style="padding:10px" action="<?php echo site_url('product/search_price');?>"
              name="search_price">

            <div class="form-row">
                <label for="param_price_from" class="form-label" style="width:70px">Giá từ:<span
                        class="req">*</span></label>
                <div class="form-item" style="width:90px">
                    <select class="input" id="price_from" name="price_from">
                        <?php for ($i=0; $i<= 10000000; $i+= 1000000): ?>
                            <option <?php echo ($price_from_select == $i) ? 'selected':''; ?>
                                value = "<?php echo $i; ?>"><?php echo number_format($i); ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="clear"></div>
                    <div class="error" id="price_from_error"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="form-row">
                <label for="param_price_from" class="form-label" style="width:70px">Giá tới:<span
                        class="req">*</span></label>
                <div class="form-item" style="width:90px">
                    <select class="input" id="price_to" name="price_to">
                        <?php for ($i=0; $i<= 10000000; $i+= 1000000): ?>
                            <option <?php echo ($price_to_select == $i) ? 'selected':''; ?>
                                value = "<?php echo $i; ?>"><?php echo number_format($i); ?></option>
                        <?php endfor; ?>
                    </select>
                    <div class="clear"></div>
                    <div class="error" id="price_from_error"></div>
                </div>
                <div class="clear"></div>
            </div>

            <div class="form-row">
                <label class="form-label">&nbsp;</label>
                <div class="form-item">
                    <input class="button" name="search" value="Tìm kiềm"
                           style="height:30px !important;line-height:30px !important;padding:0px 10px !important"
                           type="submit">
                </div>
                <div class="clear"></div>
            </div>
        </form>
    </div><!-- End content-box -->
</div>


<div class="box-left">
    <div class="title tittle-box-left">
        <h2> Danh mục sản phẩm </h2>
    </div>
    <div class="content-box"><!-- The content-box -->
        <ul class="catalog-main">
            <?php foreach ($catalog_list as $row): ?>
                <!--luy y: Ten ko dc de tieng viet co dau, phai conveet lai -->
                <?php $name = convert_vi_to_en($row->name);
                $name = strtolower($name);
                ?>
            <li>
                <span><a href="<?php echo base_url($name.'-c'.$row->id); ?>" title="<?php echo $row->name; ?>"><?php echo $row->name; ?></a></span>
                <!-- lay danh sach danh muc con -->
                <?php if(!empty($row->subs)): ?>
                <ul class="catalog-sub">
                    <?php foreach ($row->subs as $subs): ?>
                        <?php $subs_name = convert_vi_to_en($subs->name);
                        $subs_name = strtolower($subs_name);
                        ?>
                    <li>
                        <a href="<?php echo base_url($subs_name.'-c'.$subs->id); ?>" title="<?php echo $subs->name; ?>">
                            <?php echo $subs->name; ?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
                    <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div><!-- End content-box -->
</div>
			  