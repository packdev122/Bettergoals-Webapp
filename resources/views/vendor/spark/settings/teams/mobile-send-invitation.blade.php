<spark-send-invitation :user="user" :team="team" :team_user='team_user' inline-template>
    <div class="">
        <div class="panel-heading">Team Members</div>

        <div class="panel-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                The invitation has been sent!
            </div>

            <form class="form-horizontal" role="form">
                <!-- E-Mail Address -->
                <div class="form-group row" :class="{'has-error': form.errors.has('email')}" >
                    <div class='col-xs-4'>
                        <img src="/img/icon-with.svg" alt="Calendar" class="img-responsive">
                    </div>
                    <div class="col-xs-8">
                        <label class="control-label">Username</label>
                        <input type="email" class="form-control" name="email" v-model="form.email">
                        <span class="help-block" v-show="form.errors.has('email')">
                            @{{ form.errors.get('email') }}
                        </span><br>
                        <button type="submit" class="btn btn-primary btn-block btn-common"
                                @click.prevent="send"
                                :disabled="form.busy">
                            <span v-if="form.busy">
                                <i class="fa fa-btn fa-spinner fa-spin"></i>Sending
                            </span>
                            <span v-else>
                                Invite
                            </span>
                        </button>
                    </div>
                </div>
                <div class="form-group row team-member" v-for="member in team.users">
                    <div class='col-xs-3'>
                        <img :src="member.photo_url" class="spark-nav-profile-photo m-r-xs">
                    </div>
                    <div class='col-xs-9 member-name'>
                        @{{ member.name }}
                    </div>
                </div>
            </form>
            <hr>
        </div>
    </div>
</spark-send-invitation>
