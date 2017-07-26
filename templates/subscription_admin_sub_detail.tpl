<table width="450">
    <form action="update_currentsub.php" method="post">
        <{securityToken}><{*//mb*}>
        <tr>
            <td class="even" colspan=2>
                <a href="currentsubs.php">Go Back</A>
            </td>
        </tr>
        <tr>
            <td align="left" class="head">
                <b>User
            </td>
            <td align="left" class="even" width="200">
                <{$sub.uname}>
            </td>
        </tr>
        <tr>
            <td align="left" class="head">
                <b>Subscription</b>
            </td>
            <td align="left" class="even" width="200">
                <{$sub.subname}>
            </td>
        </tr>
        <tr>
            <td align="left" class="head">
                <b>Price</b>
            </td>
            <td align="left" class="even" width="200">
                <{$sub.amount}>
            </td>
        </tr>
        <tr>
            <td align="left" class="head">
                <b>Interval</b>
            </td>
            <td align="left" class="even" width="200">
                <{$sub.interval}>
            </td>
        </tr>
        <tr>
            <td align="left" class="head">
                <b>Expiration Date
            </td>
            <td align="left" class="even" width="200">
                <input type="text" value="<{$sub.expdate}>" size=20 name="expdate">
            </td>
        </tr>
        <tr>
            <td align="left" class="head">
                <b>Canceled</b>
            </td>
            <td align="left" class="even" width="200">
                <select name="cancel">
                    <option value="N" <{if $sub.cancel eq 'No'}> SELECTED <{/if}>>No</option>
                    <option value="Y" <{if $sub.cancel eq 'Yes'}> SELECTED <{/if}>>Yes</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="center" colspan=2>
                <input type="submit" value="submit">
            </td>
        </tr>
        <input type="hidden" name="sid" value="<{$sub.sid}>">
    </form>
</table>
