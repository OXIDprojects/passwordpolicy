[{$smarty.block.parent}]
[{if $oViewConf->isTOTP() && $oxcmp_user}]
<li>
    <a href="[{oxgetseourl ident=$oViewConf->getSelfLink()|cat:"cl=twofactoraccount"}]"><span>[{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN"}]</span></a>
</li>
[{/if}]