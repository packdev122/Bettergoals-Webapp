@extends('layouts/app')
@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>   
@endsection
@section('content')
<div class="row m-gallery">
    <div class="col-md-4 col-md-offset-4">
        <!-- Application Details -->
        <h3 class="text-center title"><span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/dashboard"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>Gallery</h3>
        <div class="row">
            @foreach($diaries as $entry)
                <div class="col-xs-4 img-gallery-container">
                    @if($entry->video)
                    <video width="100%" height="90px" controls style='border: 1px solid #e8eaec;' poster="/thumbnails/{{$entry->thumbnail}}" class="video-gallery">
                        <source src="/videos/{{$entry->video}}" type="video/mp4">
                        <source src="/videos/{{$entry->video}}" type="video/avi">
                        <source src="/videos/{{$entry->video}}" type="video/ogg">
                    </video>
                    @elseif($entry->thumbnail)
                        <img src="/thumbnails/{{$entry->thumbnail}}" width="100%" height="100px" class="img-gallery">
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    
</div>
@endsection
@section('bottom-scripts')
<script type="text/javascript">
    $(".video-gallery").on("click",function(){
        event.preventDefault();
        $(this).requestFullscreen();
    })
    $('.photo-overlay').hide();

    $('.img-gallery').click(function(event) {
        event.preventDefault();
        var imageUrl = $(this).attr('src');
        $('.photo-overlay').show().css('background-image', 'url(' + imageUrl + ')');
    });

    $('.close-photo-overlay').css('cursor' , 'pointer').click(function() {
        $('.photo-overlay').hide();                                                                                                    
    });
</script>
@endsection