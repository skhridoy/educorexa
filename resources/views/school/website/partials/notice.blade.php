<section>
    <h3>Latest Notices</h3>

    <ul>
        @foreach($notices as $notice)
            <li>{{ $notice->title }}</li>
        @endforeach
    </ul>

    <a href="/notices">View All</a>
</section>