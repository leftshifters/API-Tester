<style type='text/css'>
	.heading { padding: 20px; margin: 20px; background-color: #CCC; border: 1px solid #AAA; }
	.title { font-weight: bold; font-size: 15px; color: #000; margin: 0px 0px 2px 0px; }
	.subtext { font-size: 11px; color: #444; padding: 0px 0px 5px 0px; }
	.input { font-size: 16px; color: #444; padding: 5px; margin: 0px 0px 15px 0px; width: 90%; }
	.submit { font-size: 16px; margin: 5px; }
</style>
<script type='text/javascript'>
</script>
<div class='heading'>
	<div class='title'>Request URL</div>
	<div class='subtext'>eg. http://api.facebook.com/getFriends or http://api.facebook.com/getFriends?uid=123</div>
	<div><input type='text' id='url' value='' class='input' /></div>

	<div class='title'>Post Data</div>
	<div class='subtext'>eg. uid=123&tid=456 or you can leave it empty</div>
	<div><input type='text' id='post' value='' class='input' /></div>

	<div class='subtext'><input type='submit' id='submit' value='Fetch Data' class='submit' /> or <input type='submit' id='clear' value='Clear Session & Cookies' class='submit' /></div>

</div>
