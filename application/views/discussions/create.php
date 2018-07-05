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

         <?= form_open(site_url('discussions/create'), array('name' => 'create', 'id' => 'create')) ?>

         <p class="subtitle is-4">Start a discussion about...</p>

         <div class="field">
             <div class="control">
                 <?= form_input(array('name' => 'title', 'id' => 'title', 'placeholder' => 'Discussion Title', 'class' => 'input is-medium')); ?>
             </div>
         </div>

         <div class="is-divider" data-content="Choose a Category"></div>

         <div class="field">
            <?php if ($categories) : ?>
                <?php foreach($categories as $category) : ?>
                    <?= $category->field ?>
                    <?= $category->label ?>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No categories have been created yet.</p>
            <?php endif;?>
         </div>

         <div class="is-divider" data-content="Content"></div>

         <div class="field">
             <div class="control">
                 <?= form_textarea(array('name' => 'content', 'id' => 'content', 'rows' => '10', 'placeholder' => 'Your content here...', 'class' => 'textarea is-medium')); ?>
             </div>
         </div>

         <div class="field">
             <div class="control">
                 <?= form_submit('submit', 'Create Discussion', array('class' => 'button is-link is-medium is-fullwidth')) ?>
             </div>
         </div>

         <?= form_close() ?>
     </div>

 </div>
