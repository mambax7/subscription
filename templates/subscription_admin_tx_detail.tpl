<table width="450">
    <tr>
        <td class="even" colspan=2>
            <a href="transactions.php">Go Back</A>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>ID/Type
        </td>
        <td align="left" class="even" width="200">
            <{$tx.txid}>&nbsp;/&nbsp;<{$tx.txtype}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Name On Card</b>
        </td>
        <td align="left" class="even" width="200">
            <{$tx.name}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Number</b>
        </td>
        <td align="left" class="even" width="200">
            <{$tx.number}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Address
        </td>
        <td align="left" class="even" width="200">
            <{$tx.address}>,&nbsp;<{$tx.city}>, <{$tx.state}>&nbsp;<{$tx.zipcode}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Expiration Date
        </td>
        <td align="left" class="even" width="200">
            <{$tx.month}>/<{$tx.year}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Authorization Code
        </td>
        <td align="left" class="even" width="200">
            <{$tx.authcode}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Reference Number</b>
        </td>
        <td align="left" class="even" width="200">
            <{$tx.ref}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Transaction Date</b>
        </td>
        <td align="left" class="even" width="200">
            <{$tx.txdate}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Additional Info</b>
        </td>
        <td align="left" width="200" class="even">
            <{$tx.response}>
        </td>
    </tr>
    <tr>
        <td align="left" class="head">
            <b>Tx Amount</b>
        </td>
        <td align="left" class="even" width="200">
            $<{$tx.amount}>
        </td>
    </tr>
    <{if $tx.responsecode neq '0'}>
        <tr>
            <td align="center" class="even" colspan=2>
                <a href="retry_payment.php?txid=<{$tx.txid}>">Retry Transaction</a>
            </td>
        </tr>
    <{/if}>
</table>
