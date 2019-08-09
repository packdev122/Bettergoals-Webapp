Vue.component('update-profile-details', {
    props: ['user' , 'team_user'],

    data() {
        return {
            form: new SparkForm({
                name: '',
                email: '',
                phone: '',
                username: ''
            })
        };
    },
    computed: {
        
        actualPhone: function() {
            if (this.form.phone != '') 
                return "61" + this.form.phone.replace(/\b0+/g, '')
            else 
                return ''
        }
    },
    mounted() {
        console.log("t_user" , this.team_user);
        this.form.phone = this.user.phone;
        this.form.name = this.user.name;
        this.form.email = this.user.email;
        this.form.username = this.user.username;
    },
 
    methods: {
        update() {
            var phone = this.form.phone;
            // this.form.phone = this.actualPhone;
            Spark.put('/api/settings/profile/details', this.form)
                .then(response => {
                    // this.form.phone = phone.replace(/\b0+/g, '');
                    Bus.$emit('updateUser');
                    window.scrollTo(0,0);
                });
        }
    }
});
