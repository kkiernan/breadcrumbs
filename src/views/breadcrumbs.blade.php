@if (Breadcrumbs::exist())
    <div class="container">
        <ol class="breadcrumb">
            @foreach (Breadcrumbs::all() as $crumb)
                @if ($crumb->isActive)
                    <li class="active">{{ $crumb->text }}</li>
                @else
                    <li><a href="{{ $crumb->url }}">{{ $crumb->text }}</a></li>
                @endif
            @endforeach
        </ol>
    </div>
@endif