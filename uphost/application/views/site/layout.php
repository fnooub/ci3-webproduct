<html>
<head>
    <?php
    $this->load->view('site/head');
    ?>
</head>
<body>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '383289375379584',
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=383289375379584";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- live chat fb-->
<style>#cfacebook {
        position: fixed;
        bottom: 0px;
        right: 100px;
        z-index: 999999999999999;
        width: 250px;
        height: auto;
        box-shadow: 6px 6px 6px 10px rgba(0, 0, 0, 0.2);
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        overflow: hidden;
    }

    #cfacebook .fchat {
        float: left;
        width: 100%;
        height: 270px;
        overflow: hidden;
        display: none;
        background-color: #fff;
    }

    #cfacebook .fchat .fb-page {
        margin-top: -130px;
        float: left;
    }

    #cfacebook a.chat_fb {
        float: left;
        padding: 0 25px;
        width: 250px;
        color: #fff;
        text-decoration: none;
        height: 40px;
        line-height: 40px;
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAqCAMAAABFoMFOAAAAWlBMV…8/UxBxQDQuFwlpqgBZBq6+P+unVY1GnDgwqbD2zGz5e1lBdwvGGPE6OgAAAABJRU5ErkJggg==);
        background-repeat: repeat-x;
        background-size: auto;
        background-position: 0 0;
        background-color: #3a5795;
        border: 0;
        border-bottom: 1px solid #133783;
        z-index: 9999999;
        margin-right: 12px;
        font-size: 18px;
    }

    #cfacebook a.chat_fb:hover {
        color: yellow;
        text-decoration: none;
    }</style>
<script>
    jQuery(document).ready(function () {
        jQuery(".chat_fb").click(function () {
            jQuery('.fchat').toggle('slow');
        });
    });
</script>
<div id="cfacebook">
    <a href="javascript:;" class="chat_fb" onclick="return:false;"><i class="fa fa-facebook-square"></i> Phản hồi của
        bạn</a>
    <div class="fchat">
        <div class="fb-page" data-tabs="messages" data-href="https://www.facebook.com/Trung-Hieu-Tv-381281375558504/" data-width="250"
             data-height="400" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false"
             data-show-facepile="true" data-show-posts="false"></div>
    </div>
</div>
<!-- end live chat-->
<a id="back_to_top" href="#">
    <img src="<?php echo public_url('site'); ?>/images/top.png">
</a>

<div class="wraper">
    <div class="header">
        <?php
        $this->load->view('site/header');
        ?>
    </div>
    <div id="container">
        <div class="left">
            <?php
            $this->load->view('site/left',$this->data);
            ?>
        </div>
        <?php if(isset($message)): ?>
                <h2><strong>Notice: </strong> <?php echo $message; ?></h2>
        <?php endif;?>
        <div class="content">
            <?php
            $this->load->view($temp,$this->data);
            ?>
        </div>
        <div class="right">
            <?php
            $this->load->view('site/right',$this->data);
            ?>
        </div>
        <div class="clear"></div>

    </div>
    <center>
        <img src="<?php echo public_url('site'); ?>/images/bank.png">
    </center>

    <div class="footer">
        <?php
        $this->load->view('site/footer');
        ?>
    </div>
</div>

</body>
</html>