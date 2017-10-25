<div class="users form">
	<?= $this->Form->create('User'); ?>
	<fieldset>
		<legend>Add User</legend>
		<?= $this->Form->input('username'); ?>
		<?= $this->Form->input('password'); ?>
		<?= $this->Form->input('role', array(
				'options' => array('admin' => 'Admin', 'author' => 'Author')
			)); ?>
	</fieldset>
	<?= $this->Form->end(__('Submit')); ?>
</div>