<?php /* Smarty version 2.6.18, created on 2014-12-10 16:18:36
         compiled from agency-access.html */ ?>
<?php if ($this->_tpl_vars['infomessage']): ?>
  <div class='infomessage'>
    <?php echo $this->_tpl_vars['infomessage']; ?>

  </div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user-access.html", 'smarty_include_vars' => array('users' => $this->_tpl_vars['users'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>