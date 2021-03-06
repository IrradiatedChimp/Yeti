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
 */?>

<section class="hero is-install is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Yeti Forums Installer</h3>
                <div class="box_install">
                    <figure class="avatar_install">
                        <img src="<?= base_url('assets/img/logo.png') ?>" width="120">
                    </figure>

                    <article class="message is-success">
                        <div class="message-body">
                            All site settings have been updated successfully.
                        </div>
                    </article>

                    <p>The installation process has finished.</p>
                    <p>For security reasons, all files related to this installer will be deleted after you click the "Finish the installation" button.</p>
                    <p>You will then be redirect to the home page of your forum.</p>
                    <p>Login as the Admin (with the account you created just before) once the installation is finished, and start to build your forum.</p>
                    <p><strong>Have fun, and thank you for using Yeti Forums.</strong></p>

                    <div class="is-divider"></div>

                    <div class="field">
                        <div class="control">
                            <a class="button is-link is-medium is-fullwidth" href="<?= site_url('install/deleteFiles') ?>">Finish the installation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
