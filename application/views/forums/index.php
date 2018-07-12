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
    <div class="dropdown is-hoverable">
        <div class="dropdown-trigger">
            <button class="button" aria-haspopup="true" aria-controls="dropdown-menu1">
                <span>Latest</span>
                <span class="icon is-small">
                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                </span>
            </button>
        </div>

        <div class="dropdown-menu" id="dropdown-menu1" role="menu">
            <div class="dropdown-content">
                <a href="#" class="dropdown-item is-active">
                    Latest
                </a>
                <a href="#" class="dropdown-item">
                    Top
                </a>
                <a href="#" class="dropdown-item">
                    Newest
                </a>
                <a href="#" class="dropdown-item">
                    Oldest
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">

    <?php if ($has_discussions == 1) : ?>
        {discussions}
            {block}
        {/discussions}
    <?php else : ?>
        <p>No discussions exist in the database, Please create some.</p>
    <?php endif ?>

</div>
