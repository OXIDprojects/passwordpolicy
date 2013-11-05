[{include file="headitem.tpl" title="OXPS_PASSWORDPOLICY_ADMIN_TITLE"|oxmultilangassign}]

<table cellspacing="0" cellpadding="0" border="0" width="98%" xmlns="http://www.w3.org/1999/html"
       xmlns="http://www.w3.org/1999/html">
    <tr>
        <th valign="top" class="edittext">
            <h1>[{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_TITLE" }]</h1>
            [{if $message}]
            <p>[{oxmultilang ident=$message}]</p>
            [{/if}]
        </th>
    </tr>
    <tr>
        <td valign="top" class="edittext" align="left">
            <br>
            <table cellspacing="0" cellpadding="0" border="0">
                <tr>
                    <td class="edittext">
                        <form name="passwordpolicy_settings" id="passwordpolicy_settings" method="post"
                              action="[{ $oViewConf->getSelfLink() }]cl=admin_oxpspasswordpolicy&fnc=save">
                            <table cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <th colspan="2">
                                        <strong>
                                            [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_ACCOUNTBLOCK" }]
                                        </strong>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="edittext" width="120">
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_MAXATTEMPTS" }]
                                    </td>
                                    <td class="edittext">
                                        <input type="test" name="passwordpolicy_maxattemptsallowed"
                                               value="[{ $iMaxAttemptsAllowed }]" maxlength="4"/>
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_MAXATTEMPTS_HINT" }]
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edittext" width="120">
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_TRACKINGPERIOD" }]
                                    </td>
                                    <td class="edittext">
                                        <input type="test" name="passwordpolicy_trackingperiod"
                                               value="[{ $iTrackingPeriod }]" maxlength="12"/>
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_TRACKINGPERIOD_HINT" }]
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edittext" width="120">
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_ALLOWUNBLOCK_LABEL" }]
                                    </td>
                                    <td class="edittext">
                                        <input type="checkbox" name="passwordpolicy_allowunblock"
                                               value="1"[{if $blAllowUnblock }] checked="ckecked"[{/if}]/>
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_ALLOWUNBLOCK" }]
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        <strong>
                                            [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_PASSWORDSTRENGTH" }]
                                        </strong>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="edittext" width="120">
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_MINLENGTH" }]
                                    </td>
                                    <td class="edittext">
                                        <input type="test" name="passwordpolicy_minpasswordlength"
                                               value="[{ $iMinPasswordLength }]" maxlength="2"/>
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_MINLENGTH_HINT" }]
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edittext" width="120">
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_GOODLENGTH" }]
                                    </td>
                                    <td class="edittext">
                                        <input type="test" name="passwordpolicy_goodpasswordlength"
                                               value="[{ $iGoodPasswordLength }]" maxlength="2"/>
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_GOODLENGTH_HINT" }]
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edittext" width="120">
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_MAXLENGTH" }]
                                    </td>
                                    <td class="edittext">
                                        <input type="test" name="passwordpolicy_maxpasswordlength"
                                               value="[{ $iMaxPasswordLength }]" maxlength="3"/>
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_MAXLENGTH_HINT" }]
                                    </td>
                                </tr>
                                <tr>
                                    <td class="edittext" width="120">
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_REQUIREMENTS" }]
                                    </td>
                                    <td class="edittext">
                                        <table cellspacing="0" cellpadding="0" border="0">
                                            [{foreach from=$aPasswordRequirements key=key item=item}]
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                           name="passwordpolicy_requirements[[{ $key }]]"
                                                           value="1"[{if $item }] checked="ckecked"[{/if}]/>
                                                    [{assign var="required_type" value=$key|upper }]
                                                    [{assign var="required_type"
                                                value="OXPS_PASSWORDPOLICY_ADMIN_REQUIRE"|cat:$required_type }]
                                                    [{oxmultilang ident=$required_type}]
                                                </td>
                                            </tr>
                                            [{/foreach}]
                                        </table>
                                        [{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_REQUIREMENTS_HINT" }]
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            </table>
                            <input type="submit" name="passwordpolicy_submit" value="[{ oxmultilang ident="OXPS_PASSWORDPOLICY_ADMIN_APPLY_SETTINGS" }]"/>
                        </form>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

[{include file="bottomitem.tpl"}]