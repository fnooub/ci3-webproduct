<!-- The Support -->
<div class="box-right">
    <div class="title tittle-box-right">
        <h2> Hỗ trợ trực tuyến </h2>
    </div>
    <div class="content-box">
        <!-- goi ra phuong thuc hien thi danh sach ho tro -->
        <div class="support">
            <strong>Do Trung Hieu</strong>
            <!--<a rel="nofollow" href="ymsgr:sendIM?tuyenht90">
                <img src="http://opi.yahoo.com/online?u=tuyenht90&amp;m=g&amp;t=2">
            </a>-->

            <p>
                <img style="margin-bottom:-3px" src="<?php echo public_url('site'); ?>/images/phone.png"> 01639539153
            </p>

            <p>
                <a rel="nofollow" href="mailto:hoangvantuyencnt@gmail.com">
                    <img style="margin-bottom:-3px" src="<?php echo public_url('site'); ?>/images/email.png">dotrunghieu7696@gmail.com
                </a>
            </p>
            <p>
                <a rel="nofollow" href="skype:tuyencnt90">
                    <img style="margin-bottom:-3px" src="<?php echo public_url('site'); ?>/images/skype.png"> Skype:
                    hieu </a>
            </p>
        </div>
    </div>
</div>
<!-- End Support -->

<!-- The news -->
<div class="box-right">
    <div class="title tittle-box-right">
        <h2> Bài viết mới </h2>
    </div>
    <div class="content-box">
        <ul class="news">
            <?php foreach ($news_list as $row): ?>
                <li>
                    <a href="news/view/4.html" title="<?php echo $row->title; ?>">
                        <img style="width:40px;"
                             src="<?php echo base_url('upload/news/' . $row->image_link); ?>"
                             atl="<?php echo $row->title; ?>">
                        <?php echo $row->title; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>        <!-- End news -->

<!-- The Ads -->
<div class="box-right">
    <div class="title tittle-box-right">
        <h2> Quảng cáo </h2>
    </div>
    <div class="content-box">
        <a href="">
            <img src="<?php echo public_url('site'); ?>/images/ads.png">
        </a>
    </div>
</div>
<!-- End Ads -->

<!-- The Fanpage -->
<div class="box-right">
    <div class="title tittle-box-right">
        <h2> Fanpage </h2>
    </div>
    <div class="content-box">

        <div class="fb-page" data-href="https://www.facebook.com/Trung-Hieu-Tv-381281375558504/"
             data-width="200" data-height="250" data-small-header="false" data-adapt-container-width="true"
             data-hide-cover="false" data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/Trung-Hieu-Tv-381281375558504/" class="fb-xfbml-parse-ignore"><a
                    href="https://www.facebook.com/Trung-Hieu-Tv-381281375558504/">Trung Hieu Tv</a></blockquote>
        </div>

    </div>
</div>
<!-- End Fanpage -->

<!-- The Fanpage -->
<div class="box-right">
    <div class="title tittle-box-right">
        <h2> Thống kê truy cập </h2>
    </div>
    <div class="content-box">
        <center>
            <!-- Histats.com  START  (standard)-->
            <script
                type="text/javascript">document.write(unescape("%3Cscript src=%27http://s10.histats.com/js15.js%27 type=%27text/javascript%27%3E%3C/script%3E"));</script>
            <script src="http://s10.histats.com/js15.js" type="text/javascript"></script>
            <a href="http://www.histats.com" target="_blank" title="hit counter">
                <script type="text/javascript">
                    try {
                        Histats.start(1, 2138481, 4, 401, 118, 80, "00011111");
                        Histats.track_hits();
                    } catch (err) {
                    }
                    ;
                </script>
                <div id="histats_counter_4371" style="display: block;"><a
                        href="http://www.histats.com/viewstats/?sid=2138481&amp;ccid=401" target="_blank">
                        <canvas id="histats_counter_4371_canvas" width="119" height="81"></canvas>
                    </a></div>
            </a>
            <noscript><a href="http://www.histats.com" target="_blank"><img
                        src="http://sstatic1.histats.com/0.gif?2138481&101" alt="hit counter" border="0"></a></noscript>
            <!-- Histats.com  END  -->
        </center>
    </div>
</div>
<!-- End Fanpage -->
		

					  