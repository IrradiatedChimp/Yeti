<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Name:    Yeti Forums
 * Author:  Chris Baines
 *          t3utonict3rror@gmail.com
 *
 * Created:  02.07.2018
 *
 * Requirements: PHP5 or above
 *
 * @package    Yeti Forums
 * @author     Chris Baines
 * @link       https://github.com/IrradiatedChimp/Yeti
 */
 ?>

 <div class="content">
     <div class="box">

         <?php
             if (validation_errors()) {
                 echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
             }

             if (isset($error)) {
                 echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
             }
         ?>

         <?= form_open() ?>

         <p class="subtitle is-4"><i class="fas fa-reply"></i> {discussion_title} </p>

         <div class="field">
             <div class="control">
                 <?= form_textarea(array('name' => 'content', 'id' => 'content', 'rows' => '10', 'placeholder' => 'Your content here...', 'class' => 'textarea is-medium')); ?>
             </div>
         </div>

         <div class="field">
             <div class="control">
                 <?= form_submit('submit', 'Post Reply', array('class' => 'button is-link is-medium is-fullwidth')) ?>
             </div>
         </div>

         <?= form_close() ?>

     </div>
 </div>
