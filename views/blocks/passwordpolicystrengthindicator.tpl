[{$smarty.block.parent}]
[{oxstyle include=$oViewConf->getModuleUrl("oxpspasswordpolicy", "out/src/css/oxpspasswordpolicy.css")}]
[{oxscript include=$oViewConf->getModuleUrl("oxpspasswordpolicy", "out/src/js/oxpspasswordpolicy.js")}]
<div id="password-indicator-wrapper"[{if $smarty.template eq 'form/forgotpwd_change_pwd.tpl' or
                                $smarty.template eq 'form/user_password.tpl'  }] class="password-change"[{/if}]>
    [{oxifcontent ident="oxpspasswordpolicy_hinttext" object="oCont"}]
        <h3 class="blockHead">[{$oCont->oxcontents__oxtitle->value}]</h3>
        [{$oCont->oxcontents__oxcontent->value}]
    [{/oxifcontent}]

    <div id="password-indicator">
        <div id="passwordStrength" class="strength0"></div>
        <div id="passwordStrengthText"></div>
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

    oxpspasswordpolicy_translations['minlength'] = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_MINLENGTH" }]';
    oxpspasswordpolicy_translations['capital']   = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_CAPITAL" }]';
    oxpspasswordpolicy_translations['lower']     = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_LOWER" }]';
    oxpspasswordpolicy_translations['digits']    = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_DIGITS" }]';
    oxpspasswordpolicy_translations['special']   = '[{ oxmultilang ident="OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_SPECIAL" }]';

    var oxpspasswordpolicy_settings = [{$oViewConf->getJsonPasswordPolicySettings()}];
</script>
