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

<nav class="navbar is-light is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand logo">
            <a class="navbar-item" href="<?= site_url() ?>">
                <img src="<?= base_url('assets/img/logo.png') ?>"> Yeti Forums
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu">

            <div class="navbar-start">
                <a class="navbar-item" href="#">
                    Home
                </a>
            </div>

            <div class="navbar-end">

                <div class="navbar-item">
                    <p class="control has-icons-left">
                        <input class="input" type="text" placeholder="Search Forum">
                        <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </p>
                </div>

                <?php if (!$this->ion_auth->logged_in()) : ?>

                    <a class="navbar-item" href="<?= site_url('users/sign_up') ?>">
                        Sign Up
                    </a>

                    <a class="navbar-item" href="<?= site_url('users/log_in') ?>">
                        Log In
                    </a>

                <?php else : ?>

                    <a class="navbar-item" href="<?= site_url('users/logout') ?>">
                        Log Out
                    </a>
                    
                <?php endif ?>
            </div>
        </div>
    </div>
</nav>
