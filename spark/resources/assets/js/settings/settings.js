module.exports = {
    props: ['user','teams' , 'teamId' , 'team_user'],


    /**
     * Load mixins for the component.
     */
    mixins: [require('./../mixins/tab-state')],


    /**
     * The component's data.
     */
    data() {
        return {
            billableType: 'user',
            team: 'team',
            // user: 'user'
        };
    },
    created() {
        var self = this;
        this.getTeam();

        Bus.$on('updateTeam', function () {
            self.getTeam();
        });
        // console.log("team_user" , this.team_user);
    },

    /**
     * Prepare the component.
     */
    mounted() {
        this.usePushStateForTabs('.spark-settings-tabs');
    },
    methods : {
        getTeam() {
            axios.get(`/${Spark.pluralTeamString}/${this.teamId}`)
                .then(response => {
                    this.team = response.data;
                });
        },
    }
};
