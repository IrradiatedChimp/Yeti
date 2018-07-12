<article class="media">
    <figure class="media-left">
        <p class="image is-64x64 avatar">
            {avatar}
        </p>
    </figure>

    <div class="media-content">
        <div class="content">
            <p class="has-text-grey-light">
                <span class="is-size-6"><span class="icon has-text-success"><i class="fas fa-thumbtack"></i></span> {permalink}</span><br>
                <small class="has-text-weight-light">{last_reply_by} replied {last_reply_time}</small><br>
                <small>{content}</small><br>
                {category}
            </p>
        </div>
    </div>

    <div class="media-right">
        <span class="icon has-text-grey-light has-text-weight-light">
            <i class="far fa-comments"></i>&nbsp;{post_count}
        </span>
    </div>

</article>
