<table border=0 cellpadding=0 cellspacing=0>
    <tr>
        <td align="left" colspan=2>
            <b>Cancel Subscription</b>
            <p>
                Please enter your email address used on this system to confirm your request
                to cancel your subscription. Cancelling your subscription will keep our
                system from rebilling you when your existing subscription expires.
        </td>
    </tr>
    <form action="<{$xoops_url}>/modules/subscription/cancelsubscription.php"
          method="post">
        <tr>
            <td align="left">
                <b>Subscriptions</b>
            </td>
            <td align="left" valign="top">
                <{foreach item=sub from=$subs}>
                    <input type=radio value="<{$sub.subid}>"
                           name="subid"><{$sub.subname}></input>
                    <br>
                <{/foreach}>
            </td>
        </tr>
        <tr>
            <td align="left">
                <b>E-Mail Address</b>
            </td>
            <td align="left">
                <input type="text" size="30" maxlength="50" name="email">
            </td>
        </tr>
        <tr>
            <td>&nbsp;
            </td>
            <td align="left">
                <input type="submit" name="submit" value="Cancel Subscription">
            </td>
        </tr>
</table>

	

