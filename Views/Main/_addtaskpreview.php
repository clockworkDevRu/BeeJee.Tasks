<table>
	<tr class="task">
		<td>
			<div class="font-weight-bold"><?=$task->username ?> <span class="grey"><?=$task->email ?></span></div>
			<div class="task-text"><?=$task->text ?></div>
			<div class="task-status">
				<button type="button" class="preview-task-return-btn btn btn-link float-right">Изменить</button>
			</div>
		</td>
		<td class="task-img">
			<?=!empty($task->img) ? '<img src="' . SITE_URL . 'Uploads/tmp/' . $task->img . '" />' : '' ?>
		</td>
	</tr>
</table>