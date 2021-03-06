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

{header}

<body>

{navigation}

{hero}

<section class="section">
    <div class="container">
        <div class="columns">

            <div class="column is-10">
                {content}
            </div>

            <div class="column is-2">
                {sidebar}
            </div>
        </div>
    </div>
</section>

{footer}

<!-- Include JQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Include application js -->
<script src="<?= base_url('assets/js/application.js') ?>"></script>

</body>
</html>
