<div class="main-content">

	<h4 class="">Список задач <button type="button" id="addTaskBtn" class="btn btn-primary float-right">Добавить</button></h4>
	
	<div class="tasks-list" id="tasksPjax"></div>
	
	<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Добавить задачу</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" id="addTaskPreviewBtn" class="btn btn-link">Предварительный просмотр</button>
				<button type="submit" id="addTaskSub" class="btn btn-primary">Сохранить</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
			</div>
			</div>
		</div>
	</div>
	
	<? if (isset($user) && $user->name == 'admin') { ?>
		<div class="modal fade" id="updateTaskModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Обновить задачу</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="submit" id="updateTaskSub" class="btn btn-primary">Сохранить</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				</div>
				</div>
			</div>
		</div>
	<? } ?>

</div>