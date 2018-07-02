<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="hero is-install is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Yeti Forums Installer</h3>
                <div class="box">
                    <figure class="avatar_install">
                        <img src="<?= base_url('assets/img/logo.png') ?>" width="120">
                    </figure>

                    <article class="message is-success">
                        <div class="message-body">
                            Database tables have been created.
                        </div>
                    </article>

                    <?php
                        if (validation_errors()) {
                            echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                        }

                        if (isset($error)) {
                            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                        }
                    ?>

                    <h5>Site Settings</h5>

                    <?= form_open(); ?>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'admin_username', 'id' => 'admin_username', 'placeholder' => 'Admin Username', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'admin_email', 'id' => 'admin_email', 'placeholder' => 'Admin Email', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'admin_password', 'id' => 'admin_password', 'placeholder' => 'Admin Password', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'admin_confirm_password', 'id' => 'admin_confirm_password', 'placeholder' => 'Confirm Password', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <hr>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'forum_title', 'id' => 'forum_title', 'placeholder' => 'Forum Title', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'base_url', 'id' => 'base_url', 'placeholder' => 'Base Url', 'class' => 'input is-medium')) ?>
                                <p class="help is-danger">E.g. http://localhost/yoursite/</p>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button class="button is-link is-medium is-fullwidth"><?= $this->lang->line('button_continue'); ?></button>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>
