@extends('layouts.main')

@section('content')
<div class="col-md-8 padding-20">
    <div class="row">
        <div class="col-md-12">
            <div class="fb-heading">
                Article Categories
            </div>
            <hr class="style-three">
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-6 margin-bottom-20">
                        <div class="fat-heading-abb">
                            <a href="{{ route('categories.show', [$category->slug, $category->id]) }}">
                                <i class="fa fa-folder"></i> {{ $category->name }}
                                <span class="cat-count">({{ $category->articles_count }})</span>
                            </a>
                        </div>
                        <div class="fat-content-small padding-left-30">
                            <ul>
                                @foreach($category->articles as $article)
                                    <li>
                                        <a href="{{ route('articles.show', [$article->slug, $article->id]) }}">
                                            <i class="fa fa-file-text-o"></i> {{ $article->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{ $categories->links('partials.pagination') }}
    </div>
</div>
@endsection
