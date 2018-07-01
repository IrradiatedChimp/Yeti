<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<nav class="navbar is-light is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand logo">
            <a class="navbar-item" href="#">
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
                <a class="navbar-item" href="#">
                    Sign Up
                </a>

                <a class="navbar-item" href="#">
                    Log In
                </a>
            </div>
        </div>
    </div>
</nav>
