<?php /* Smarty version 2.6.18, created on 2015-01-11 11:37:21
         compiled from plugin-index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'plugin-index.html', 14, false),array('modifier', 'count', 'plugin-index.html', 80, false),array('function', 't', 'plugin-index.html', 15, false),array('function', 'cycle', 'plugin-index.html', 87, false),)), $this); ?>

<?php if ($this->_tpl_vars['configLocked']): ?>
    <div class='errormessage'><img class='errormessage' src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/padlock-<?php echo $this->_tpl_vars['image']; ?>
.gif' width='16' height='16' border='0' align='absmiddle'>
        <?php echo OA_Admin_Template::_function_t(array('str' => 'EditConfigNotPossible'), $this);?>

    </div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "plugin-group-switcher.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="control-panel">
    <form name="packageform" id="packageform" method="post" action="plugin-index.php" enctype="multipart/form-data">
    <div class="control-set left">
        <input name="package" value="1" type="hidden">
        <input name="token"   value="<?php echo $this->_tpl_vars['token']; ?>
" type="hidden" />
    <span class='corner bottom-left'></span>
    <span class='corner bottom-right'></span>
      <h2>Install new plugin</h2>
      Select file
      <input name="filename" tabindex="1" type="file" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
      <input value="Install" name="install" tabindex="2" type="submit" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
      <input value="Import (code only)" name="import" tabindex="3" type="submit" <?php if ($this->_tpl_vars['configLocked']): ?>disabled='true'<?php endif; ?>>
    </div>
    </form>
</div>


<?php if ($this->_tpl_vars['formError'] && $this->_tpl_vars['formError']['id'] > 0 && $this->_tpl_vars['formError']['message']): ?>
<div class="error-box" style="margin-bottom: 10px">
    <?php echo ((is_array($_tmp=$this->_tpl_vars['formError']['message'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['aWarnings']): ?>
    <div class="error-box" style="margin-bottom: 10px">
        <?php $_from = $this->_tpl_vars['aWarnings']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['warning']):
?>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['warning'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

            <br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
<?php if ($this->_tpl_vars['aErrors']): ?>
    <div class="error-box" style="margin-bottom: 10px">
        <?php $_from = $this->_tpl_vars['aErrors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['error']):
?>
            <?php echo ((is_array($_tmp=$this->_tpl_vars['error'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

            <br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>
<?php if ($this->_tpl_vars['aMessages']): ?>
    <div class="infomessage" style="margin-bottom: 10px">
        <?php $_from = $this->_tpl_vars['aMessages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['idx'] => $this->_tpl_vars['message']):
?>
            <?php echo $this->_tpl_vars['message']; ?>

            <br />
        <?php endforeach; endif; unset($_from); ?>
    </div>
<?php endif; ?>

<table class="data" >
    <thead>
        <tr>
            <td>Name</td>
            <td>Author</td>
            <td>Status</td>
            <td colspan="3">Actions</td>
        </tr>
    </thead>

    <tbody>
      <?php if (! count($this->_tpl_vars['aPackages'])): ?>
        <tr class="even">
            <td colspan="6">
             <p>No plugins installed.</p>
            </td>
        </tr>
      <?php else: ?>
      <?php echo smarty_function_cycle(array('name' => 'bgclass','values' => "odd,even",'assign' => 'bgClass','reset' => 1), $this);?>

      <?php $_from = $this->_tpl_vars['aPackages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['aitem']):
?>
          <?php if (! $this->_tpl_vars['configLocked'] || $this->_tpl_vars['aitem']['enabled']): ?>
          <?php echo smarty_function_cycle(array('name' => 'bgclass','assign' => 'bgClass'), $this);?>

              <tr class="<?php echo $this->_tpl_vars['bgClass']; ?>
">
                  <td width="40%">
                     <div class="item-info">
                         <p>
                            <span class="name">
                                <?php if ($this->_tpl_vars['aitem']['displayname'] != ''): ?>
                                    <?php echo $this->_tpl_vars['aitem']['displayname']; ?>

                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['name']; ?>

                                <?php endif; ?>
                            </span>
                            <span class="version"><?php echo $this->_tpl_vars['aitem']['version']; ?>
</span>
                         </p>
                         <p><?php echo $this->_tpl_vars['aitem']['description']; ?>
</p>
                     </div>
                  </td>
                  <td><?php if ("{".($this->_tpl_vars['aitem']).".authoremail"): ?><a href="mailto:<?php echo $this->_tpl_vars['aitem']['authoremail']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['aitem']['author']; ?>
<?php if ("{".($this->_tpl_vars['aitem']).".authoremail"): ?></a><?php endif; ?></td>
                  <td><?php if ($this->_tpl_vars['aitem']['enabled'] > 0): ?>Enabled<?php else: ?>Disabled<?php endif; ?></td>
                  <td><a href='plugin-index.php?action=info&package=<?php echo $this->_tpl_vars['name']; ?>
' ><span class="action icon details">Details</span></a></td>
                  <td>
                    <?php if ($this->_tpl_vars['configLocked']): ?>&nbsp;<?php else: ?>
                        <?php if ($this->_tpl_vars['aitem']['enabled'] > 0): ?>
                           <a href='plugin-index.php?action=disable&package=<?php echo $this->_tpl_vars['name']; ?>
' ><span class="action icon disable">Disable</span></a>
                        <?php else: ?>
                           <a href='plugin-index.php?action=enable&package=<?php echo $this->_tpl_vars['name']; ?>
' ><span class="action icon enable">Enable</span></a>
                        <?php endif; ?>
                    <?php endif; ?>
                  </td>
                  <?php if ($this->_tpl_vars['configLocked']): ?>&nbsp;<?php else: ?><td><a href='plugin-index.php?action=uninstall&package=<?php echo $this->_tpl_vars['name']; ?>
' ><span class="action icon uninstall">Uninstall</span></a></td><?php endif; ?>
              </tr>
          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
       <?php endif; ?>
    </tbody>
</table>


