<?php /* Smarty version 2.6.18, created on 2015-01-11 12:05:08
         compiled from plugin-group-index-list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'plugin-group-index-list.html', 30, false),array('function', 'cycle', 'plugin-group-index-list.html', 37, false),)), $this); ?>

<?php if (! $this->_tpl_vars['hideSwitcher']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "plugin-group-switcher.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<table class="data plugins-table" >
     <thead>
        <tr>
            <td>Group</td>
            <td>Version</td>
            <td>Author</td>
            <td>Extends</td>
            <td>Status</td>
            <td colspan="3">Actions</td>
        </tr>
     </thead>

    <tbody>
      <?php if (! count($this->_tpl_vars['aPlugins'])): ?>
        <tr class="even">
            <td colspan="6">
             <p>No component groups.</p>
            </td>
        </tr>
      <?php else: ?>
        <?php echo smarty_function_cycle(array('name' => 'bgclass','values' => "odd,even",'assign' => 'bgClass','reset' => 1), $this);?>

        <?php $_from = $this->_tpl_vars['aPlugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['aPlugin']):
?>
        <?php echo smarty_function_cycle(array('name' => 'bgclass','assign' => 'bgClass'), $this);?>

            <tr class="<?php echo $this->_tpl_vars['bgClass']; ?>
">
                <td>
                    <?php if ($this->_tpl_vars['aPlugin']['displayname'] != ''): ?>
                        <?php echo $this->_tpl_vars['aPlugin']['displayname']; ?>

                    <?php else: ?>
                        <?php echo $this->_tpl_vars['name']; ?>

                    <?php endif; ?>
                </td>
                <td><?php echo $this->_tpl_vars['aPlugin']['version']; ?>
</td>
                <td><?php if ("{".($this->_tpl_vars['aPlugin']).".authoremail"): ?><a href="mailto:<?php echo $this->_tpl_vars['aPlugin']['authoremail']; ?>
"><?php endif; ?><?php echo $this->_tpl_vars['aPlugin']['author']; ?>
<?php if ("{".($this->_tpl_vars['aPlugin']).".authoremail"): ?></a><?php endif; ?></td>
                <td><?php echo $this->_tpl_vars['aPlugin']['extends']; ?>
</td>
                <td>
                    <?php if ($this->_tpl_vars['aPlugin']['installed']): ?>
                        <?php if ($this->_tpl_vars['aPlugin']['enabled']): ?>Enabled
                        <?php else: ?>Disabled
                        <?php endif; ?>
                    <?php else: ?>Not installed
                    <?php endif; ?>
                </td>
                <td><a href='plugin-index.php?action=info&group=<?php echo $this->_tpl_vars['aPlugin']['name']; ?>
&parent=<?php echo $this->_tpl_vars['aPackage']['name']; ?>
' ><span class="action icon details">Details</span></a></td>
                <td><?php if ($this->_tpl_vars['aPlugin']['settings']): ?><a href='plugin-index.php?action=settings&group=<?php echo $this->_tpl_vars['aPlugin']['name']; ?>
&parent=<?php echo $this->_tpl_vars['aPackage']['name']; ?>
' ><span class="action icon settings">Settings</span></a><?php endif; ?></td>
                <td><?php if ($this->_tpl_vars['aPlugin']['preferences']): ?><a href='plugin-index.php?action=preferences&group=<?php echo $this->_tpl_vars['aPlugin']['name']; ?>
&parent=<?php echo $this->_tpl_vars['aPackage']['name']; ?>
' ><span class="action icon preferences">Preferences</span></a><?php endif; ?></td>
            </tr>
        <?php endforeach; endif; unset($_from); ?>
       <?php endif; ?>
    </tbody>
</table>