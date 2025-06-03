@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Back Link --}}
    <div class="mb-4">
        <a href="javascript:history.back()" class="text-decoration-none text-secondary d-inline-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 1 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            Back
        </a>
    </div>

{{-- Post Card --}}
<div class="card shadow-sm border-0 mb-5 p-4">
    <div class="d-flex align-items-center mb-3">
        <img src="{{ asset('storage/' . $post->image) }}" 
             alt="{{ $post->title }}" 
             class="rounded-circle me-3" 
             style="width: 80px; height: 80px; object-fit: cover;">
        <h1 class="mb-0 fw-bold">{{ $post->title }}</h1>
    </div>
    <p class="fs-5 text-secondary">{!! nl2br(e($post->content)) !!}</p>
</div>
    {{-- Comments Section --}}
    <section class="mb-5">
        <h3 class="mb-4 border-bottom pb-2">💬 Comments ({{ $comments->count() }})</h3>

        <div id="comments" class="d-flex flex-column gap-4">
            @forelse($comments as $comment)
                <div class="card shadow-sm p-3">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fs-5" 
                                 style="width: 48px; height: 48px;">
                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <strong class="d-block">{{ $comment->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                            <p class="mt-2 mb-0">{{ $comment->message }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted fst-italic">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </section>

    {{-- Comment Form --}}
    <section class="card shadow-sm p-4">
        <h4 class="mb-3">Add a Comment</h4>
        <form id="comment-form" autocomplete="off" novalidate>
            @csrf
            <div class="form-floating mb-3">
                <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" required>
                <label for="name">Your Name</label>
                <div class="invalid-feedback">Please enter your name.</div>
            </div>
            <div class="form-floating mb-3">
                <textarea name="message" id="message" class="form-control" placeholder="Your Comment" style="height: 100px;" required></textarea>
                <label for="message">Your Comment</label>
                <div class="invalid-feedback">Please enter a comment.</div>
            </div>
            <button type="submit" class="btn btn-success px-4">Post Comment</button>
        </form>
    </section>
</div>

{{-- Toast Notification --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div id="toastSuccess" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                ✅ Comment added successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(() => {
    const form = document.getElementById('comment-form');

    // Simple client-side validation
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const formData = new FormData(form);

        const res = await fetch('{{ route('posts.comment', $post) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
            },
            body: formData,
        });

        if (!res.ok) {
            alert('Failed to post comment. Please try again.');
            return;
        }

        const data = await res.json();
        if (data.comment) {
            const commentHtml = `
                <div class="card shadow-sm p-3 mb-3">
                    <div class="d-flex align-items-start">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fs-5" 
                                 style="width: 48px; height: 48px;">
                                ${data.comment.name.charAt(0).toUpperCase()}
                            </div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <strong class="d-block">${data.comment.name}</strong>
                            <small class="text-muted">Just now</small>
                            <p class="mt-2 mb-0">${data.comment.message}</p>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('comments').insertAdjacentHTML('afterbegin', commentHtml);
            form.reset();
            form.classList.remove('was-validated');

            // Show toast
            const toastElement = document.getElementById('toastSuccess');
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
    });
})();
</script>
@endsection
