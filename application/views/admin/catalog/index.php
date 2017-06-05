<?php
$this->load->view('admin/catalog/head');
?>
<div class="wrapper">
    <?php
    $this->load->view('admin/message', $this->data);
    ?>
    <div class="widget">

        <div class="title">
            <span class="titleIcon"><input id="titleCheck" name="titleCheck" type="checkbox"></span>
            <h6>Danh sách danh muc</h6>
            <div class="num f12">Tổng số: <b><?php echo $total; ?></b></div>
        </div>

        <form action="<?php echo admin_url('catalog/delete_check');?>" method="post" class="form" name="filter">
            <table class="sTable mTable myTable withCheck" id="checkAll" width="100%" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <td style="width:10px;"><img src="<?php echo public_url('admin'); ?>/images/icons/tableArrows.png">
                    </td>
                    <td style="width:80px;">Mã số</td>
                    <td style="width:80px;">Thu tu hien thi</td>
                    <td>Ten danh muc</td>
                    <td style="width:100px;">Hành động</td>
                </tr>
                </thead>

                <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="list_action itemActions">
                            <input type="submit" value="xoa da chon" class="button blueB">
                        </div>

                        <div class="pagination">
                        </div>
                    </td>
                </tr>
                </tfoot>

                <tbody>
                <!-- Filter -->
                <?php foreach ($list as $row): ?>
                    <tr>
                        <td><input name="id<?php echo $row->id; ?>" value="19" type="checkbox" value="<?php echo $row->id; ?>"></td>

                        <td class="textC"><?php echo $row->id; ?></td>
                        <td class="textC"><?php echo $row->sort_order; ?></td>

                        <td><span title="Hoàng văn Tuyền" class="tipS">
							<?php echo $row->name; ?>				</span></td>

                        <td class="option">
                            <a href="<?php echo admin_url('catalog/edit/'.$row->id); ?>" title="Chỉnh sửa"
                               class="tipS ">
                                <img src="<?php echo public_url('admin'); ?>/images/icons/color/edit.png">
                            </a>

                            <a href="<?php echo admin_url('catalog/delete/'.$row->id); ?>" title=" Xóa" class="tipS
                            verify_action">
                            <img src="<?php echo public_url('admin'); ?>/images/icons/color/delete.png">
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </form>
    </div>
</div>
<div class="clear mt30"></div>