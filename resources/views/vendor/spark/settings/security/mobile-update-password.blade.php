<spark-update-password :user="user" :team_user="team_user" inline-template>
    <div class="">
        <div class="panel-heading">Change Password</div>
        <div class="">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your password has been updated!
            </div>
            <form  role="form">
                <!-- Current Password -->
                <div class="form-group row" :class="{'has-error': form.errors.has('current_password')}">
                    <div class='col-xs-4'>
                        <img src="/img/icon-lock.svg" alt="Calendar" class="img-responsive">
                    </div>
                    <div class='col-xs-8'>
                        <label class=" control-label">Current password</label>
                        <input type="password" class="form-control" name="current_password" v-model="form.current_password">

                        <span class="help-block" v-show="form.errors.has('current_password')">
                            @{{ form.errors.get('current_password') }}
                        </span>
                    </div>
                </div>
                <!-- New Password -->
                <div class="form-group row" :class="{'has-error': form.errors.has('password')}">
                    <div class='col-xs-4'>
                        <img src="/img/icon-lock.svg" alt="Calendar" class="img-responsive">
                    </div>
                    <div class='col-xs-8'>
                        <label class=" control-label">New password</label>
                        <input type="password" class="form-control" name="password" v-model="form.password">

                        <span class="help-block" v-show="form.errors.has('password')">
                            @{{ form.errors.get('password') }}
                        </span>
                    </div>
                </div>

                <!-- New Password Confirmation -->
                <div class="form-group row" :class="{'has-error': form.errors.has('password_confirmation')}">
                    <div class='col-xs-4'>
                        <img src="/img/icon-lock.svg" alt="Calendar" class="img-responsive">
                    </div>
                    <div class='col-xs-8'>
                        <label class=" control-label">Confirm password</label>
                        <input type="password" class="form-control" name="password_confirmation" v-model="form.password_confirmation">
                        <span class="help-block" v-show="form.errors.has('password_confirmation')">
                            @{{ form.errors.get('password_confirmation') }}
                        </span>
                    </div>
                </div>

                <!-- Update Button -->
                <div class="form-group">
                    <div >
                        <button type="submit" class="btn btn-primary btn-lg btn-block"
                                @click.prevent="update"
                                :disabled="form.busy">

                            Change password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</spark-update-password>
