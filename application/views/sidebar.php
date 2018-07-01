<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

{start_a_discussion}
<aside class="menu">
    <p class="menu-label"></p>
    <ul class="menu-list">
        <li><a href="<?= site_url() ?>"><span class="icon"><i class="far fa-comments"></i></span> All Discussions</a></li>
    </ul>
    <p class="menu-label">Categories</p>
    <ul class="menu-list">
        <?php foreach($categories as $category) : ?>
        <li><a href="<?= $category->permalink ?>"><span class="icon <?= $category->class ?>"><i class="fas fa-square"></i></span> <?= $category->name ?></a></li>
    <?php endforeach; ?>
    </ul>
</aside>
