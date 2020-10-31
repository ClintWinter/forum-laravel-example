require('./bootstrap');

if (window.location.hash) {
    document.querySelector(window.location.hash).classList.add('bg-yellow-100');

}

window.addEventListener('hashchange', function(event) {
    document.querySelectorAll('[id*="Comment"]').forEach(comment => {
        comment.classList.remove('bg-yellow-100');
    });
    document.querySelector(window.location.hash).classList.add('bg-yellow-100');
});
