<div class="form-shipping-info">
    <form id="shipping-form" method="post" name="shipping-form">
        <div class="form-field">
            <div class="form-label">Please provide your information to quote any shipping costs.<br>(Your Information is kept private)</div>
    
            <div class="input-full">
                <input type="email" name="mailing_email_address" id="mailing_email_address" placeholder="Email address">                
            </div>
            <div class="input-full">
                <input type="email" name="mailing_confirm_email_address" id="mailing_confirm_email_address" placeholder="Confirm email address">                
            </div>
            <div class="checkbox">
                <input type="checkbox" name="subscribe-newsletter" id="subscribe-newsletter" value="Subscribe to newsletter">
                <label for="subscribe-newsletter">Keep me up to date on news, Newsletter and exclusive offers </label>            
            </div>
        </div>

        <div class="form-field mailing-address">
            <div class="form-label">Mailing Address</div>
            <div class="input-group col-2">
                <div>
                    <input type="text" name="mailing_first_name" id="mailing_first_name" placeholder="First Name">        
                </div>
                <div>
                    <input type="text" name="mailing_last_name" id="mailing_last_name" placeholder="Last Name">
                </div>
            </div>
            <div class="input-full">
                <input type="text" name="mailing_company" id="mailing_company" placeholder="Company">
            </div>
            <div class="input-full">
                <input type="text" name="mailing_street_address" id="mailing_street_address" placeholder="Address">
            </div>
            <div class="input-full">
                <input type="text" name="mailing_street_address_2" id="mailing_street_address_2" placeholder="Aprtment, suite, etc. (optional)">
            </div>
            <div class="input-full">
                <input type="text" name="mailing_city" id="mailing_city" placeholder="City">
            </div>
            <div class="input-group col-3">
                <div>
                    <select name="mailing_country" id="mailing_country">
                        <option value="" disabled selected hidden>Country</option>
                    </select>
                </div>
            
                <div>
                    <select name="mailing_state" id="mailing_state" class="form-control input-lg">
                        <option value="" disabled selected hidden>State</option>
                    </select>
                </div>
            
                <div>
                    <input type="text" name="mailing_zip_code" id="mailing_zip_code" placeholder="ZIP Code">
                </div>
            </div>
            <div class="input-full">
                <input type="text" name="mailing_phone_number" id="mailing_phone_number" placeholder="Phone">
            </div>
            <div class="checkbox">
                <input type="checkbox" name="show-shiipping-address" id="show-shiipping-address" value="1">
                <label for="show-shiipping-address">Shipping address is different from above</label>            
            </div>
        </div>

        <div class="form-field shipping-address">
            <div class="form-label">Shipping Address</div>
            <div class="input-group col-2">
                <div>
                    <input type="text" name="shipping_first_name" id="shipping_first_name" placeholder="First Name">        
                </div>
                <div>
                    <input type="text" name="shipping_last_name" id="shipping_last_name" placeholder="Last Name">
                </div>
            </div>
            <div class="input-full">
                <input type="text" name="shipping_company" id="shipping_company" placeholder="Company">
            </div>
            <div class="input-full">
                <input type="text" name="shipping_street_address" id="shipping_street_address" placeholder="Address">
            </div>
            <div class="input-full">
                <input type="text" name="shipping_street_address_2" id="shipping_street_address_2" placeholder="Aprtment, suite, etc. (optional)">
            </div>
            <div class="input-full">
                <input type="text" name="shipping_city" id="shipping_city" placeholder="City">
            </div>
            <div class="input-group col-3">
                <div>
                    <select name="shipping_country" id="shipping_country">
                        <option value="" disabled selected hidden>Country</option>
                    </select>
                </div>
            
                <div>
                    <select name="state" id="shipping_state" class="form-control input-lg">
                        <option value="" disabled selected hidden>State</option>
                    </select>
                </div>
            
                <div>
                    <input type="text" name="shipping_zip_code" id="shipping_zip_code" placeholder="ZIP Code">
                </div>
            </div>
            <div class="input-full">
                <input type="text" name="shipping_phone_number" id="shipping_phone_number" placeholder="Phone">
            </div>        
        </div>

        <div class="form-field">
            <div class="form-label">Please click on the small square below, then click the green colored "Next" button to move forward with your build.</div>
            <script src='https://www.google.com/recaptcha/api.js'></script>
            <div class="g-recaptcha" data-sitekey="<?php echo get_option( 'rg_gforms_captcha_public_key', '' ) ?>"
                data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired" data-size="normal"></div>
            <input id="hidden_grecaptcha" name="hidden_grecaptcha" type="text"
                style="opacity: 0; position: absolute; top: 15; left: 0; height: 1px; width: 1px;" />
            <span>This is to prove you are an actual person</span>
        </div>
    </form>
</div>