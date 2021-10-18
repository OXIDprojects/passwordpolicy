[{$smarty.block.parent}]
<tr>
    <td class="edittext" width="90">
        [{oxmultilang ident="OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN"}]
    </td>
    <td class="edittext">
        <input class="edittext" type="checkbox" name="editval[oxpstwofactor]" value='1' [{if $edit->oxuser__oxpstotpsecret->value != ""}]checked[{/if}] [{if $edit->oxuser__oxpstotpsecret->value == ""}]disabled[{/if}]>

    </td>
</tr>