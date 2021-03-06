<table border=0 cellpadding=0 cellspacing=0>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="left"><b>
                After you purchase a subscription, you MUST log out of this system and log
                back in for your subscription to take affect!!!</b>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="left">
            Choose one of the options below and click on the <b>-Next-</b> button to continue.
        </td>
    </tr>
    <tr>
        <td>&nbsp;
        </td>
    </tr>
    <tr>
        <td align="center">

            <table width="500" border="0" cellspacing="1" cellpadding="1">
                <tr>
                    <td width="167" class="head" scope="col">&nbsp;</td>
                    <td width="73" align="CENTER" valign="BOTTOM" class="head"
                        scope="row">General<br>Subscription
                    </td>
                    <td width="73" align="CENTER" valign="BOTTOM" class="head"
                        scope="row">Premium<br>Subscription
                    </td>
                </tr>
                <!--
                <tr>
                    <td align="LEFT" valign="MIDDLE" class="head" scope="row">Create
                    Unlimited Subscriptions</td>
                    <td valign="MIDDLE" class="even"><div align="center">*</div></td>
                    <td valign="MIDDLE" class="even"><div align="center">*</div></td>
                </tr>
                <tr>
                    <td align="LEFT" valign="MIDDLE" class="head" scope="row">Assign User
                    Groups to Subscriptions</td>
                    <td valign="MIDDLE" class="even"><div align="center">*</div></td>
                    <td valign="MIDDLE" class="even"><div align="center">*</div></td>
                </tr>
                -->
                <tr>
                    <td align="LEFT" valign="MIDDLE" class="head" scope="row">Accept Paypal
                        Payments (Paypal Gateway)
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center">*</div>
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center">*</div>
                    </td>
                </tr>
                <tr>
                    <td align="LEFT" valign="MIDDLE" class="head" scope="row">Accept Verisign
                        Payflow PRO Payments
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center"></div>
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center">*</div>
                    </td>
                </tr>
                <tr>
                    <td align="LEFT" valign="MIDDLE" class="head" scope="row">Online Support
                        (Forums/E-Mail)
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center">*</div>
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center">*</div>
                    </td>
                </tr>
                <tr>
                    <td align="LEFT" valign="MIDDLE" class="head" scope="row">Unlimited Premium
                        Support 24/7
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center"></div>
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center">*</div>
                    </td>
                </tr>
                <tr>
                    <td align="LEFT" valign="MIDDLE" class="head" scope="row">Installation
                        Assistance and Customization
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center"></div>
                    </td>
                    <td valign="MIDDLE" class="even">
                        <div align="center">*</div>
                    </td>
            </table>

        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center">

            <table border=0 cellpadding=0 cellspacing=2 width="100%">
                <tr>
                    <{foreach item=type from=$types}>
                        <td align="center">
                            <form action="<{$formurl}>" method="post">
                                <{securityToken}><{*//mb*}>
                                <input type="hidden" name="subtypeid" value="<{$type.id}>">
                                <table border=0 cellspacing=2>
                                    <tr>
                                        <td align="center">
                                            <b><{$type.name}></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">

                                            <table border=0 cellpadding=1 align="center">
                                                <{foreach item=sub from=$type.subs}>
                                                    <tr>
                                                        <td align="left">
                                                            <{ if $type.subcount < 2}>
                                                            <input type="hidden" value="<{$sub.subid}>" name="subid">
                                                            <{ else }>
                                                            <input <{if $sub.current eq true}>disabled<{/if}> type="radio"
                                                                   value="<{$sub.subid}>" name="subid">
                                                            <{ /if }>
                                                            &nbsp;<{$currencysymbol}>
                                                            <{$sub.price}> <{$sub.name}>
                                                            <{if $sub.current eq true}>(expires
                                                            <b><{$sub.expirationdate}>)</b><{/if}></input>
                                                        </td>
                                                    </tr>
                                                <{/foreach}>
                                            </table>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center">
                                            <input type="submit" value="-- Next --">
                                        </td>
                                    </tr>

                                </table>
                            </form>

                        </td>
                    <{/foreach}>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <b>YOUR ORDER . . .</b>
            <p>
                When you purchase a <b>Third Eye Software General</b> or <b>Premium
                    Subscription</b> using a credit card, you will be able to log in to the
                website as a subscriber immediately and for the life of your subscription.
            <p>
                <b>MONTHLY Subscriptions:</b> Your <b>Monthly General</b> or <b>Premium
                    Subscription</b> will automatically renew every 30 days, until it is cancelled,
                and your credit card will automatically be charged every 30 days until
                subscription is cancelled.
            <p>
                <b>3/6/12 MONTH Subscriptions:</b> Your <b>3</b>, <b>6</b> or <b>12 Month
                    Subscription</b> will be billed every 3/6/12 months, and you will be able to
                participate as a subscriber for the duration of time purchased.
            <p>
                <b>Permanent Subscriptions:</b> Your <b>Permanent Subscription</b> will be
                billed once, and you will be able to participate as a subscriber at that
                level for as long as you want.
            <p>
                <b>NO CREDIT CARD?</b> We also accept checks and money orders (U.S. Dollars
                only!) for <b>3</b>, <b>6</b> and <b>12-Month Subscription</b> purchases.
                <b>Please email <a
                            href="mailto:membership@thirdeyesoftware.com">membership@thirdeyesoftware.com</a> for further instructions.</b>
            <p>
                <b>CANCELLATION:</b> You may cancel monthly subscription at any time. Contact
                <a
                        href="javascript:openWithSelfMain('../../pmlite.php?send2=1&to_userid=1','pmlite',430,380)"><b>Third
                        Eye Software</b></a> or send an email to <a href="mailto:membership@thirdeyesoftware.com"><b>membership@thirdeyesoftware.com</b></a>. Please make sure to include your username.
        </td>
    </tr>
    <tr>
        <td>&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="2" align="CENTER" valign="TOP">
            <img src="<{$xoops_url}>/modules/subscription/assets/images/creditcards.jpg" width=227 height=45 border=0 alt="We Accept All Major Credit Cards"><br>Third Eye Software respects your privacy and will not sell, rent or trade information<br>of any kind about website visitors and
            participants. NO SPAM!
        </td>
    </tr>
    <tr>
        <td>&nbsp;
        </td>
    </tr>
</table>
