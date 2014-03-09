<form method="post" name="checkout">
<input type="hidden" name="type" value="save_3">
    <div class="order_caption">Оформление заказа</div>
        <div class="form_11" style="display:block;">
            <div class="page_title">Шаг 1: Личные данные</div>
            <div class="order_form">
            <? if ( validation_errors() ) : ?>
              <div class="alert">
                <?= validation_errors(); ?>
              </div>
            <? endif; ?>
              <div class="alert_1"></div>
                
                    
                    <input class="input_order" name="name" value="<?=set_value('name');?>" placeholder="Имя*" type="text"/>
                    <input class="input_order" name="fename" value="<?=set_value('fename');?>" placeholder="Фамилия*" type="text"/>
                    
                    <input class="input_order" name="phone" value="<?=set_value('phone');?>" placeholder="Телефон*" type="text"/>
                    <input class="input_order" name="email" value="<?=set_value('email');?>" placeholder="e-mail*" type="text"/>
                
            </div>
            <div class="buy_controls clearfix">
                <a href="/catalog" class="gray_btn go_shopping">Отменить</a>
                <a href="#" class="yellow_btn go_checkout go_ch1">Далее</a>
            </div>
            <div class="cart_tip">* Обязятельные для заполнения поля. Убедитесь в
                                  правильности заполнения данных, иначе мы не
                                  сможем доставить вам заказ
            </div>

        </div>
        <div class="form_22" style="display:none;">
            <div class="page_title">Шаг 2: Адрес доставки</div>
            <div class="alert_2"></div>
            <div class="order_form">               
                <input class="input_order" name="country" value="<?=set_value('country');?>" placeholder="Страна*" type="text"/>
                <input class="input_order" name="imail" value="<?=set_value('imail');?>" placeholder="Почтовый индекс*" type="text"/>
                <input class="input_order" name="region" value="<?=set_value('region');?>" placeholder="Регион" type="text"/>
                <input class="input_order" name="city" value="<?=set_value('city');?>" placeholder="Город*" type="text"/>
                <input class="input_order" name="street" value="<?=set_value('street');?>" placeholder="Улица*" type="text"/>
                <input class="input_order" name="home" value="<?=set_value('home');?>" placeholder="Дом*" type="text"/>
                <input class="input_order" name="room" value="<?=set_value('room');?>" placeholder="Квартира" type="text"/>
            </div>
            <div class="buy_controls clearfix">
                <a href="#" class="back_1 gray_btn go_shopping">Отменить</a>
                <a href="#" class="yellow_btn go_checkout go_ch2">Далее</a>
            </div>
                    <div class="cart_tip">* Обязятельные для заполнения поля. Убедитесь в
                                  правильности заполнения данных, иначе мы не
                                  сможем доставить вам заказ
            </div>
        </div>
        <?$main_slider8 = $this->banner_mapper->get_widget(8);?>
    
        <div class="form_33" style="display:none;">
            <div class="page_title">Шаг 3: Доставка и оплата</div>
            <div class="order_form">
                
                    <div class="from_caption">Способ доставки</div>
                    <input class="delivery_input" name="delivery" value="1" id="delivery_courier" type="radio"/>
                    <?if ( isset($main_slider8['items'])>0):?>
                    <div class="tip_row">
                        <label class="radio_emul" for="delivery_courier"></label>
                        <?=$main_slider8['items'][0]['item']->title;?>
                        <div class="tool_tip"></div>
                        <div class="tip_text"><?=$main_slider8['items'][0]['item']->description;?></div>
                        <div class="tool_tip_icon"></div>
                    </div>
                    <input class="delivery_input" name="delivery" value="2" id="delivery_myself" type="radio"/>

                    <div class="tip_row">
                        <label class="radio_emul" for="delivery_myself"></label>
                        <?=$main_slider8['items'][1]['item']->title;?>
                        <div class="tool_tip"></div>
                        <div class="tip_text"><?=$main_slider8['items'][1]['item']->description;?></div>
                        <div class="tool_tip_icon"></div>
                    </div>
                    
                    <div class="from_caption mod_1">Способ оплаты</div>
                    <input class="delivery_input" name="payments" value="1" id="payment_cash" type="radio"/>

                    <div class="tip_row">
                        <label class="radio_emul" for="payment_cash"></label>
                        <?=$main_slider8['items'][2]['item']->title;?>
                        <div class="tool_tip"></div>
                        <div class="tip_text"><?=$main_slider8['items'][2]['item']->description;?></div>
                        <div class="tool_tip_icon"></div>
                    </div>
                    <input class="delivery_input" name="payments" value="2" id="payment_other" type="radio"/>

                    <div class="tip_row">
                        <label class="radio_emul" for="payment_other"></label>
                        <?=$main_slider8['items'][3]['item']->title;?>
                        <div class="tool_tip"></div>
                        <div class="tip_text"><?=$main_slider8['items'][3]['item']->description;?></div>
                        <div class="tool_tip_icon"></div>
                    </div>
                    <?endif;?>
            </div>
            <div class="buy_controls mod_1 clearfix">
                <a href="#" class="back_2 gray_btn go_shopping">Отменить</a>
                <a href="#" onclick='document.forms["checkout"].submit();' class="yellow_btn go_checkout">Заказать</a>
            </div>
        </div> 

</form>
<script>
    $(document).ready(function($) {
        $(".go_ch1").on('click', function() {                
             if ($("input[name=name]").val() == ''){
             $(".alert_1").html(' ');
             $(".alert_1").html('Поле Имя не заполнено!');
             }else{
                if ($("input[name=fename]").val() == ''){
                    $(".alert_1").html(' ');
                    $(".alert_1").html('Поле Фамилия не заполнено!');
                }else{
                    if ($("input[name=phone]").val() == ''){                        
                        $(".alert_1").html(' ');
                        $(".alert_1").html('Поле Телефон не заполнено!');
                    }else{
                        if(!$.isNumeric($("input[name=phone]").val())){
                        $(".alert_1").html(' ');
                        $(".alert_1").html('Поле телефон заполнено не верно!');
                        }else{
                            if ($("input[name=email]").val() == ''){
                                $(".alert_1").html(' ');
                                $(".alert_1").html('Поле e-mail не заполнено!');
                            }else{
                                if(isValidEmailAddress($("input[name=email]").val())){
                                    $(".form_11").css("display", "none");
                                    $(".form_22").css("display", "block"); 
                                }else{
                                    $(".alert_1").html(' ');
                                    $(".alert_1").html('Не существующая электронная почта!');
                                }
                                
                            }
                        }

                    }
                }
             }
        });
        function isValidEmailAddress(emailAddress) {
            var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
            return pattern.test(emailAddress);
        }
        $(".go_ch2").on('click', function() {               
             if ($("input[name=country]").val() == ''){
             $(".alert_2").html(' ');
             $(".alert_2").html('Поле Страна не заполнено!');
             }else{
                if ($("input[name=imail]").val() == ''){
                    $(".alert_2").html(' ');
                    $(".alert_2").html('Поле Почтовый индекс не заполнено!');
                }else{                    
                    if ($("input[name=city]").val() == ''){                        
                        $(".alert_2").html(' ');
                        $(".alert_2").html('Поле Город не заполнено!');
                    }else{
                        if ($("input[name=street]").val() == ''){
                            $(".alert_2").html(' ');
                            $(".alert_2").html('Поле Улица не заполнено!');
                        }else{
                            if ($("input[name=home]").val() == ''){
                                $(".alert_2").html(' ');
                                $(".alert_2").html('Поле Дом не заполнено!');
                            }else{
                                $(".form_22").css("display", "none");    
                                $(".form_33").css("display", "block");     
                            }        
                        }
                        

                    }
                }
             }          
        });
        $(".back_1").on('click', function() {
            $(".form_22").css("display", "none");    
            $(".form_11").css("display", "block");            
        });
        $(".back_2").on('click', function() {
            $(".form_33").css("display", "none");    
            $(".form_22").css("display", "block");            
        });
    });
</script>
