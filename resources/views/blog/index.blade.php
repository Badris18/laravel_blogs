@extends('layouts.app')

@section('content')
<style>
    .blog-card {
        background-color: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .blog-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .blog-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .blog-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .blog-meta {
        font-size: 0.85rem;
        color: #999;
        margin-top: 0.25rem;
    }

    .blog-description {
        font-size: 1rem;
        color: #555;
        margin-bottom: 1rem;
    }

    .read-more {
        font-weight: 600;
        color: #0d6efd;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .read-more:hover {
        color: #084298;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .blog-card {
            padding: 1rem;
        }
        .blog-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .blog-avatar {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
    }

    /* Dark Mode */
    body.dark-mode .blog-card {
        background-color: #1e1e1e;
        color: #eee;
    }

    body.dark-mode .blog-description {
        color: #aaa;
    }

    body.dark-mode .blog-meta {
        color: #888;
    }

    body.dark-mode .read-more {
        color: #66b2ff;
    }

    body.dark-mode .read-more:hover {
        color: #3399ff;
    }
</style>

<div class="container py-5">
    <h1 class="text-center mb-5 fw-bold">📰 Explore Our Latest Posts</h1>

    <div class="d-flex flex-column gap-4">
        @foreach($posts as $post)
            @php
                $imagePath = Str::startsWith($post->image, 'http')
                    ? $post->image
                    : asset('storage/' . $post->image);
            @endphp

            <div class="blog-card">
                <div class="blog-header">
                    <img src="{{ $imagePath }}" alt="Post Image" class="blog-avatar">
                    <div>
                        <h2 class="blog-title">{{ $post->title }}</h2>
                        <div class="blog-meta">
                            Posted {{ $post->created_at->diffForHumans() }}
                            @if($post->category)
                                • {{ $post->category->name }}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="blog-description">{{ Str::limit($post->description, 150) }}</div>

                <a href="{{ route('posts.show', $post) }}" class="read-more">Read More →</a>
            </div>
        @endforeach
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
