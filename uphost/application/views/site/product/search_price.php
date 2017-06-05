<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
        <h2>Result(s) for search: <?php echo number_format($price_from ).' to '.number_format($price_to).' VND';?></h2>
    </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <?php foreach ($list as $row): ?>
            <?php $name = convert_vi_to_en($row->name);
            $name = strtolower($name);
            $name = str_replace(' ','-',$name);
            ?>
            <div class="product_item">
                <h3>
                    <a href="<?php echo base_url($name.'-p'.$row->id); ?>" title="Sản phẩm">
                        <?php echo $row->name; ?>                     </a>
                </h3>
                <div class="product_img">
                    <a href="<?php echo base_url($name.'-p'.$row->id); ?>" title="Sản phẩm">
                        <img src="<?php echo base_url('upload/product/'.$row->image_link); ?>" alt="<?php echo $row->name; ?> ">
                    </a>
                </div>
                <p class="price">
                    <?php if ($row->discount > 0): ?>
                        <?php
                        $price_new = $row->price - $row->discount;
                        echo number_format($price_new);
                        echo '<span class="price_old">'.number_format($row->price).'</span>'
                        ?>
                    <?php else:
                        echo number_format($row->price);
                        ?>

                    <?php endif; ?>

                </p>
                <center>
                    <div class="raty" style="margin: 10px 0px; width: 100px;" id="9" data-score="4">
                    </div>
                </center>
                <div class="action">
                    <p style="float:left;margin-left:10px">Lượt xem: <b><?php echo $row->view; ?> </b></p>
                    <a class="button" href="them-vao-gio-9.html" title="Mua ngay">Mua ngay</a>
                    <div class="clear"></div>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="clear"></div>

    </div><!-- End box-content-center -->
</div>
