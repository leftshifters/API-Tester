<style type='text/css'>
	.heading { padding: 20px; margin: 20px; background-color: #CCC; border: 1px solid #AAA; }
	.title { font-weight: bold; font-size: 15px; color: #000; margin: 0px 0px 2px 0px; }
	.subtext { font-size: 11px; color: #444; padding: 0px 0px 5px 0px; }
	.input { font-size: 16px; color: #444; padding: 5px; margin: 0px 0px 15px 0px; width: 90%; }
	.submit { font-size: 16px; margin: 5px; }
	.data textarea { -webkit-appearance: textfield; font-size: 16px; color: #444; padding: 5px; margin: 0px 0px 15px 0px; width: 90%; }
</style>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#submit').click(function() {
			$('#submit').val('Fetching Data ...');
			$.getJSON('/API-Tester/ajax/fetch', { domain: $('#url').val(), post: $('#post').val(), file: $('#file').val() }, function(data) {
				if(data.result == 'success') {
					$('#headers').val(data.value);
				} else {
					$('#headers').val('The request failed');
				}
				$('#submit').val('Fetch Data');
			});
		});
	});
</script>
<div class='heading'>
	<div class='title'>Request URL</div>
	<div class='subtext'>eg. http://api.facebook.com/getFriends or http://api.facebook.com/getFriends?uid=123</div>
	<div><input type='text' id='url' value='' class='input' /></div>

	<div class='title'>Post Data</div>
	<div class='subtext'>eg. uid=123&tid=456 or you can leave it empty</div>
	<div><input type='text' id='post' value='' class='input' /></div>

	<?php
		$num = substr(md5(time() . 'rand'), 0, 6);
		$older_values = '';
		if( isset($_SESSION['files']) && (count($_SESSION['files']) > 0) ) {
			$_SESSION['files'][] = $num;
			$_SESSION['files'] = array_slice($_SESSION['files'], -5);
			$older_values = implode(', ', $_SESSION['files']);
		} else {
			$_SESSION['files'] = array();
			$_SESSION['files'][] = $num;
			$older_values = '(none)';
		}
	?>
					<div class='subtext'>This is your cookie file id. To send requests using a different session, please change this id. If you want to use the same session later, please remember this id.<br />The last few values used were : <?php echo $older_values ?>. You can view your cookie file here : <a target='_blank' href='<?php echo href('/app/cache/curl-cookie-' . $num . '.txt') ?>'>curl-cookie-<?php echo $num ?>.txt</a></div>
	<div><input type='text' id='file' value='<?php echo substr(md5(time() . 'rand'), 0, 6) ?>' class='input' /></div>
	<div class='subtext'><input type='submit' id='submit' value='Fetch Data' class='submit' /></div>

</div>
<div class='heading'>
	<div class='title'>Response</div>
	<div class='data'><textarea id='headers' style='height: 1000px;'></textarea></div>
</div>
