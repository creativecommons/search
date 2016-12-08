 <div id="deed-donate-slide" style="display: none;">
        <div class="slide-close"></div>
        <div class="slide-trigger">
            <img class="cc-logo" src="https://creativecommons.org/wp-content/themes/cc/images/yearend-takeover/cc_overlay_logo_confetti.png" alt="Creative Commons logo">
            <div class="yellow-ribbon"><span><span class="no-wrap"><?php echo _("Celebrate CC's 15th Anniversary!"); ?>"</span> <span class="no-wrap"><?php echo _('Join by December 31st.'); ?></span></span></div>

            <div class="donate-box">
              <div class="widget-inner">
                <div class="gf_browser_chrome gform_wrapper" id="gform_wrapper_10"><form method="get" id="gform_10" action="https://creativecommons.org/donate">
                  <div class="gform_body">
                    <ul id="gform_fields_10" class="gform_fields top_label form_sublabel_below description_below">
                      <li id="field_10_2" class="gfield gfield_html gfield_html_formatted gfield_no_follows_desc field_sublabel_below field_description_below">
                        <h2><span class="share-wins"><span class="no-wrap"><?php echo _('When you share,'); ?></span> <span class="no-wrap"><?php echo _('everyone wins.'); ?></span></span> <span class="contribute-today"><span class="no-wrap">Contribute today to</span> <span class="no-wrap">Creative Commons</span></span></h2>
                      </li>
                      <li id="field_10_1" class="gfield field_sublabel_below field_description_below">
                        <label class="gfield_label"></label>
                        <div class="ginput_container ginput_container_radio">
                          <ul class="gfield_radio" id="input_10_1">
                            <li class="gchoice_10_1_0"><input name="amount" type="radio" value="$100" id="choice_10_1_0" tabindex="1"><label for="choice_10_1_0" id="label_10_1_0">$100</label></li>
                            <li class="gchoice_10_1_1"><input name="amount" type="radio" value="$50" checked="checked" id="choice_10_1_1" tabindex="2"><label for="choice_10_1_1" id="label_10_1_1">$50</label></li>
                            <li class="gchoice_10_1_2"><input name="amount" type="radio" value="$25" id="choice_10_1_2" tabindex="3"><label for="choice_10_1_2" id="label_10_1_2">$25</label></li>
                            <li class="gchoice_10_1_3"><input name="amount" type="radio" value="$5" id="choice_10_1_3" tabindex="4"><label for="choice_10_1_3" id="label_10_1_3">$5</label></li>
                            <li class="gchoice_10_1_4"><input name="amount" type="radio" value="gf_other_choice" id="choice_10_1_4" tabindex="5" onfocus="$(this).next('input').focus();"><input id="input_10_1_other" name="amount_other" type="text" value="Other" aria-label="Other" onfocus="$(this).prev(&quot;input&quot;)[0].click(); if($(this).val() == &quot;<?php echo _("Other"); ?>&quot;) { $(this).val(&quot;&quot;); }" onblur="if($(this).val().replace(&quot; &quot;, &quot;&quot;) == &quot;&quot;) { $(this).val(&quot;<?php echo _("Other"); ?>&quot;); }" tabindex="5"></li>
                          </ul>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="gform_footer top_label">

                    <input type="hidden" name="type" value="One Time">
                    <input type="hidden" name="utm_content" value="eoy2016_search">
                    <input type="hidden" name="utm_source" value="web">
                    <input type="hidden" name="utm_medium" value="ccwebsiteorblog">
                    <input type="hidden" name="utm_campaign" value="2016EOY">
                    <input type="submit" id="gform_submit_button_10" class="gform_button button" value="Donate Now" tabindex="6">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="footer-note">
          <p><?php echo _("This content is freely available under simple legal terms because of Creative Commons, a non-profit that survives on donations. If you love this content, and love that it's free for everyone, please consider a donation to support our work."); ?></p>
        </div>
      </div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#deed-donate-slide').addClass('slider');
            $('#deed-donate-slide').show();
            // Set banner to reveal after X seconds
            setTimeout(function(){
                $('#deed-donate-slide').addClass('reveal');
            }, 500);
            $(window).scroll(function() {
                if ($(window).scrollTop() <= 160) {
                    $('#deed-donate-slide').finish();
                } else {
                    $('#deed-donate-slide').addClass('reveal');
                }
            });

            $('.slide-close').click(function(event) {
                $('#deed-donate-slide').remove();
            });

            /* Close slider on pressing ESC */
            $(document).keyup(function(e) {
                if (e.keyCode === 27) {
                    $('#deed-donate-slide').remove();
                }
            });

            $(".slide-trigger p, .slide-trigger button").click(function(){
                window.location.href = "https://creativecommons.org/donate/?utm_campaign=2016EOY&utm_source=web&utm_medium=ccwebsiteorblog&utm_content=eoy2016_search";
            });
        });
    </script>