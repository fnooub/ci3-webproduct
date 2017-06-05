<style type="text/css">
    table td{
        padding: 10px;
        border: solid 1px green;
    }
</style>
<div class="box-center"><!-- The box-center product-->
    <div class="tittle-box-center">
        <h2>Ho so ca nhan</h2>
    </div>
    <div class="box-content-center product"><!-- The box-content-center -->
        <h1>Thong tin thành viên</h1>
        <table>
            <tr>
                <td>Ho va ten</td>
                <td><?php echo $user->name;?></td>
            </tr>
            <tr>
                <td>Dia chi email</td>
                <td><?php echo $user->email;?></td>
            </tr>
            <tr>
                <td>Ngay dang ki</td>
                <td><?php echo get_date($user->created);?></td>
            </tr>
        </table>
        <a href="<?php echo site_url('user/edit') ?>" class="button">Sua thong tin</a>
    </div>
</div>