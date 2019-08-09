<spark-security :user="user" :team_user="team_user" inline-template>
	<div>
		<!-- Update Password -->
		<div class='col-xs-12'>
	    @include('spark::settings.security.mobile-update-password')
		</div>
	    <!-- Two-Factor Authentication -->
	    @if (Spark::usesTwoFactorAuth())
	    	<div v-if="user && ! user.uses_two_factor_auth">
	    		@include('spark::settings.security.enable-two-factor-auth')
	    	</div>

	    	<div v-if="user && user.uses_two_factor_auth">
	    		@include('spark::settings.security.disable-two-factor-auth')
	    	</div>

			<!-- Two-Factor Reset Code Modal -->
	    	@include('spark::settings.security.modals.two-factor-reset-code')
	    @endif
    </div>
</spark-security>
