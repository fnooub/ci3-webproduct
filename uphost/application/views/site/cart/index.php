<style type="text/css">
    table td {
        padding: 10px;
        border: solid 1px green;
    }

    thead tr td {
        font-weight: bold;
    }
    a
    {
        text-decoration: underline;
    }
</style>
<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
        <h2>Gio hang : <?php echo $total_items; ?></h2>
    </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <?php if($total_items > 0): //neu co san pham moi in ra table ?>
        <form action="<?php echo base_url('cart/update')?>" method="post">
        <table>
            <thead>
            <tr>
                <td>San pham</td>
                <td>Gia</td>
                <td>So luong</td>
                <td>Tong so</td>
                <td>Xoa</td>
            </tr>
            </thead>
            <tbody>
            <?php $total_amount = 0 ?>
            <?php foreach ($carts as $row): ?>
                <tr>
                    <td>
                        <img src="<?php echo base_url('upload/product/'.$row['image_link']) ?>" style="width:70px">
                        <?php echo $row['name'] ?>
                    </td>
                    <td><?php echo number_format($row['price']) ?></td>
                    <td ><input type="number" min="1" name="qty_<?php echo $row['id'] ?>" value="<?php echo $row['qty'] ?>" style="width:100px;"></td>
                    <td><?php echo number_format($row['subtotal']) ?></td>
                    <td><a href="<?php echo base_url('cart/del/'.$row['id']) ?>">Xoa</a></td>
                </tr>
                <?php $total_amount += $row['subtotal']; ?>
            <?php endforeach; ?>
            <tr><td colspan="5" style="text-align: right"><a href="<?php echo base_url('cart/del') ?>">Xoa toan bo</a></td> </tr>
            <tr>
                <td colspan="5">Tong so tien thanh toan: <b
                        style="color:red"><?php echo number_format($total_amount); ?></b></td>
            </tr>
            <tr><td colspan="5"><input type="submit" value="Update">
                    <a href="<?php echo base_url('order/checkout') ?>" class="button">Buy Now</a>
                </td></tr>
            </tbody>
        </table>
        </form>
        <?php else: echo "<h4>Cart is Empty!!!!  <a href='".base_url()."  '>Go back to buy</a></h4>"?>
        <?php endif;?>
    </div>
</div>