[{$smarty.block.parent}]
[{if $oViewConf->isTOTP()}]
    <li class="list-group-item[{if $active_link == "twofactor"}] active[{/if}]">
        <a class="list-group-link" href="[{oxgetseourl ident=$oViewConf->getSelfLink()|cat:"cl=twofactoraccount"}]" title="[{oxmultilang ident="TWOFACTORAUTHLOGIN"}]">[{oxmultilang ident="TWOFACTORAUTHLOGIN"}]</a>
    </li>
[{/if}]