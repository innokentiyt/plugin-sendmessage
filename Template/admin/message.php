<div class="page-header">
    <h2><?= t('Send Message') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('SendmessageController', 'save', array('plugin' => 'Sendmessage')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>
	
	<?= $this->form->label(t('Введите идентификатор пользователя'), 'user_id') ?>
    <?= $this->form->text('user_id', $values, $errors) ?>
	
    <?= $this->form->textEditor('message', $values, $errors) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Send') ?></button>
    </div>

</form>
<br>
<div class="page-header">
    <h2><?= t('Все сообщения') ?></h2>
</div>
 <table class="table-striped table-scrolling">
	<tr>
		<th>Номер строки в БД</th>
		<th>Идентификатор получателя</th>
		<th>Сообщение</th>
		<th>Статус</th>
		<th>Удалить?</th>
	</tr>
	
	<?php
	foreach ($allmessages as $message) {
		$rowid = $message['rowid'];
		$content = $message['message'];
		$user_id = $message['user_id'];
		if($message['obtained'] == 0) {
			$obtained = 'Не прочитано';
		}
		else {
			$obtained = '<span style="color:#267226"><b>Прочитано</b></a>';
		}
		
		$html='<tr><td>'.$rowid.'</td><td><a href="'.$this->url->href('UserViewController', 'show', ['user_id' => $user_id]).'">'.$user_id.'</a></td><td>'.$content.'</td><td>'.$obtained.'</td><td>
			<form style="font-size:7pt" method="post" action="'.$this->helper->url->href('SendmessageController', 'deleteMessage', array('plugin' => 'Sendmessage')).'" autocomplete="off">'
				.$this->helper->form->csrf().'
				<input type="hidden" name="rowid" value="'.$rowid.'">
				<input type="hidden" name="message" value="'.$content.'">
				<input type="hidden" name="user_id" value="'.$user_id.'">
				<button type="submit" class="btn btn-red">Удалить</button>
			</form></td></tr>';
		echo $html;
		
	}
	?>
</table>