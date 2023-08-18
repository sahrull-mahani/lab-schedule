<?php if (!empty($errors)) : ?>
	<ul class="list-group list-group-flush">
		<?php foreach ($errors as $message) : ?>
			<li class="list-group-item" style="background-color: rgba(0, 0, 0, 0);"><?= esc($message) ?></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>