<?php /* Smarty version 2.6.18, created on 2014-02-25 13:26:50
         compiled from edit-table/main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'edit-table/main.html', 16, false),array('modifier', 'default', 'edit-table/main.html', 45, false),array('modifier', 'cat', 'edit-table/main.html', 88, false),array('function', 'tabindex', 'edit-table/main.html', 46, false),array('function', 'html_options', 'edit-table/main.html', 69, false),)), $this); ?>

<?php if (! $this->_tpl_vars['_e']['hidden']): ?>
<?php if ($this->_tpl_vars['_e']['type'] == 'section'): ?><table border='0' width='100%' cellpadding='0' cellspacing='0'>
<tr><td height='25' colspan='3'><b><?php echo $this->_tpl_vars['_e']['title']; ?>
</b></td></tr>
<tr height='1'><td width='30'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break.gif' height='1' width='30'></td>
<td width='200'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break.gif' height='1' width='200'></td>
<td width='100%'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break.gif' height='1' width='100%'></td></tr>
<tr><td height='10' colspan='3'>&nbsp;</td></tr>
    <?php if ($this->_tpl_vars['_e']['errors']): ?>
    <tr><td>&nbsp;</td><td height='10' colspan='2'>
    <table cellpadding='0' cellspacing='0' border='0'><tr><td>
    <img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/error.gif' align='absmiddle'>&nbsp;
    <?php $_from = $this->_tpl_vars['_e']['errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['_eErr']):
?>
    <font color='#AA0000'><b><?php echo $this->_tpl_vars['_eErr']; ?>
</b></font><br />
    <?php endforeach; endif; unset($_from); ?>
    </td></tr></table></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>
    <tr><td><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break-l.gif' height='1' width='200' vspace='6'></td></tr>
    <?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['_e']['type'] != 'section' && $this->_tpl_vars['_e']['break']): ?>
    <tr>
        <td><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/spacer.gif' height='1' width='30'></td>
        <td colspan='1'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/spacer.gif' height='1' width='100%'>
    </tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['_e']['type'] == 'text' || $this->_tpl_vars['_e']['type'] == 'password' || ! $this->_tpl_vars['_e']['type']): ?>
    <tr>
        <td width='30'>&nbsp;</td><td width='200'><label <?php if ($this->_tpl_vars['_e']['id']): ?>for="<?php echo $this->_tpl_vars['_e']['id']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['_e']['content']; ?>
</label></td>
        <td width='100%'>
        <?php if ($this->_tpl_vars['_e']['freezed']): ?>
            <b><?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</b>
        <?php else: ?>
            <input onBlur='max_formValidateElement(this);' class="flat <?php if ($this->_tpl_vars['_e']['clientValid']): ?> {<?php echo $this->_tpl_vars['_e']['clientValid']; ?>
}<?php endif; ?>" type="<?php echo ((is_array($_tmp=@$this->_tpl_vars['_e']['type'])) ? $this->_run_mod_handler('default', true, $_tmp, 'text') : smarty_modifier_default($_tmp, 'text')); ?>
"
                name="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>

                <?php if ($this->_tpl_vars['_e']['id'] != ''): ?>id="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['id'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>
                <?php if ($this->_tpl_vars['_e']['style'] == 'small'): ?>size="25"<?php else: ?> size="35" style="width:350px;"<?php endif; ?>
                <?php if ($this->_tpl_vars['_e']['disabled']): ?> disabled="disabled"<?php endif; ?>
                <?php if ($this->_tpl_vars['_e']['maxlength']): ?> maxlength="<?php echo $this->_tpl_vars['_e']['maxlength']; ?>
"<?php endif; ?>
                <?php if ($this->_tpl_vars['_e']['title']): ?> title="<?php echo $this->_tpl_vars['_e']['title']; ?>
"<?php endif; ?>>
        <?php endif; ?>
        </td>
    </tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['_e']['type'] == 'textarea'): ?>
    <tr>
        <td width='30'>&nbsp;</td><td width='200'><?php echo $this->_tpl_vars['_e']['content']; ?>
</td>
        <td width='100%'>
            <textarea class='flat' cols='45' rows='6' name='<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
' wrap='off' dir='ltr' style='width:350px;'<?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
<?php if ($this->_tpl_vars['_e']['disabled']): ?> disabled="disabled"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
        </td>
    </tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['_e']['type'] == 'select'): ?>
    <tr>
        <td width='30'>&nbsp;</td><td width='200'><?php echo $this->_tpl_vars['_e']['content']; ?>
</td>
        <td width='100%'>
            <select name="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>
<?php if ($this->_tpl_vars['_e']['style'] == 'big'): ?> style="width:350px;"<?php elseif ($this->_tpl_vars['_e']['style']): ?> style="<?php echo $this->_tpl_vars['_e']['style']; ?>
"<?php endif; ?><?php if ($this->_tpl_vars['_e']['onchange']): ?> onchange="<?php echo $this->_tpl_vars['_e']['onchange']; ?>
"<?php endif; ?><?php if ($this->_tpl_vars['_e']['disabled']): ?> disabled="disabled"<?php endif; ?>>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['_e']['options'],'selected' => $this->_tpl_vars['_e']['value']), $this);?>

            </select>
        </td>
    </tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['_e']['type'] == 'checkbox'): ?>
    <tr>
        <td width='30'>&nbsp;</td>
        <td colspan='2'>
            <?php if ($this->_tpl_vars['_e']['old']): ?><input type='hidden' name="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
_old" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['old'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php endif; ?>
            <?php if ($this->_tpl_vars['_e']['indent']): ?><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/indent.gif'><?php endif; ?><input type='checkbox' name="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"
                id="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['_e']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['_e']['name']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['_e']['name'])))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php echo OA_Admin_Template::_function_tabindex(array(), $this);?>

                <?php if ($this->_tpl_vars['_e']['checked']): ?> checked="checked"<?php endif; ?>
                <?php if ($this->_tpl_vars['_e']['disabled']): ?> disabled="disabled"<?php endif; ?>
                <?php if ($this->_tpl_vars['_e']['onclick']): ?> onclick="<?php echo ((is_array($_tmp=$this->_tpl_vars['_e']['onclick'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>>&nbsp;<label for="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['_e']['id'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['_e']['name']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['_e']['name'])))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"><?php echo $this->_tpl_vars['_e']['content']; ?>
</label>
        </td>
    </tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['_e']['type'] == 'custom'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp='edit-table/custom-')) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['_e']['template']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['_e']['template'])))) ? $this->_run_mod_handler('cat', true, $_tmp, '.html') : smarty_modifier_cat($_tmp, '.html')), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['_e']['type'] == 'section'): ?>
<?php echo $this->_tpl_vars['_e']['content']; ?>

    <tr>
        <td height='10' colspan='3'>&nbsp;</td>
    </tr>
    <tr height='1'><td width='30'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break.gif' height='1' width='30'></td>
        <td width='200'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break.gif' height='1' width='200'></td>
        <td width='100%'><img src='<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/break.gif' height='1' width='100%'></td>
    </tr>
    <tr>
        <td height='10' colspan='3'>&nbsp;</td>
    </tr>
</table>
<?php endif; ?>
<?php endif; ?>