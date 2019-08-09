<update-emergency-contact :user="user" :team_user='team_user' inline-template>
    <div>
        <!-- Success Message -->
        <div class="panel-heading">Emergency Contact</div>
        <div class="alert alert-success" v-if="form.successful">
            Your contact information has been updated!
        </div>

        <form  role="form">
            <!-- Name -->
            <div class="form-group row" :class="{'has-error': form.errors.has('emergency_name')}">
                <div class="col-xs-4">
                    <img src="/img/icon-with.svg" alt="Calendar" class="img-responsive">
                </div>
                <div class='col-xs-8'>
                    <label class=" control-label">First & last name</label>
                    <input type="text" class="form-control" name="emergency_name" v-model="form.emergency_name">

                    <span class="help-block" v-show="form.errors.has('emergency_name')">
                        @{{ form.errors.get('name') }}
                    </span>
                </div>
            </div>
            <!-- Phone -->
            <div class="form-group row" :class="{'has-error': form.errors.has('emergency_phone')}">
                <div class='col-xs-4'>
                    <img src="/img/icon-call.svg" alt="Calendar" class="img-responsive">
                </div>
                <div class="col-xs-8 phone-control">
                    <label class=" control-label">Mobile number</label>
                    <input type="tel" class="form-control" name="emergency_phone" v-model="form.emergency_phone">
                    <span class="help-block" v-show="form.errors.has('emergency_phone')">
                        @{{ form.errors.get('phone') }}
                    </span>
                </div>
            
            </div>
            <!-- Update Button -->
            <div class="form-group">
                <div >
                    <button type="submit" class="btn btn-primary btn-block"
                            @click.prevent="update"
                            :disabled="form.busy">
                        Update Emergency
                    </button>
                </div>
            </div>
        </form>
        <hr>
    </div>
</update-emergency-contact>
