<update-profile-details :user="user" :team_user="team_user" inline-template>
<div>
    <!-- Success Message -->
    <div class="alert alert-success" v-if="form.successful">
        Your contact information has been updated!
    </div>

    <form  role="form">
        <!-- Name -->
        <div class="form-group row" :class="{'has-error': form.errors.has('name')}">
            <div class="col-xs-4">
                <img src="/img/icon-with.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class='col-xs-8'>
                <label class=" control-label">First & last name</label>
                <input type="text" class="form-control" name="name" v-model="form.name">

                <span class="help-block" v-show="form.errors.has('name')">
                    @{{ form.errors.get('name') }}
                </span>
            </div>
        </div>
        <!-- Username -->
        <div class="form-group row" :class="{'has-error': form.errors.has('name')}">
            <div class="col-xs-4">
                <img src="/img/icon-with.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class='col-xs-8'>
                <label class=" control-label">Username</label>
                <input type="text" class="form-control" name="username" v-model="form.username" style='text-transform:lowercase' autocorrect="off" autocapitalize="none">
                <span class="help-block" v-show="form.errors.has('username')">
                    @{{ form.errors.get('name') }}
                </span>
            </div>
        </div>
        <!-- E-Mail Address -->
        <div class="form-group row" :class="{'has-error': form.errors.has('email')}">
            <div class='col-xs-4'>
                <img src="/img/icon-email.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class='col-xs-8'>
                <label class=" control-label">Email address</label>
                <input type="email" class="form-control" name="email" v-model="form.email">

                <span class="help-block" v-show="form.errors.has('email')">
                    @{{ form.errors.get('email') }}
                </span>
            </div>
        </div>

        <!-- Phone -->
        <div class="form-group row" :class="{'has-error': form.errors.has('phone')}">
            <div class='col-xs-4'>
                <img src="/img/icon-call.svg" alt="Calendar" class="img-responsive">
            </div>
            <div class="col-xs-8 phone-control">
                <label class=" control-label">Mobile number</label>
                <input type="tel" class="form-control" name="phone" id="phone_number" v-model="form.phone">
                <span class="help-block" v-show="form.errors.has('phone')">
                    @{{ form.errors.get('phone') }}
                </span>
                <br><br>
                <div class="alert alert-success message-sent" style='display:none'>
                    Message has been sent.
                </div>
                <button type='button' class="btn btn-primary btn-block btn-common send-sms" > Send SMS test</button>
            </div>
           
        </div>
        <!-- Update Button -->
        <div class="form-group">
            <div >
                <button type="submit" class="btn btn-primary btn-block"
                        @click.prevent="update"
                        :disabled="form.busy">

                    Update profile
                </button>
            </div>
        </div>
    </form>
    <hr>
</div>
</update-profile-details>
