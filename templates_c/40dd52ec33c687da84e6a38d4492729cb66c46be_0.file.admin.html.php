<?php
/* Smarty version 3.1.34-dev-7, created on 2020-11-18 14:50:33
  from 'D:\inetpub\www\plants\templates\admin.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5fb534b933c688_15629341',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '40dd52ec33c687da84e6a38d4492729cb66c46be' => 
    array (
      0 => 'D:\\inetpub\\www\\plants\\templates\\admin.html',
      1 => 1605711031,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5fb534b933c688_15629341 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Page</title>
  <link rel="stylesheet" href="include/css/style_admin.css" type="text/css">
  <?php echo '<script'; ?>
 src="include/js/admin.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
 src="include/js/ajax_admin.js"><?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
>document.addEventListener("DOMContentLoaded", function(){init_admin()})<?php echo '</script'; ?>
>
  <?php echo '<script'; ?>
>document.addEventListener("DOMContentLoaded", function(){init_admin_ajax()})<?php echo '</script'; ?>
>
</head>
<body>
  <main>
    <nav>
    <?php echo $_smarty_tpl->tpl_vars['nav']->value;?>

    </nav>
    <header>
      <em>header</em>
    </header>
    <section class="main">
      <div class="orders">
        <div class="order_list"><?php echo $_smarty_tpl->tpl_vars['orders']->value;?>
</div>
        <div class="customer_info"><em>customer information</em></div>
      </div>
      <div class="statistics"></div>
      <div class="new_product"></div>
    </section>
  </main>
</body>
</html><?php }
}
