<table>
    <tr>
        <td align="left" colspan=8>
            <b>Current User Subscriptions</b>
        </td>
    </tr>
    <tr>
        <td colspan=8>&nbsp;</td>
    </tr>
    <tr>
        <td colspan=8>Search by User Name</td>
    </tr>
    <form action="currentsubs.php" method="GET">
        <tr>
            <td colspan=2>
                <input type="text" name="uname" size=15 maxlength=50>
            </td>
            <td colspan=6 align="left">
                <input type="submit" value="Search">
            </td>
        </tr>
    </form>
    <tr>
        <td colspan=8 align="left">Cancel - cancels subscription from renewing
            after expiration<br>
            Revoke - same as cancel also revokes security group immediately.<br>
            Details - Click on Details if you want to change the expiration date.
        </td>
    </tr>
    <tr>
        <td colspan=8>&nbsp;</td>
    </tr>
    <tr>
        <td align="center" class="head">
            <b>User</b>
        </td>
        <td align="center" class="head">
            <b>Subscription</b>
        </td>
        <td align="center" class="head">
            <b>Price</b>
        </td>
        <td align="center" class="head">
            <b>Interval</b>
        </td>
        <td align="center" class="head">
            <b>Expiration Date</b>
        </td>
        <td align="center" class="head">
            <b>Canceled</b>
        </td>
        <td align="center" class="head">
        </td>
        </td>
        <td align="center" class="head">
        </td>
    </tr>
    <{foreach item=sub from=$subs}>
        <tr>
            <td align="left" class="even">
                <a href="/userinfo.php?uid=<{$sub.uid}>"><{$sub.uname}></a>
            </td>
            <td align="left" class="even">
                <{$sub.subname}>
            </td>
            <td align="left" class="even">
                <{$sub.amount}>
            </td>
            <td align="left" class="even">
                <{$sub.interval}>
            </td>
            <td align="right" class="even">
                <{$sub.expdate}>
            </td>
            <td align="right" class="even">
                <{$sub.cancel}>
            </td>
            <td align="center" class="even">
                <{if $sub.cancel eq 'No'}>
                    <a href="cancelsub.php?uid=<{$sub.uid}>&subid=<{$sub.subid}>">Cancel
                        Now</A>
                    <br>
                <{/if}>
                <a
                        href="cancelsub.php?uid=<{$sub.uid}>&subid=<{$sub.subid}>&revoke=true">Revoke
                    Now</a>
            </td>
            <td align="center" class="even">
                <a href="sub_detail.php?sid=<{$sub.sid}>">Details</a>
            </td>
        </tr>
    <{/foreach}>
    <tr>
        <td align="right" colspan=8 class="odd">
            <{$nav}>
        </td>
    </tr>
</table>
