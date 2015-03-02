<?php /* Smarty version 2.6.18, created on 2014-12-10 15:45:07
         compiled from options/startsection.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'options/startsection.html', 23, false),array('modifier', 'is_array', 'options/startsection.html', 31, false),)), $this); ?>
    <br /><br />
    <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <tr>
            <td height='25' colspan='4'>
              <?php if ($this->_tpl_vars['aItem']['disableSubmit'] == 0): ?>
                  <input type='hidden' name='submitok' value='true'>
              <?php else: ?>
                  <input type='hidden' name='submitDisabled' value='true'>
              <?php endif; ?>
                <img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/icon-<?php echo $this->_tpl_vars['aItem']['icon']; ?>
.gif' width='16' height='16' align='absmiddle'>&nbsp;
                <b><?php echo $this->_tpl_vars['aItem']['name']; ?>
</b>
            </td>
        </tr>
        <tr height='1'>
	        <td bgcolor='#888888' width='30'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break.gif' height='1' width='30'></td>
	        <td bgcolor='#888888' width='250'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break.gif' height='1' width='250'></td>
	        <td bgcolor='#888888' width='100%'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break.gif' height='1' width='1'></td>
	        <td bgcolor='#888888' width='30'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break.gif' height='1' width='30'></td>
        </tr>
        <tr>
            <td height='10' colspan='4'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' width='30' height='1'></td>
        </tr>
        <?php if (count($this->_tpl_vars['aItem']['error'])): ?>
        <tr>
            <td width='30'>&nbsp;</td><td height='10' colspan='2'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                    </tr>
                        <td width='22' valign='top'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/error.gif' width='16' height='16'>&nbsp;&nbsp;</td>
                        <td valign='top'>
                            <font color='#AA0000'><b>
				            <?php if (is_array($this->_tpl_vars['aItem']['error'])): ?>
				                <?php $_from = $this->_tpl_vars['aItem']['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
				                    <?php echo $this->_tpl_vars['v']; ?>
<br />
				                <?php endforeach; endif; unset($_from); ?>
				            <?php else: ?>
				                <?php echo $this->_tpl_vars['aItem']['error']; ?>

				            <?php endif; ?>
                            </b></font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td height='10' width='30'>&nbsp;</td>
            <td height='10' width='200'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' width='200' height='1'></td>
            <td height='10' width='100%'>&nbsp;</td><td height='10' width='30'>&nbsp;</td>
        </tr>
        <tr>
            <td height='14' width='30'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='100%'></td>
            <td height='14' width='200'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/break-l.gif' height='1' width='200' vspace='6'></td>
            <td height='14' width='100%'>&nbsp;</td><td height='14' width='30'><img src='<?php echo $this->_tpl_vars['assetPath']; ?>
/images/spacer.gif' height='1' width='100%'>
        </tr>
        <?php endif; ?>