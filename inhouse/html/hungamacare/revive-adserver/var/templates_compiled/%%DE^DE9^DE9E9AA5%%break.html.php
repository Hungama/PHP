<?php /* Smarty version 2.6.18, created on 2014-12-10 15:45:07
         compiled from options/break.html */ ?>
<?php if (! isset ( $this->_tpl_vars['aItem']['size'] ) || $this->_tpl_vars['aItem']['size'] == '' || $this->_tpl_vars['aItem']['size'] == 'small'): ?>
<tr>
    <td style="width: 30px; height: 1px;">&nbsp;</td>
    <td style="width: 250px; height: 20px;"><div style="height:1px;background-color: #bbbbbb;">&nbsp;</div></td>
    <td>&nbsp;</td>
    <td style="width: 30px; height: 1px;">&nbsp;</td>
</tr>
<?php elseif ($this->_tpl_vars['aItem']['size'] == 'large'): ?>
<tr>
    <td style="width: 30px; height: 1px;">&nbsp;</td>
    <td colspan='3' style="height: 20px;"><div style="height:1px; background-color: #bbbbbb;">&nbsp;</div></td>
</tr>
<?php elseif ($this->_tpl_vars['aItem']['size'] == 'full'): ?>
<tr>
    <td colspan='4' style="height: 32px;"><div style="height:1px; background-color: #bbbbbb;">&nbsp;</div></td>
</tr>
<?php elseif ($this->_tpl_vars['aItem']['size'] == 'empty'): ?>
<tr>
    <td style="width: 30px; height: 1px;">&nbsp;</td>
    <td style="width: 250px; height: 20px;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width: 30px; height: 1px;">&nbsp;</td>
</tr>
<?php endif; ?>