<?php
/* Smarty version 3.1.34-dev-7, created on 2020-11-03 12:48:07
  from 'D:\inetpub\www\plants\templates\main.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5fa1518749dd31_95965603',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bf3e24363043e0d46baeb3a52d2511cb9597ab77' => 
    array (
      0 => 'D:\\inetpub\\www\\plants\\templates\\main.html',
      1 => 1604407451,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5fa1518749dd31_95965603 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Main</title>
  <link rel="stylesheet" href="include/css/style_main.css" type="text/css">
  <?php echo '<script'; ?>
>document.addEventListener("DOMContentLoaded", function(){init_main()})<?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="include/js/main.js"><?php echo '</script'; ?>
>
</head>
<body>
  <div class="top">
    <?php echo $_smarty_tpl->tpl_vars['dropdown']->value;?>

    <div class="center"></div>

  </div>
  <div class="bot">
    <div class="overlay"></div>
    <?php echo $_smarty_tpl->tpl_vars['products']->value;?>

    <div class="cart_items">
      <h3>Shopping Cart</h3>
    </div>
  </div>
</body>
</html><?php }
}
