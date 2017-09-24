<h1>Shaiya Europe Donations</h1>
			<center><img src="img/line.png" /></center>

<?
if($CurrentUser->IsLoggedIn()){
  ?>  
<center>
    <h2>Paypal To EP</h2>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="TMJMPL9SY4GG8">
<table>
<tr><td><input type="hidden" name="on0" value="Amount of Shaiya Europe Points">Amount of Shaiya Europe Points</td></tr><tr><td><select name="os0">
	<option value="200 EP">200 EP €2,00 EUR</option>
	<option value="550 EP">550 EP €5,00 EUR</option>
	<option value="1'200 EP">1'200 EP €10,00 EUR</option>
	<option value="1'990 EP">1'990 EP €15,00 EUR</option>
	<option value="3'000 EP">3'000 EP €20,00 EUR</option>
	<option value="5'000 EP">5'000 EP €30,00 EUR</option>
	<option value="10'000 EP">10'000 EP €50,00 EUR</option>
	<option value="17'000 EP">17'000 EP €75,00 EUR</option>
	<option value="33'000 EP">33'000 EP €100,00 EUR</option>
</select> </td></tr>
<tr><td><input type="hidden" name="on1" value="UserUID">UserUID</td></tr><tr><td><input type="text" name="os1" maxlength="200" value="<?=$CurrentUser->Get("UserUID")?>" readonly></td></tr>
</table>
<input type="hidden" name="currency_code" value="EUR">
<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
<img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>
<br/><br/>
<h2>Webmall</h2>
<a href="Store"><input type="submit" value="Webmall"></a>
</center>


<?
}else{
    include("core/reqlogin.inc.php");
}
?>

		<center>	<img src="img/line.png" /></center>
