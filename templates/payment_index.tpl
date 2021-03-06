<table border=0 cellpadding=0 cellspacing=0>
    <tr>
        <td align="left">
            <b>Payment Information</b>
            <p>
                Our subscriptions may be purchased using all major credit cards. Your security is important to us and we take identity and financial privacy very seriously. NOTE: We actively prosecute fraudulent financial transactions.
            <p>
                Please enter the required information:
        </td>
    </tr>

    <script>
        function disableSubmit(theform) {
            var elementCount = theform.elements.length;
            for (i = 0; i < elementCount; i++) {
                if (theform.elements[i].name === 'submit') {
                    theform.elements[i].disabled = true;
                }
            }
            return true;
        }
    </script>

    <tr>
        <{*<{include file='db:payment_creditcard.tpl'}>*}>
    </tr>

    <tr>
        <td align="left">

            <table border=0 cellpadding=1 cellspacing=2>
                <form action="<{$formurl}>" method="post">
                    <{securityToken}><{*//mb*}>
                    <input type="hidden" name="referer" value="<{$referer}>">
                    <input type="hidden" name="successpage" value="<{$success}>">
                    <input type="hidden" name="username" value="<{$uname}>">
                    <input type="hidden" name="uid" value="<{$uid}>">
                    <tr>
                        <td class="even" height=18 valign="middle">
                            Full Name
                        </td>
                        <td align="left" class="even" height=18>
                            <input name="name" type="text" size="20" maxlength="20">&nbsp;&nbsp;** must be as it appears on card
                        </td>
                    </tr>
                    <tr>
                        <td class="odd" height=18>
                            Address
                        </td>
                        <td align="left" class="odd" height=18>
                            <input name="address1" size="30" maxlength="40">
                        </td>
                    </tr>
                    <tr>
                        <td class="even" height=18>
                            &nbsp;
                        </td>
                        <td align="left" class="even" height=18>
                            <input name="address2" size="30" maxlength="40">
                        </td>
                    </tr>
                    <tr>
                        <td class="odd" height=18>
                            City, State Postal/Zipcode
                        </td>
                        <td align="left" class="odd" height=18>
                            <input name="city" size="20" maxlength="20">&nbsp;
                            <input name="state" size="2" maxlength="2">&nbsp;
                            <input name="zipcode" size="12" maxlength="12">
                        </td>
                    </tr>
                    <tr>
                        <td class="odd" height=18>
                            Country
                        </td>
                        <td align="left" class="odd" height=18>
                            <{$countryselect}>
                        </td>
                    </tr>
                    <tr>
                        <td class="even" height=18 valign="middle">
                            Card Number
                        </td>
                        <td align="left" class="even" height=18>
                            <input name="cardnumber" type="text" size="20" maxlength="20">
                        </td>
                    </tr>
                    <tr>
                        <td class="odd" height=18 valign="middle">
                            Security Code
                        </td>
                        <td align="left" class="odd" height=18>
                            <input name="cvv" type="text" size="4" maxlength="4">&nbsp;&nbsp; ** 3 or 4 digit number on back of card (on front for Amex)
                        </td>
                    </tr>
                    <tr>
                        <td class="odd" height=18 valign="middle">
                            Card Issuer Phone Number
                        </td>
                        <td align="left" class="odd" height=18>
                            <input name="issuerphone" type="text" size="15"
                                   maxlength="20">&nbsp;&nbsp; ** Card Issuer phone number on back of card
                        </td>
                    </tr>
                    <tr>
                        <td class="even" height=18 valign="middle">
                            Expiration Date
                        </td>
                        <td align="left" class="even" height=18>
                            <select name="expirationmonth" size="1">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            &nbsp;
                            <select name="expirationyear" size="1">
                                <option value="06">2006</option>
                                <option value="07">2007</option>
                                <option value="08">2008</option>
                                <option value="09">2009</option>
                                <option value="10">2010</option>
                                <option value="11">2011</option>
                                <option value="12">2012</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" class="odd">
                            &nbsp;
                        </td>
                        <td align="left" class="odd">
                            <input type="checkbox" name="agree">
                            I agree to purchase this subscription in the amount of
                            <b><{$currencysymbol}>&nbsp;<{$price}></b>. This subscription will expire on <b><{$expirationdate}></b>. I have read all the terms and conditions that apply to making this purchase.</input>
                        </td>
                    </tr>
                    <tr height="5">
                        <td align=center colspan="2">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <input type="hidden" name="subid" value="<{$subid}>">
                            <input type="hidden" name="subname" value="<{$subname}>">
                            <input type="hidden" name="subtypeid" value="<{$subtypeid}>">
                            <input type="hidden" name="intervaltype" value="<{$intervaltype}>">
                            <input type="hidden" name="intervalamount" value="<{$intervalamount}>">
                            <input type="hidden" name="expirationdate" value="<{$expirationdate}>">
                            <input type="hidden" name="amount" value="<{$price}>">
                            <input type="submit" name='submit' value="-- Pay Now --">
                        </td>
                    </tr>
                </form>
                <tr>
                    <td colspan="2" align="CENTER" valign="TOP">
                        &nbsp;<p>
                            <img src="<{$secure_base}>/modules/subscription/assets/images/creditcards.jpg" width=227 height=45 border=0
                                 alt="We Accept All Major Credit Cards"><br>We respect your privacy and will not sell, rent or trade information<br>of any kind about website visitors and participants. NO SPAM!
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td>&nbsp;
        </td>
    </tr>
</table>

	

