<spark-profile :user="user" :team_user='team_user' inline-template>
	<!-- Update Profile Photo -->
	<div class="row">
		<div class='col-xs-12' v-if="user">
			@include('spark::settings.profile.mobile-update-profile-photo')
		</div>
		<!-- Update Contact Information -->
		<div class='col-xs-12'>
			<!-- Update Profile Details -->
			@include('settings.profile.mobile-update-profile-details')
		</div>
		<div class='col-xs-12'>
		</div>
	</div>
</spark-profile>
