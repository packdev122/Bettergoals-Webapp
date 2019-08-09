<?php

namespace Laravel\Spark\Http\Requests\Settings\Teams;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\User;
class CreateInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        return $this->user()->ownsTeam($this->team);
    }

    /**
     * Get the validator for the request.
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        $email = $this->email;
       
        if($this->checkEmail($email)){//Email
            $validator = Validator::make($this->all(), [
                'email' => 'required|email|max:255',
            ]);
        }else{
            //Username
            $validator = Validator::make($this->all(),[]);
            
            if(!$email){
                $validator->after(function ($validator) {
                    $validator->errors()->add('email', 'Username Field is required.');
                });
            }
            $validator->after(function ($validator) {
                $this->validateUsernameExists($validator);
            });
        }

        $validator->after(function ($validator) {
            $this->validateMaxTeamMembersNotExceeded($validator);
        });

        return $validator->after(function ($validator) {
            return $this->verifyEmailNotAlreadyOnTeam($validator, $this->team)
                        ->verifyEmailNotAlreadyInvited($validator, $this->team);
        });
    }
    protected function checkEmail($email) {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');
        return ($find1 !== false && $find2 !== false ? true : false);
     }
    /**
     * Verify that the maximum number of team members hasn't been exceeded.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function validateMaxTeamMembersNotExceeded($validator)
    {
        if ($plan = $this->user()->sparkPlan()) {
            $this->validateMaxTeamMembersNotExceededForPlan($validator, $plan);
        }

        if ($plan = $this->team->sparkPlan()) {
            $this->validateMaxTeamMembersNotExceededForPlan($validator, $plan);
        }
    }

    /**
     * Verify the team member limit hasn't been exceeded for the given plan.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @param  \Laravel\Spark\Plan  $plan
     * @return void
     */
    protected function validateMaxTeamMembersNotExceededForPlan($validator, $plan)
    {
        if (is_null($plan->teamMembers) && is_null($plan->collaborators)) {
            return;
        }

        if ($this->exceedsMaxTeamMembers($plan) || $this->exceedsMaxCollaborators($plan)) {
            $validator->errors()->add('email', 'Please upgrade your subscription to add more team members.');
        }
    }

    /**
     * Determine if the request will exceed the max allowed team members.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaxTeamMembers($plan)
    {
        return ! is_null($plan->teamMembers) &&
               $plan->teamMembers <= $this->team->totalPotentialUsers();
    }

    /**
     * Determine if the request will exceed the max allowed collaborators.
     *
     * @param  \Laravel\Spark\Plan  $plan
     * @return bool
     */
    protected function exceedsMaxCollaborators($plan)
    {
        return ! is_null($plan->collaborators) &&
               $plan->collaborators <= $this->user()->totalPotentialCollaborators();
    }

    /**
     * Verify that the given e-mail is not already on the team.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @param  \Laravel\Spark\Team  $team
     * @return $this
     */
    protected function verifyEmailNotAlreadyOnTeam($validator, $team)
    {
        if ($team->users()->where('username', $this->email)->exists()) {
            $validator->errors()->add('email', 'That user is already on the team.');
        }

        return $this;
    }

    /**
     * Verify that the given e-mail is not already invited.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @param  \Laravel\Spark\Team  $team
     * @return $this
     */
    protected function verifyEmailNotAlreadyInvited($validator, $team)
    {
        if ($team->invitations()->where('email', $this->email)->exists()) {
            $validator->errors()->add('email', 'That user is already invited to the team.');
        }

        return $this;
    }
    protected function validateUsernameExists($validator)
    {
        if (!User::where('username', $this->email)->exists()) {
            // echo 111231;exit;
            $validator->errors()->add('email', 'That user does not exist. Please invite using email.');
        }
        return $this;
    }
}
