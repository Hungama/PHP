<?php /* Smarty version 2.6.18, created on 2014-12-10 16:11:28
         compiled from user-access.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'user-access.html', 22, false),array('function', 'cycle', 'user-access.html', 41, false),array('modifier', 'escape', 'user-access.html', 49, false),)), $this); ?>

  <tr>
    <td width='100%' colspan="3">
<table id="user-access-table" width="100%" cellspacing="0" cellpadding="0" border="0">
  <thead>
    <tr height="25">
    <?php if ($this->_tpl_vars['sso']): ?>
      <td class="first" style="width: 25%"><?php echo OA_Admin_Template::_function_t(array('str' => 'EMail'), $this);?>
</td>
    <?php else: ?>
      <td class="first" style="width: 10%"><?php echo OA_Admin_Template::_function_t(array('str' => 'Username'), $this);?>
</td>
      <td style="width: 25%"><?php echo OA_Admin_Template::_function_t(array('str' => 'EMail'), $this);?>
</td>
    <?php endif; ?>
      <td style="width: 20%"><?php echo OA_Admin_Template::_function_t(array('str' => 'ContactName'), $this);?>
</td>
    <?php if ($this->_tpl_vars['sso']): ?>
      <td style="width: 15%"><?php echo OA_Admin_Template::_function_t(array('str' => 'LastLoggedIn'), $this);?>
</td>
    <?php else: ?>
      <td style="width: 15%"><?php echo OA_Admin_Template::_function_t(array('str' => 'DateLinked'), $this);?>
</td>
    <?php endif; ?>
      <td style="width: 25%"></td>
    </tr>

    <tr class="break">
      <td colspan="5" />
    </tr>
  </thead>

  <?php echo smarty_function_cycle(array('name' => 'row','values' => "even,odd",'assign' => 'rowType'), $this);?>

  <?php $_from = $this->_tpl_vars['users']['aUsers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
    <?php echo smarty_function_cycle(array('name' => 'row','assign' => 'rowType'), $this);?>

    <tbody class="<?php echo $this->_tpl_vars['rowType']; ?>
">
      <tr height="25" <?php if ($this->_tpl_vars['user']['justModified']): ?>class="hl"<?php endif; ?>>
      <?php if ($this->_tpl_vars['sso']): ?>
        <td class="first"><a href="<?php echo $this->_tpl_vars['editPage']; ?>
?userid=<?php echo $this->_tpl_vars['user']['user_id']; ?>
&amp;<?php echo $this->_tpl_vars['entityIdName']; ?>
=<?php echo $this->_tpl_vars['entityIdValue']; ?>
"><?php echo $this->_tpl_vars['user']['email_address']; ?>
</a></td>
      <?php else: ?>
        <td class="first"><a href="<?php echo $this->_tpl_vars['editPage']; ?>
?userid=<?php echo $this->_tpl_vars['user']['user_id']; ?>
&amp;<?php echo $this->_tpl_vars['entityIdName']; ?>
=<?php echo $this->_tpl_vars['entityIdValue']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a></td>
        <td><a href="<?php echo $this->_tpl_vars['editPage']; ?>
?userid=<?php echo $this->_tpl_vars['user']['user_id']; ?>
&amp;<?php echo $this->_tpl_vars['entityIdName']; ?>
=<?php echo $this->_tpl_vars['entityIdValue']; ?>
"><?php echo $this->_tpl_vars['user']['email_address']; ?>
</a></td>
      <?php endif; ?>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['user']['contact_name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
      <?php if ($this->_tpl_vars['sso']): ?>
        <td><?php echo $this->_tpl_vars['user']['date_last_login']; ?>
</td>
      <?php else: ?>
        <td><?php echo $this->_tpl_vars['user']['date_created']; ?>
</td>
      <?php endif; ?>
        <td class="last">
          <a href="<?php echo $this->_tpl_vars['editPage']; ?>
?userid=<?php echo $this->_tpl_vars['user']['user_id']; ?>
&amp;<?php echo $this->_tpl_vars['entityIdName']; ?>
=<?php echo $this->_tpl_vars['entityIdValue']; ?>
" class="permissions" style="padding-right: 10px"><?php echo OA_Admin_Template::_function_t(array('str' => 'Permissions'), $this);?>
</a>
          <a href="<?php echo $this->_tpl_vars['unlinkPage']; ?>
?userid=<?php echo $this->_tpl_vars['user']['user_id']; ?>
&amp;<?php echo $this->_tpl_vars['entityIdName']; ?>
=<?php echo $this->_tpl_vars['entityIdValue']; ?>
" class="unlink<?php if ($this->_tpl_vars['user']['toDelete']): ?> unlink-last<?php else: ?> unlink-normal<?php endif; ?>"><?php echo OA_Admin_Template::_function_t(array('str' => 'Remove'), $this);?>
</a>
        </td>
      </tr>

      <tr class="break">
        <td colspan="5" />
      </tr>
    </tbody>
  <?php endforeach; else: ?>
    <tbody class="odd">
      <tr height="25" <?php if ($this->_tpl_vars['user']['justModified']): ?>class="hl"<?php endif; ?>>
        <td class="norows" colspan="5">No users added to this entity<?php if ($this->_tpl_vars['linkUrl']): ?>, you can <a href="<?php echo $this->_tpl_vars['linkUrl']; ?>
">add an existing or a new user here</a><?php endif; ?></td>
      </tr>

      <tr class="break">
        <td colspan="5" />
      </tr>
    </tbody>
  <?php endif; unset($_from); ?>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "confirmation-dialog.html", 'smarty_include_vars' => array('id' => "unlink-last",'linkToConfirmClass' => "unlink-last",'title' => 'Removing user from last entity','message' => "Removing user from last entity will cause the user to be deleted. Would you like to remove this user?",'confirmLabel' => "Remove &amp; delete user")));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "confirmation-dialog.html", 'smarty_include_vars' => array('id' => "unlink-normal",'linkToConfirmClass' => "unlink-normal",'title' => 'Removing user','message' => "Are you sure you want to remove this user?",'confirmLabel' => 'Remove user')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    </td>
  </tr>