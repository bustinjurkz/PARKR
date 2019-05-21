
<?php
//if errors array greater than 0, display right at top of registration form
if(count($errors)>0):
?>
<?php foreach ($errors as $error): ?>
<p><?php echo $error; ?></p>
<?php endforeach ?>
<?php endif ?>