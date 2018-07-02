<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<section class="hero is-install is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <div class="box">
                    <figure class="avatar_install">
                        <img src="<?= base_url('assets/img/logo.png') ?>" width="120">
                    </figure>
                    <?= form_open() ?>
                        <div class="field">
                            <div class="control">
                                <?= form_input(array('id' => 'identity', 'name' => 'identity', 'type' => 'text', 'class' => 'input is-medium', 'placeholder' => 'Email', 'value' => $this->form_validation->set_value('identity'))); ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <?= form_input(array('id' => 'password', 'name' => 'password', 'type' => 'password', 'class' => 'input is-medium', 'placeholder' => 'Password')) ?>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <?= form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
                                        Remember me
                                </label>
                            </div>
                        </div>

                        <hr>

                        <div class="field">
                            <div class="control">
                                <?= form_submit('submit', lang('login_submit_btn'), array('class' => 'button is-link is-medium is-fullwidth')) ?>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>

                <p class="has-text-grey"><a href="#">Sign Up</a> | <a href="#">Forgot Password</a></p>
            </div>
        </div>
    </div>
</section>
