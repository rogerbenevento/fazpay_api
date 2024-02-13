{{-- load docs file into public --}}
@php
    $docs = file_get_contents(public_path('docs/index.html'));
    echo $docs;
@endphp
