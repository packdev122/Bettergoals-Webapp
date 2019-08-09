Vue.component('update-emergency-contact', {
    props: ['user','team_user'],

    data() {
        return {
            form: new SparkForm({
                emergency_name: '',
                emergency_phone: '',
            })
        };
    },
    computed: {
        actualPhone: function() {
            if (this.form.emergency_phone != '') 
                return "61" + this.form.emergency_phone.replace(/\b0+/g, '')
            else 
                return ''
        }
    },
    mounted() {
        this.form.emergency_phone = this.user.emergency_phone.substring(2);
        this.form.emergency_name = this.user.emergency_name;
    },

    methods: {
        update() {
            var phone = this.form.emergency_phone;
            this.form.emergency_phone = this.actualPhone;
            Spark.put('api/settings/profile/emergency', this.form)
                .then(response => {
                    this.form.emergency_phone = phone.replace(/\b0+/g, '');
                    Bus.$emit('updateUser');
                });
        }
    }
});
