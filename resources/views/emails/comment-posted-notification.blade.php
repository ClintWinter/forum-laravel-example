<style>
.inner-body {
    width: 50%;
    padding: 20px;
}

h1 {
    font-size: 2rem;
}

@media only screen and (max-width: 600px) {
    * {
        box-sizing: border-box;
    }

    h1 {
        font-size: 1.25rem;
    }

    .inner-body {
        width: 95%;
        padding: 10px 5px;
    }

    .footer {
        width: 100%;
    }
}
</style>

<div style="width:100%; background-color:#e9d8fd; padding:20px 0;">
    <h1 style="text-align:center; color:#6b46c1;">ForumApp</h1>

    <div class="inner-body" style="margin:20px auto; color:#333; background-color:white;">
        <h2>You have a new notification!</h2>

        <p><b>{{ $comment->user->name }}</b> has replied to you with the following message:</p>

        <p style="font-size:1.25rem; color:#666; padding:15px 0;">"{{ $comment->body }}"</p>

        <p style="text-align:center; padding:15px 0;"><a href="{{ url('/posts/'.$comment->post->id.'#Comment'.$comment->id) }}" style="display:inline-block; padding:10px 25px; background-color:#6b46c1; color:white; text-transform:uppercase; font-weight:bold; border-radius:5px; text-decoration:none;">View their Reply</a></p>

        <p>Thank you for using our application!<br> -ForumApp Team</p>
    </div>
</div>
