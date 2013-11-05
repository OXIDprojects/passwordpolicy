[{$smarty.block.parent}]
[{oxstyle include=$oViewConf->getModuleUrl("oxpspasswordpolicy", "out/src/css/oxpspasswordpolicy.css")}]
[{oxscript include=$oViewConf->getModuleUrl("oxpspasswordpolicy", "out/src/js/oxpspasswordpolicy.js")}]
<div id="password_strength"[{if $smarty.template eq 'form/forgotpwd_change_pwd.tpl' or
                                $smarty.template eq 'form/user_password.tpl'  }] class="password-change"[{/if}]>
    <h3 class="blockHead">[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_TITLE" }]</h3>

    <p>[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_MEMO" }] [{$smarty.template}]</p>

    <div class="indicator">
        <div id="passwordDescription">[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_NOPASSWORD" }]</div>
        <div id="passwordStrength" class="strength0"></div>
    </div>
</div>
<script type="text/javascript">
    var oxpspasswordpolicy_translations = new Array();
    oxpspasswordpolicy_translations[0] = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH0" }]';
    oxpspasswordpolicy_translations[1] = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH1" }]';
    oxpspasswordpolicy_translations[2] = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH2" }]';
    oxpspasswordpolicy_translations[3] = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH3" }]';
    oxpspasswordpolicy_translations[4] = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH4" }]';
    oxpspasswordpolicy_translations[5] = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH5" }]';

    var oxpspasswordpolicy_settings = new Array();
    oxpspasswordpolicy_settings['iMinPasswordLength'] = [{ $iMinPasswordLength }];
    oxpspasswordpolicy_settings['iGoodPasswordLength'] = [{ $iGoodPasswordLength }];
</script>
