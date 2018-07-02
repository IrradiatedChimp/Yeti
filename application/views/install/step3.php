<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="hero is-install is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Yeti Forums Installer</h3>
                <div class="box">
                    <figure class="avatar">
                        <img src="<?= base_url('assets/img/logo.png') ?>" width="120">
                    </figure>

                    <h5>Database Creation</h5>

                    <article class="message is-success">
                        <div class="message-body">
                            Your database <code>`<?= $_COOKIE['db_name']; ?>`</code> has been successfully created.
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

                    <p>Please click on the "Continue" button below to generate the required tables for your forum.</p>

                    <?= form_open(); ?>

                        <input type="hidden" id="db_name_cookie" name="db_name_cookie" value="<?= $_COOKIE['db_name'] ?>">

                        <hr>

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
