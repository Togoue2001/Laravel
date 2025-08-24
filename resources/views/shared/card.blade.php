<div class="card">
    <div class="card-body">
        <h3 class="card-title">
            <a href="/">{{ $course->title }}</a>
        </h3>
        <div class="text-primary bold">
            {{ number_format($course->price, thousands_separator: ' ') }} $
        </div>
    </div>
</div>
