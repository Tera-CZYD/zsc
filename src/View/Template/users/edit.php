<h1>Edit User</h1>
<?php
    echo $this->Form->create($user);
    echo $this->Form->control('username');
    echo $this->Form->control('first_name');
    echo $this->Form->button(__('Update User'));
    echo $this->Form->end();
?>