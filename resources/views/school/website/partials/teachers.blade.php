<section>
    <h3>Our Teachers</h3>

    <div>
        @foreach($teachers as $teacher)
            <div>
                <p>{{ $teacher->name }}</p>
                
            </div>
        @endforeach
    </div>

    <a href="/teachers">View All</a>
</section>