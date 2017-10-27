<strong>You're currently logged in as: <?= $current_user; ?></strong>

<hr>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>ROLE</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user): ?>
			<tr>
				<td><?= $user['User']['id']; ?></td>
				<td><?= $user['User']['username']; ?></td>
				<td><?= $user['User']['role']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>