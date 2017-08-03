<!-- jQuery 2.1.4 -->
<script src="<?php echo $css_admin?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo $css_admin?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="<?php echo $css_admin?>plugins/fastclick/fastclick.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?php echo $css_admin?>dist/js/app.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?php echo $css_admin?>plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?php echo $css_admin?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- idle timer -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-idletimer/1.0.0/idle-timer.min.js"></script>
<!-- numeric -->
<script src="<?php echo $css_admin?>plugins/jquery.numeric.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        // numeric
        $('.numeric').numeric();

        //Auto logout user after 5 minute
        $(document).idleTimer( 300000 );
        $(document).on('idle.idleTimer',function(){
            window.location.href = '<?php echo site_url("auth/logout"); ?>';
        });

        // show spinner
        $(function(){
            $(window).load(function(){
                $('.loading').fadeOut(500);
            });

            $('a#overlay-load').on('click',function(e){
                if ($(this).attr('href').search('#') < 0) {
                    $('.loading').fadeIn(500);
                };
            });

            $('form').on('submit',function(){
                $('.loading').fadeIn(500);
            });

            $(document).ajaxStart(function(){
                $('.loading').fadeIn(500);
            }).ajaxStop(function(){
                $('.loading').fadeOut(500);
            });
        });
    });
</script>
