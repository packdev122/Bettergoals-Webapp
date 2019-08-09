@extends('layouts/app')
<!--
@section('scripts')
    @if (Spark::billsUsingStripe())
        <script src="https://js.stripe.com/v2/"></script>
    @else
        <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    @endif
@endsection
-->

@section('content')
<spark-settings :team_user="team_user" :user="user" :teams="teams" :team-id='{{ $team->id}}' inline-template>
    <div class='row spark-screen'>
        <div class='m-mobile-settings m-people-modify col-md-4 col-md-offset-4'>
            <span class="m-back"><a href="/{{ Auth::user()->currentTeamName() }}/dashboard"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></span>
            <!-- Profile -->
            @include('spark::settings.mobile-profile')
            <div v-if="user && teams">
                @include('spark::settings.teams.mobile-send-invitation')
            </div>
            <!-- Security -->
            @include('spark::settings.mobile-security')
        </div>
    </div>
</spark-settings>
@endsection
@section('bottom-scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
<script src="/js/jquery-autocapitalize.min.js"></script>
<script>
$('input[name="name"]').autocapitalize({mode:"words"});
$('.send-sms').on('click', function (evt) {
    evt.preventDefault();
    phone = $("#phone_number").val();
    axios.post('/api/sms/test2', {
        phone: phone
    })
    .then(function (response) {
        $(".message-sent").show();
    })
    .catch(function (error) {
        $(".message-sent").hide();
    });
});
</script>
@endsection