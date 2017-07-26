<table>
	<tr>
		<td align="left" colspan=9 >
			<b>Current Payment Transactions</b>
		</td>
	</tr>
	<tr><td colspan=9>&nbsp;</td></tr>
	<tr>
		<td colspan=9>Search by User Name</td>
	</tr>
	<form action="transactions.php" method="GET">
	<tr>
		<td colspan=2>
			<input type="text" name="uname" size=15 maxlength=50>
		</td>
		<td colspan=7 align="left">
			<input type="submit" value="Search">
		</td>
	</tr>
	</form>
	<{if $showalllink eq 'true'}>
	<tr>
		<td align="left" colspan=9>
			<a href="transactions.php">Show All</a>
		</td>
	</tr>
	<{/if}>
	<tr>
		<td align="left" colspan=9>
			<{$form}>
		</td>
	</tr>
	<tr>
		<td align="center" class="head">
			<b>User</b>
		</td>	
		<td align="center" class="head">
			<b>Date</b>
		</td>	
		<td align="center" class="head">
			<b>Subscription</b>
		</td>	
		<td align="center" class="head">
			<b>Result</b>
		</td>	
		<td align="center" class="head">
			<b>Price</b>
		</td>	
		<td align="center" class="head">
			<b>Trans Type</b>
		</td>
		<td align="center" class="head">
		</td>
		<td align="center" class="head">
			<b>Detail</b>
		</td>
	</tr>
	<{foreach item=tx from=$transactions}>
	<tr>
		<td align="left" class="even">
			<{$tx.uname}>
		</td>
		<td align="left" class="even">
			<{$tx.date}>
		</td>
		<td align="left" class="even">
			<{$tx.subname}>
		</td>
		<td align="left" class="even">
			<{$tx.responsecode}>
		</td>
		<td align="right" class="even">
			<{$tx.amount}>
		</td>
		<td align="center" class="even">
			<{$tx.txtype_desc}>
		</td>
		<td align="left" class="even">
			<{ if $tx.txtype == 'A' && $tx.rescode == 0}>
			<a href="tx_approve.php?txid=<{$tx.txid}>">Approve</A><br>
			<a href="tx_approve.php?txid=<{$tx.txid}>&void=true">Deny</A>
			<{ /if }>
		</td>
		<td align="left" class="even">
			<a href="tx_detail.php?txid=<{$tx.txid}>">Detail</A>
		</td>
	</tr>
	<{/foreach}>
	<tr>
		<td align="right" colspan=9 class="odd">
		<{$nav}>
		</td>
	</tr>
	<tr>
		<td colspan="9" class="odd">
			&nbsp;	
		</td>
	</tr>			
	<tr>
		<td colspan="9" class="odd">
			<{$addform}>
		</td>
	</tr>			
</table>
