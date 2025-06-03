@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">📝 Latest Blog Posts</h1>
    <div class="row justify-content-center">
        @foreach($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    @php
                        $imagePath = Str::startsWith($post->image, 'http') 
                            ? $post->image 
                            : asset('storage/' . $post->image);
                    @endphp

                    <img src="{{ $imagePath }}" 
                         alt="Post Image"
                         class="card-img-top mx-auto mt-3 rounded-circle shadow"
                         style="width: 100px; height: 100px; object-fit: cover;">

                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($post->description, 100) }}</p>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-primary">
                            Read More →
                        </a>
                    </div>

                    <div class="card-footer text-center text-muted small bg-light">
                        Posted {{ $post->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection