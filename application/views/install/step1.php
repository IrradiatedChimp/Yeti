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

<section class="hero is-install is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Yeti Forums Installer</h3>
                <div class="box_install">
                    <figure class="avatar_install">
                        <img src="<?= base_url('assets/img/logo.png') ?>" width="120">
                    </figure>

                    <h5>Database Settings</h5>

                    <?php
                        if (validation_errors()) {
                            echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                        }

                        if (isset($error)) {
                            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
                        }
                    ?>

                    <?= form_open(); ?>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'db_hostname', 'id' => 'db_hostname', 'placeholder' => 'MySQL Host', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'db_username', 'id' => 'db_username', 'placeholder' => 'MySQL Username', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('name' => 'db_password', 'id' => 'db_password', 'placeholder' => 'MySQL Password', 'class' => 'input is-medium')) ?>
                            </div>
                        </div>

                        <div class="is-divider"></div>

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
