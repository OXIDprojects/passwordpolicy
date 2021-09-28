[{$smarty.block.parent}]
[{if $oViewConf->isTOTP()}]
<li>
    <a href="[{oxgetseourl ident=$oViewConf->getSelfLink()|cat:"cl=twofactoraccount"}]"><span>[{oxmultilang ident="TWOFACTORAUTHLOGIN"}]</span></a>
</li>
[{/if}]