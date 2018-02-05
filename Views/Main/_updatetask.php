<div class="hidden" id="result"><?=$result ?></div>

<form id="updateTaskForm" action="<?=SITE_URL ?>Main/updateTask?id=<?=$task->id ?>" method="post">
	
	<div class="form-group required row">
		<label class="col-sm-3 col-form-label" for="task-username">Имя пользователя</label>
		<div class="col-sm-9">
			<input type="text" id="task-username" readonly class="form-control-plaintext" name="Task[username]" autofocus="autofocus" aria-required="true" value="<?=$task->username ?>">
		</div>
	</div>
	
	<div class="form-group required row">
		<label class="col-sm-3 col-form-label" for="task-email">Email</label>
		<div class="col-sm-9">
			<input type="text" id="task-email" readonly class="form-control-plaintext" name="Task[email]" autofocus="autofocus" aria-required="true" value="<?=$task->email ?>">
		</div>
	</div>
	
	<div class="form-group required row">
		<label class="col-sm-3 col-form-label" for="task-text">Текст задачи</label>
		<div class="col-sm-9">
			<textarea class="form-control" name="Task[text]" id="task-text" rows="3"><?=$task->text ?></textarea>
		</div>
	</div>
	
	<div class="form-group required row">
		<label class="form-check-label">
			<div class="col-sm-12">
				<input class="form-check-input" type="checkbox" name="Task[completed]" id="task-completed" value="<?=$task->completed ?>" <?=$task->completed == 1 ? 'checked="checked"' : ''?> />
				Выполнена
			</div>
		</label>
	</div>
	
</form>

