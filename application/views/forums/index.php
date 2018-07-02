<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

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

    <?php if ($discussions) : ?>
        <?php foreach($discussions as $discussion) :?>
            <?php if ($discussion->is_sticky === '1') : ?>
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-64x64 avatar">
                            <img src='<?= $discussion->latest_post->avatar ?>'/>
                        </p>
                    </figure>

                    <div class="media-content">
                        <div class="content">
                            <p class="has-text-grey-light">
                                <span class="is-size-6"><span class="icon has-text-success"><i class="fas fa-thumbtack"></i></span> <a href="<?= $discussion->permalink ?>"><?= $discussion->title ?></a></span><br>
                                <small class="has-text-weight-light"><a href="<?= site_url('users/'.$discussion->latest_post->author) ?>"><?= $discussion->latest_post->author ?></a> replied <?= $discussion->latest_post->created_at ?></small><br>
                                <small><?= $discussion->latest_post->content ?></small>
                            </p>
                        </div>
                    </div>

                    <div class="media-right">
                        <span class="icon has-text-grey-light has-text-weight-light">
                            <i class="far fa-comments"></i>&nbsp;<?= $discussion->count_posts ?>
                        </span>
                    </div>

                </article>
            <?php else : ?>
                <article class="media">
                    <figure class="media-left">
                        <p class="image is-48x48 avatar">
                            <img src='<?= $discussion->latest_post->avatar ?>'/>
                        </p>
                    </figure>

                    <div class="media-content">
                        <div class="content">
                            <p class="has-text-grey-light">
                                <span class="is-size-6"><a href="<?= $discussion->permalink ?>"><?= $discussion->title ?></a></span><br>
                                <small class="has-text-weight-light"><a href="<?= site_url('users/'.$discussion->latest_post->author) ?>"><?= $discussion->latest_post->author ?></a> replied <?= $discussion->latest_post->created_at ?></small>
                            </p>
                        </div>
                    </div>

                    <div class="media-right">
                        <span class="icon has-text-grey-light has-text-weight-light">
                            <i class="far fa-comments"></i>&nbsp;<?= $discussion->count_posts ?>
                        </span>
                    </div>

                </article>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
