@props(['post', 'comments', 'commentId'])

@if (isset($comments[$commentId]))
    <div {{ $attributes->merge(['class' => '']) }}>
        @foreach ($comments[$commentId] as $comment)
            <livewire:comment.show
                :post="$post"
                :comments="$comments"
                :comment="$comment"
                :key="$comment['id']" />
        @endforeach
    </div>
@endif