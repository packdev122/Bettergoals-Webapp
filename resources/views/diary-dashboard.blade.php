@extends('layouts/app')
@section('content')


<span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/dashboard"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
<div class="row" >
    <div class="m-dash col-md-4 col-md-offset-4 diary-container" id="post-data">
        @include('partials.diary-partial')
    </div>
</div>
<div class="ajax-load text-center" style="display:none">
	<p><img src="/img/loader.gif">Loading more diaries</p>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
    var page = 0;
    var existing = true;
    var is_loading = false;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            if(existing && !is_loading){
	            page++;
                loadMoreData(page);
            }
	    }
	});


	function loadMoreData(page){
	  $.ajax(
	        {
	            url: '/{{ Auth::user()->currentTeamName() }}/diary_load?page=' + page,
	            type: "get",
	            beforeSend: function()
	            {
                    $('.ajax-load').show();
                    is_loading = true;
	            }
	        })
	        .done(function(data)
	        {
                is_loading = false;
	            if(data.count == 0){
                    $('.ajax-load').html("No more diaries found");
                    $('.ajax-load').show();
	                existing = false;
	                return;
	            }
	            $('.ajax-load').hide();
	            $("#post-data").append(data.html);
	        })
	        .fail(function(jqXHR, ajaxOptions, thrownError)
	        {
	              alert('server not responding...');
	        });
	}
</script>
@endsection