<?php /* Smarty version 2.6.18, created on 2014-12-10 15:45:07
         compiled from options/endsection.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 't', 'options/endsection.html', 8, false),)), $this); ?>
    <tr>
        <td height='10' colspan='4'>&nbsp;</td>
    </tr>
    <?php if ($this->_tpl_vars['aItem']['hasRequiredField']): ?>
    <tr>
        <td></td>
        <td colspan='3' class="required-explanation">
          <span class="required">*</span> <?php echo OA_Admin_Template::_function_t(array('str' => 'RequiredField'), $this);?>

        </td>
    </tr>
    <?php endif; ?>
    <tr class="break" >
        <td colspan='4'>
        </td>
    </tr>
</table>
<br /><br />