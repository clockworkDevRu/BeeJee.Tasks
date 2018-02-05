<div class="hidden" id="result"><?=$result ?></div>

<form id="addTaskForm" action="<?=SITE_URL ?>Main/addTask" method="post" enctype="multipart/form-data">
	
	<div class="form-group required row">
		<label class="col-sm-3 col-form-label" for="task-username">Имя пользователя</label>
		<div class="col-sm-9">
			<input type="text" id="task-username" class="form-control" name="Task[username]" autofocus="autofocus" aria-required="true">
		</div>
	</div>
	
	<div class="form-group required row">
		<label class="col-sm-3 col-form-label" for="task-email">Email</label>
		<div class="col-sm-9">
			<input type="text" id="task-email" class="form-control" name="Task[email]" autofocus="autofocus" aria-required="true">
		</div>
	</div>
	
	<div class="form-group required row">
		<label class="col-sm-3 col-form-label" for="task-text">Текст задачи</label>
		<div class="col-sm-9">
			<textarea class="form-control" name="Task[text]" id="task-text" rows="3"></textarea>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-sm-3" for="exampleFormControlFile1">Изображение</label>
		<div class="col-sm-9">
			<input type="file" class="form-control-file" name="task-img" id="task-img">
		</div>
	</div>
	
</form>

<div class="task-preview"></div>

