<div class="loader" id="loader_tasksPjax"></div>

<? if (!empty($tasks)) { ?>
	
	<? 
		$arrowIcon = ($orderMod == 'DESC') ? '&uarr;' : '&darr;';			
	?>
	
	<div class="tasks-sort">
		Сортировать по: 
		<a href="Main/listTasks?page=<?=$page ?>&&order=created&&ordermod=<?=($order == 'created' && $orderMod == 'DESC') ? 'ASC' : 'DESC' ?>">дата<?=($order == 'created') ? ' ' . $arrowIcon : '' ?></a> | 
		<a href="Main/listTasks?page=<?=$page ?>&&order=username&&ordermod=<?=($order == 'username' && $orderMod == 'ASC') ? 'DESC' : 'ASC' ?>">имя пользователя<?=($order == 'username') ? ' ' . $arrowIcon : '' ?></a> | 
		<a href="Main/listTasks?page=<?=$page ?>&&order=email&&ordermod=<?=($order == 'email' && $orderMod == 'ASC') ? 'DESC' : 'ASC' ?>">e-mail<?=($order == 'email') ? ' ' . $arrowIcon : '' ?></a> | 
		<a href="Main/listTasks?page=<?=$page ?>&&order=completed&&ordermod=<?=($order == 'completed' && $orderMod == 'ASC') ? 'DESC' : 'ASC' ?>">статус<?=($order == 'completed') ? ' ' . $arrowIcon : '' ?></a>
	</div>
	
	<table>
		<? foreach($tasks as $task) { ?>
			<tr class="task">
				<td>
					<div class="font-weight-bold"><?=$task['username'] ?> <span class="grey"><?=$task['email'] ?><span class="float-right"><?=$task['created'] ?></span></span></div>
					<div class="task-text"><?=$task['text'] ?></div>
					<div class="task-status">
						Статус: <div class="status-icon-<?=($task['completed'] == 1 ? 'completed' : 'pending') ?>"></div>
						<? if (isset($user) && $user->name == 'admin') { ?>
							<button type="button" class="update-task-btn btn btn-link float-right" data-taskid="<?=$task['id'] ?>">Изменить</button>
						<? } ?>
					</div>
				</td>
				<td class="task-img">
					<?=!empty($task['img']) ? '<img src="' . SITE_URL . 'Uploads/' . $task['img'] . '" />' : '' ?>
				</td>
			</tr>
		<? } ?>
	</table>
	
	<div class="tasks-paging">
		<?
			$prevlink = ($page > 1) ? '<a href="Main/listTasks?page=1&&order=' . $order. '&&ordermod=' . $orderMod. '" title="В начало">&laquo;</a> <a href="Main/listTasks?page=' . ($page - 1) . '&&order=' . $order. '&&ordermod=' . $orderMod. '" title="Предыдущая страница">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
			$nextlink = ($page < $pagesTotal) ? '<a href="Main/listTasks?page=' . ($page + 1) . '&&order=' . $order. '&&ordermod=' . $orderMod. '" title="Следующая страница">&rsaquo;</a> <a href="Main/listTasks?page=' . $pagesTotal . '&&order=' . $order. '&&ordermod=' . $orderMod. '" title="Последняя страница">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
		?>
		<?=$prevlink ?> Страница <?=$page ?> из <?=$pagesTotal ?> <?=$nextlink ?>
	</div>
	
<? } else { ?>
	
	<div class="text-center">Отсутствуют задачи.</div>
	
<? } ?>