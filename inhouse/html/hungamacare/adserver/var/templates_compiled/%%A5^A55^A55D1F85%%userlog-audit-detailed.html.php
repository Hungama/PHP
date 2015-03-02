<?php /* Smarty version 2.6.18, created on 2014-03-13 17:52:16
         compiled from userlog-audit-detailed.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'userlog-audit-detailed.html', 2, false),array('function', 'cycle', 'userlog-audit-detailed.html', 37, false),array('modifier', 'escape', 'userlog-audit-detailed.html', 11, false),)), $this); ?>
<div>
    <p class="tableTitle"><?php echo OA_Admin_Template::_function_t(array('str' => 'Event Details'), $this);?>
</p>
    <table class="data-grid table">
        <tbody>
            <tr class="odd">
                <td style="width: 30%"><?php echo OA_Admin_Template::_function_t(array('str' => 'ID'), $this);?>
</td>
                <td>#<?php echo $this->_tpl_vars['aAuditDetail']['contextid']; ?>
</td>
            </tr>
            <tr class="even">
                <td style="width: 30%"><?php echo OA_Admin_Template::_function_t(array('str' => 'Name'), $this);?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['aAuditDetail']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            </tr>
            <tr class="odd">
                <td style="width: 30%;"><?php echo OA_Admin_Template::_function_t(array('str' => 'Type'), $this);?>
</td>
                <td style="text-align:left;"><?php echo $this->_tpl_vars['aAuditDetail']['contextDescription']; ?>
</td>
            </tr>
            <tr class="even">
                <td class="label"><?php echo OA_Admin_Template::_function_t(array('str' => 'Action'), $this);?>
</td>
                <td style="text-align:left;"><?php echo OA_Admin_Template::_function_t(array('str' => $this->_tpl_vars['aAuditDetail']['action']), $this);?>
</td>
            </tr>
            <tr class="odd">
                <td class="label"><?php echo OA_Admin_Template::_function_t(array('str' => 'Username'), $this);?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['aAuditDetail']['username'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            </tr>
        </tbody>
    </table>
    <p class="tableTitle"><?php echo OA_Admin_Template::_function_t(array('str' => 'Event History'), $this);?>
</p>
    <table class="data-grid table">
	    <thead>
	        <tr class="header">
	            <th><?php echo OA_Admin_Template::_function_t(array('str' => 'Parameter'), $this);?>
</th>
	            <th><?php echo OA_Admin_Template::_function_t(array('str' => 'Value'), $this);?>
</th>
	        </tr>
	    </thead>
	    <tbody>
            <?php $_from = $this->_tpl_vars['aAuditDetail']['details']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['details'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['details']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['value']):
        $this->_foreach['details']['iteration']++;
?>
            <?php echo smarty_function_cycle(array('values' => 'odd,even','assign' => 'rowClass'), $this);?>

                <?php if (is_array ( $this->_tpl_vars['value'] )): ?>
            <tr class="<?php echo $this->_tpl_vars['rowClass']; ?>
">
                <td><?php echo $this->_tpl_vars['key']; ?>
</td>
                <td><?php if ($this->_tpl_vars['value']['was'] == ''): ?>empty<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['value']['was'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
<?php endif; ?>&nbsp;&rarr;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['value']['is'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            </tr>

                <?php else: ?>
            <tr class="<?php echo $this->_tpl_vars['rowClass']; ?>
">
                <td><?php echo $this->_tpl_vars['key']; ?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['value'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            </tr>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
	    </tbody>
    </table>

    <?php if (count ( $this->_tpl_vars['aAuditDetail']['children'] ) > 0): ?>
    <p class="tableTitle">Children History</p>
    <table class="data-grid table">
        <tbody>
            <tr class="header">
                <th width="15%"><a href="userlog-audit-detailed.php?<?php echo $this->_tpl_vars['urlParam']; ?>
">Timestamp</a>
                    <a href="userlog-index.php?<?php echo $this->_tpl_vars['urlParam']; ?>
">
                        <?php if ($this->_tpl_vars['orderdirection'] == 'up'): ?>
                        <img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/caret-u.gif" />
                        <?php else: ?>
                        <img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/caret-ds.gif" />
                        <?php endif; ?>
                    </a>
                </th>
                <th>Event</th>
                <th width="10%">&nbsp;</th>
            </tr>
            <?php $_from = $this->_tpl_vars['aAuditDetail']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['info'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['info']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['aValue']):
        $this->_foreach['info']['iteration']++;
?>
            <?php echo smarty_function_cycle(array('values' => 'odd,even','assign' => 'rowClass'), $this);?>

            <tr class="<?php echo $this->_tpl_vars['rowClass']; ?>
">
                <td><?php echo $this->_tpl_vars['aValue']['updated']; ?>
</td>
                <td>
                    <?php echo $this->_tpl_vars['aValue']['username']; ?>
 <?php echo $this->_tpl_vars['aValue']['action']; ?>
 <?php echo $this->_tpl_vars['aValue']['context']; ?>
 <?php if (! empty ( $this->_tpl_vars['aValue']['contextid'] )): ?>(#<?php echo $this->_tpl_vars['aValue']['contextid']; ?>
)<?php endif; ?>
                    <?php if (! empty ( $this->_tpl_vars['aValue']['parentcontext'] )): ?>
                        in <?php echo $this->_tpl_vars['aValue']['parentcontext']; ?>
 (#<?php echo $this->_tpl_vars['aValue']['parentcontextid']; ?>
)
                    <?php endif; ?>
                    <?php if (! empty ( $this->_tpl_vars['aValue']['hasChildren'] )): ?>
                        and additional items
                    <?php endif; ?>
                </td>
                <td><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/icon-zoom.gif" />&nbsp;<a href="userlog-audit-detailed.php?auditId=<?php echo $this->_tpl_vars['aValue']['auditid']; ?>
">View</a></td>
            </tr>
            <?php if (count ( $this->_tpl_vars['aValue']['children'] ) > 0): ?>
                <?php $_from = $this->_tpl_vars['aValue']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['val']):
?>
		            <tr class="<?php echo $this->_tpl_vars['rowClass']; ?>
">
		                <td><?php echo $this->_tpl_vars['val']['updated']; ?>
</td>
		                <td>
		                    <?php echo $this->_tpl_vars['val']['username']; ?>
 <?php echo $this->_tpl_vars['val']['action']; ?>
 <?php echo $this->_tpl_vars['val']['context']; ?>
 <?php if (! empty ( $this->_tpl_vars['val']['contextid'] )): ?>(#<?php echo $this->_tpl_vars['val']['contextid']; ?>
)<?php endif; ?>
		                    <?php if (! empty ( $this->_tpl_vars['val']['parentcontext'] )): ?>
		                        in <?php echo $this->_tpl_vars['val']['parentcontext']; ?>
 (#<?php echo $this->_tpl_vars['val']['parentcontextid']; ?>
)
		                    <?php endif; ?>
		                    <?php if (! empty ( $this->_tpl_vars['val']['hasChildren'] )): ?>
		                        and additional items
		                    <?php endif; ?>
		                </td>
		                <td><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['assetPath'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
/images/icon-zoom.gif" />&nbsp;<a href="userlog-audit-detailed.php?auditId=<?php echo $this->_tpl_vars['val']['auditid']; ?>
">View</a></td>
		            </tr>
                <?php endforeach; endif; unset($_from); ?>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>
    <?php endif; ?>

    <input type="Button" name="" value="<?php echo OA_Admin_Template::_function_t(array('str' => 'ReturnAuditTrail'), $this);?>
" onclick="document.location='userlog-index.php';" />
</div>