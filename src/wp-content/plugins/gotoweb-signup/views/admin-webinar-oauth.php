<?php global $gotoweb;?>
<div class="wrap">
	<h2>Citrix GoToWebinar OAuth</h2>
	<p>
		In order to connect to your GoToWebinar account, you will need
		to obtain an <strong>Organizer Key</strong> and <strong>Access Token</strong>
		from an O-Auth connector for webinars (G2W OAuth Flow).
		<a href="http://citrixonline-quick-oauth.herokuapp.com/" target="_blank">
			http://citrixonline-quick-oauth.herokuapp.com/
		</a>
	</p>
	<form method="post" action="">
		<table>
			<tr>
				<td>Organizer Key:</td>
				<td>
					<input type="text" name="token[organizer]" value="<?php echo isset($gotoweb->tokens)?$gotoweb->tokens['organizer']:'';?>"/>
				</td>
			</tr>
			<tr>
				<td>Access Token:</td>
				<td>
					<input type="text" name="token[access]" value="<?php echo isset($gotoweb->tokens)?$gotoweb->tokens['access']:'';?>"/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input class="button-primary" type="submit" name="save" value="Save" /></td>
			</tr>
		</table>
	</form>
</div>
<style>
form table input[type="text"] {
	width: 350px;
}
</style>