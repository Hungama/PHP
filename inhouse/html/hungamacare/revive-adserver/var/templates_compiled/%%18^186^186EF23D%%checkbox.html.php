<?php /* Smarty version 2.6.18, created on 2015-01-11 12:01:50
         compiled from options/checkbox.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'options/checkbox.html', 5, false),)), $this); ?>
<tr>
    <td>&nbsp;</td>
    <td id='cell_<?php echo $this->_tpl_vars['aItem']['name']; ?>
' class='<?php if ($this->_tpl_vars['aItem']['disabled']): ?>celldisabled<?php else: ?>cellenabled<?php endif; ?>' colspan='2' width='100%'>
    <?php if (isset ( $this->_tpl_vars['aItem']['ident'] ) && $this->_tpl_vars['aItem']['indent']): ?>
        <img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/indent.gif'>
    <?php endif; ?>
        <input type='checkbox' name='<?php echo $this->_tpl_vars['aItem']['name']; ?>
' id='<?php echo $this->_tpl_vars['aItem']['name']; ?>
' value='true' <?php if ($this->_tpl_vars['aItem']['value'] == true): ?>checked='checked'<?php endif; ?> <?php if ($this->_tpl_vars['aItem']['disabled']): ?>disabled='disabled'<?php endif; ?>
            onClick='phpAds_refreshEnabled(); <?php echo $this->_tpl_vars['aItem']['onclick']; ?>
' tabindex='<?php echo $this->_tpl_vars['aItem']['tabindex']++; ?>
'><label for='<?php echo $this->_tpl_vars['aItem']['name']; ?>
'><?php echo $this->_tpl_vars['aItem']['text']; ?>
</label>
        <?php if (isset ( $this->_tpl_vars['aItem']['desc'] )): ?>
            <div class="checkboxDesc"><?php echo $this->_tpl_vars['aItem']['desc']; ?>
</div>
        <?php endif; ?>
    </td>
    <td><?php echo $this->_tpl_vars['this']->_showPadLock($this->_tpl_vars['aItem']); ?>
</td>
</tr>