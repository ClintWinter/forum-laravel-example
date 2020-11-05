@props(['comments'])

<div {{ $attributes }}>
    @foreach ($comments as $comment)
        <livewire:comment :comment="$comment" :key="$comment['id']" />
    @endforeach
</div>
