
<h1><?= h($users->username) ?></h1>
<p><?= h($users->first_name) ?></p>
<p><small>Created: <?= $users->created ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $users->id]) ?></p>