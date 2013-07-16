<?php 

//echo $this->Form->create('User', array('action' => 'login'));
//echo $this->Form->inputs(array(
//    'legend' => __('Login'),
//    'username',
//    'password'
//));
//echo $this->Form->end('Login');
?>

<h2>Login</h2>
<?php
echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login')));
echo $this->Form->input('User.username');
echo $this->Form->input('User.password');
echo $this->Form->end('Login');
?>