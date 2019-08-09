module.exports = {
    props: [
        'user', 'teams', 'currentTeam',
        'hasUnreadNotifications', 'hasUnreadAnnouncements'
    ],


    methods: {
         /**
          * Show the user's notifications.
          */
         showNotifications() {
            Bus.$emit('showNotifications');
        },

        markNotificationsAsRead(){
            Bus.$emit('markAsReadNotifications');
        },

        /**
         * Show the customer support e-mail form.
         */
        showSupportForm() {
            Bus.$emit('showSupportForm');
        }
    }
};
