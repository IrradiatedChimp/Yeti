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

{start_a_discussion}
<aside class="menu">
    <p class="menu-label"></p>
    <ul class="menu-list">
        <li><a href="<?= site_url() ?>"><span class="icon"><i class="far fa-comments"></i></span> All Discussions</a></li>
    </ul>
    <p class="menu-label">Categories</p>
    <ul class="menu-list">
        <?php if ($categories) : ?>
            <?php foreach($categories as $category) : ?>
                <li><a href="<?= $category->permalink ?>"><span class="icon has-text-<?= $category->class ?>"><i class="fas fa-square"></i></span> <?= $category->name ?></a></li>
            <?php endforeach; ?>
        <?php else : ?>
            <p>None</p>
        <?php endif ?>
    </ul>
</aside>
