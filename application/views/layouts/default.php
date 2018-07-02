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

<section class="section">
    <div class="container">
        <div class="columns">

            <div class="column is-2">
                {sidebar}
            </div>

            <div class="column is-10">
                {content}
            </div>
        </div>
    </div>
</section>

{footer}

</body>
</html>
