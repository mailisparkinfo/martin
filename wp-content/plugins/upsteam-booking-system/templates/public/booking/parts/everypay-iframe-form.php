<?php
	//$fields = getEveryPayFields(10,14);
?>

<form action="https://igw-demo.every-pay.com/transactions" id="iframe_form" method="post" style="display: none" target="iframe-payment-container">
	<?php foreach ($fields as $key => $value):?>
		<input name="<?= $key;?>" value="<?=$value;?>"/>
	<?php endforeach;?>
</form>
