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

 <?php if ($posts) : ?>
     <?php foreach($posts as $post) : ?>

         <article class="media">
             <figure class="media-left">
                 <p class="image is-64x64 avatar">
                     <img src="<?= $post->avatar ?>">
                 </p>
             </figure>

             <div class="media-content">
                 <div class="content">
                     <p>
                         <?= $post->content ?>
                     </p>
                 </div>
             </div>
         </article>

     <?php endforeach ?>
 <?php else : ?>

 <?php endif ?>
