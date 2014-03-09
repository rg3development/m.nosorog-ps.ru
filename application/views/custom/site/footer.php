        <div class="footer">
            <a class="menu yellow_btn" href="#">МЕНЮ</a>

            <div class="footer_caption">Связь</div>
            <?if ( isset($widgets['main_slider3']['items'])>0):?>
                <?foreach($widgets['main_slider3']['items'] as $key3=>$value3):?>
                    <a class="footer_phone" href="tel:<?=strip_tags($value3['item']->description);?>"><?=strip_tags($value3['item']->description);?></a></br>
                <?endforeach;?>
            <?endif;?>
            
            <div class=""><a class="footer_caption" href="http://nosorog-ps.ru/">Сайт для ПК</a></div>
            
        </div>
    </div>
</div>
<script>
    $(document).ready(function($) {
<?if (!empty($_GET['item'])):?>
        $('.gou').on('click', function() {
            
            $('.checks').submit();
        });
        var dropDown = $('.drop_down'), base = $('.base'), overlay = $('.overlay'), menuBtn = $('.menu'), aside = $('#mega_menu'), oneClickForm = $('#one_click_form'), dropLists = $('.drop_list');
        dropDown.on('click', function() {
            var firedEl = $(this).find('.drop_list');
            dropLists.slideUp(500).parent().removeClass('opened');
            if(!firedEl.is(':visible')) {
                firedEl.slideDown(500).parent().addClass('opened');
            }
            return false;
        });
        menuBtn.on('click', function() {
            $(document).scrollTop(0);
            if(overlay.is(':visible')) {
                aside.animate({'marginLeft': -270});
                overlay.fadeOut(500);
            } else {
            
                aside.animate({'marginLeft': 0});
                overlay.fadeIn(500);
                
            }
            return false;
        });
        function hideDropDowns() {
            $('.select_list').slideUp();
        }

        $(document).click(function(e) {
            if($(e.target).parents().filter('.select_drop_down').length != 1) {
                hideDropDowns();
            }
        });
        $('.select_drop_down').on('click', function() {
            var firedEl = $(this), dropList = firedEl.find('.select_list'), selectVal = firedEl.find('.select_value');
            if(dropList.is(':visible')) {
                dropList.slideUp();
            } else {
                hideDropDowns();
                dropList.slideDown(500);
            }
            return false;
        });
        $('.dels').on('click', function() {
            var firedEl = $(this);
            firedEl.parent().slideUp().prev().html(firedEl.text());
            $('.size1').val(firedEl.text());
            $('.size2').val(firedEl.text());
            return false;
        });
        $('.sels').on('click', function() {
            var firedEl = $(this);
            firedEl.parent().slideUp().prev().html(firedEl.text());
            return false;
        });
        $('.mod_slide_down').on('click', function() {
            var firedEl = $(this), slideInfo = firedEl.next();
            if(slideInfo.is(':visible')) {
                firedEl.removeClass('opened');
                slideInfo.slideUp();
            } else {
                firedEl.addClass('opened');
                slideInfo.slideDown();
            }
            return false;
        });
        function hidePopupForm() {
            oneClickForm.animate({'top': -1000}, 1000, function() {
                oneClickForm.hide();
            });
            overlay.fadeOut(500, function() {
                menuBtn.removeClass('disabled');
            });
        }

        overlay.on('click', function() {
            if(oneClickForm.is(':visible')) {
                hidePopupForm();
            }
            return false;
        });
        $('#buy_1_click').on('click', function() {
            if(oneClickForm.is(':visible')) {
                hidePopupForm();
            } else {
                oneClickForm.css('display', 'block').animate({'top': 130 + $(document).scrollTop()}, 1000);
                menuBtn.addClass('disabled');
                overlay.fadeIn(500);
            }
            return false;
        });
        <?$images=$item->images();?>
        <?$key=0;?>
        <?if(!empty($images)):?>  
            <?foreach($images as $key=>$img):?>
                
            <?endforeach;?>
        <?endif;?> 
        <?if($key>0):?>
        $('#item_slider').bxSlider({
            slideSelector: ('.item_slide'),
            touchEnabled : true,
            responsive   : true,
            minSlides    : 1,
            maxSlides    : 1,
            slideMargin  : 0,
            moveSlides   : 1,
            prevText     : '',
            nextText     : '',
            pager        : false,
            infiniteLoop : true
        });
        <?endif;?>
<?elseif((!empty($_GET['cat'])) || ($page_info['url'] == 'catalog')):?>
        var dropDown = $('.drop_down'), base = $('.base'), overlay = $('.overlay'), aside = $('#mega_menu'), dropLists = $('.drop_list');
        dropDown.on('click', function() {
            var firedEl = $(this).find('.drop_list');
            dropLists.slideUp(500).parent().removeClass('opened');
            if(!firedEl.is(':visible')) {
                firedEl.slideDown(500).parent().addClass('opened');
            }
            return false;
        });
        $('.menu').on('click', function() {
        $(document).scrollTop(0);
            if(overlay.is(':visible')) {
                aside.animate({'marginLeft': -270});
                overlay.fadeOut(500);
            } else {
                aside.animate({'marginLeft': 0});
                overlay.fadeIn(500);
            }
            return false;
        });

        function hideDropDowns() {
            $('.select_list').slideUp();
        }

        $(document).click(function(e) {
            if($(e.target).parents().filter('.select_drop_down').length != 1) {
                hideDropDowns();
            }
        });
        $('.select_drop_down').on('click', function() {
            var firedEl = $(this), dropList = firedEl.find('.select_list'), selectVal = firedEl.find('.select_value');
            if(dropList.is(':visible')) {
                dropList.slideUp();
            } else {
                hideDropDowns();
                dropList.slideDown(500);
            }
            return false;
        });
        $('.sel1').on('click', function() {
            var firedEl = $(this);
            firedEl.parent().slideUp().prev().html(firedEl.text().slice(0, 3));
            $('.item1').val(firedEl.text());
            return false;
        });
        $('.sel2').on('click', function() {
            var firedEl = $(this);
            firedEl.parent().slideUp().prev().html(firedEl.text().slice(0, 3));
            $('.item2').val(firedEl.text());
            return false;
        });
        $('.sel3').on('click', function() {
            var firedEl = $(this);
            firedEl.parent().slideUp().prev().html(firedEl.text().slice(0, 3));
            $('.item3').val(firedEl.text());
            return false;
        });
        $('.mod_slide_down').on('click', function() {
            var firedEl = $(this), slideInfo = firedEl.next();
            if(slideInfo.is(':visible')) {
                firedEl.removeClass('opened');
                slideInfo.slideUp();
            } else {
                firedEl.addClass('opened');
                slideInfo.slideDown();
            }
            return false;
        });
        function hidePopupForm() {
            oneClickForm.animate({'top': -1000}, 1000, function() {
                oneClickForm.hide();
            });
            overlay.fadeOut(500, function() {
                menuBtn.removeClass('disabled');
            });
        }


        $('.filter_block').on('click', function() {
            var firedEl = $(this), filterBox = $('.filter_drop_down');

            if(filterBox.is(':visible')) {
                filterBox.slideUp(500, function() {
                    firedEl.removeClass('opened');
                });
            } else {
                filterBox.slideDown(500);
                firedEl.addClass('opened');
            }

            return false;
        });


<?else:?>
        /*	var dropDown = $('.drop_down a'),
         dropLists = $('.drop_list');
         dropDown.on ('click', function () {
         var firedEl = $(this).next();
         dropLists.slideUp(500).parent().removeClass('opened');
         if (!firedEl.is(':visible')) {
         firedEl.slideDown(500).parent().addClass('opened');
         }
         return false;
         });*/
        var dropDown = $('.drop_down'), base = $('.base'), overlay = $('.overlay'), aside = $('#mega_menu'), dropLists = $('.drop_list');
        dropDown.on('click', function() {
            var firedEl = $(this).find('.drop_list');
            dropLists.slideUp(500).parent().removeClass('opened');
            if(!firedEl.is(':visible')) {
                firedEl.slideDown(500).parent().addClass('opened');
            }
            return false;
        });
        $('.tool_tip').on('click', function(){$(this).toggleClass('opened');});
        $('.menu').on('click', function() {
        $(document).scrollTop(0);
            if(overlay.is(':visible')) {
                aside.animate({'marginLeft': -270});
                overlay.fadeOut(500);
            } else {
                aside.animate({'marginLeft': 0});
                overlay.fadeIn(500);
            }
            return false;
        });
        
        $('#main_slider').bxSlider({
            slideSelector: ('.slide'),
            infiniteLoop : false,
            touchEnabled : false,
            minSlides    : 1,
            maxSlides    : 1,
            moveSlides   : 1,
            prevText     : '',
            nextText     : '',
            pager        : true,
            pagerSelector: $('.slider_pagination'),
            controls     : false,
            touchEnabled: true
        });
<?endif;?>
    });
</script>
<?=$counters;?>
</body>
</html>
