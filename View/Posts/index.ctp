<h1>Blog Post <?= $current_user; ?></h1>
<?= 
	$this->Html->link(
		'Add Post',
		array('controller' => 'posts', 'action' => 'add')
	); 
?>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Created</th>
			<th>>_</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($posts as $post): ?>
			<tr>
				<td><?= $post['Post']['id']; ?></td>
				<td>
					<?=
						$this->Html->link(
							$post['Post']['title'], 
							array('controller' => 'posts','action' => 'view',$post['Post']['id'])
						);
					?>
				</td>
				<td><?= $post['Post']['created']; ?></td>
				<td>
					<?= $this->Html->link(
							'edit',
							array('action' => 'edit', $post['Post']['id'])
					); ?>
				</td>
				<td>
					<?=
						$this->Form->postLink(
							'x',
							array('action' => 'delete', $post['Post']['id']),
							array('confirm' => 'Are you sure?')
						);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php unset($post); ?>
	</tbody>
</table>