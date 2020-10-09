@props(['comments'])

<div {{ $attributes->merge(['class' => '']) }}>
    @foreach ($comments as $comment)
        <livewire:comment.show
            :comment="$comment"
            :key="$comment['id']" />
    @endforeach
</div>