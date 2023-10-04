<template>
    <div class="dropdown dropdown-end">
        <!-- Toggle notification menu -->
        <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <svg xmlns="http://www.w3.org/2000/svg" ref="toggle_icon_notifications" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <span ref="toggle_notifications_number" class="badge badge-sm indicator-item badge-primary" v-bind:class="{ hidden: !this.hasUnreadNotifications }"></span>
            </div>
        </label>

        <div tabindex="0" class="mt-3 card card-compact dropdown-content w-96 bg-base-100 shadow z-50">
            <div class="card-body">
                <h3 class="card-title  justify-center">
                    Notifications
                </h3>

                <div class="divider my-0"></div>

                <ul class="max-h-[350px] overflow-y-scroll">
                    <li v-for="(notification, index) in this.notifications" :key="notification.id" class="hover:bg-slate-200 flex items-center rounded mb-3 mr-2 pt-2 dark:hover:bg-slate-700"
                    :class="'notification-' + notification.id" :data-index="index">
                        <div class="indicator w-full">
                            <a v-on:mouseover.prevent="markNotificationAsRead(notification)"
                                :href="getNotificationUrl(notification)" class="p-3 flex items-center">
                                <!-- Icon -->
                                <i class="fa-solid fa-triangle-exclamation text-3xl text-primary mr-3" aria-hidden="true"></i>

                                <!-- Message -->
                                <span v-html="formatMessage(notification)" class="w-full"></span>

                                <!-- Badge new -->
                                <span v-if="notification.read_at === null" :class="'notification-' + notification.id + '-new'" class="badge badge-sm indicator-item badge-primary right-3">New</span>
                            </a>
                        </div>
                        <a v-on:click.prevent="deleteNotification(notification)" class="cursor-pointer tooltip tooltip-left" data-tip="Supprimer la notification">
                            <i class="fa-solid fa-trash text-2xl text-error mr-3" aria-hidden="true"></i>
                        </a>
                    </li>

                    <li>
                        <p v-if="!Array.isArray(this.notifications) || !this.notifications.length" class="m-2 text-center">
                            Vous n'avez pas de notifications
                        </p>
                    </li>
                </ul>

                <!-- Mark all as read -->
                <div class="mb-1" v-if="this.hasUnreadNotifications">
                    <div class="divider my-0"></div>

                    <button v-on:click.prevent="this.markAllNotificationsAsRead" class="btn btn-primary btn-block" type="button">
                        Marquer toutes les notifications comme lues
                    </button>
                </div>

            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: {
        routeNotifications: String,
        routeDeleteNotification: String,
        routeMarkNotificationAsRead: String,
        routeMarkAllNotificationsAsRead: String
    },
    data() {
        return {
            notifications: null,
            unreadNotificationsCount: 0,
            hasUnreadNotifications: false
        }
    },

    mounted() {
        this.list()
    },

    watch: {
        hasUnreadNotifications: function () {
            this.updateBell();
        },
    },

    methods: {
        async list() {
            await axios.get(this.routeNotifications).then(({data})=>{
                this.notifications = data.notifications
                this.unreadNotificationsCount = data.unreadNotificationsCount
                this.hasUnreadNotifications = data.hasUnreadNotifications
            }).catch(({ response })=>{
                console.error(response)
            })
        },

        /**
         * Format the message with vsprintf before rendering.
         *
         * @param {object} notification The current notification that is handled.
         *
         * @return {string} The parsed message.
         */
         formatMessage: function (notification) {
            return vsprintf(notification.data.message, notification.data.message_key);
        },

        /**
         * Get the notification URL related to the notification `type`.
         *
         * @param {object} notification The current notification that is handled.
         *
         * @return {string} The notification URL.
         */
        getNotificationUrl: function (notification) {
            if (notification.data.type === 'alert') {
                return notification.data.url;
            }

            return '';
        },

        /**
         * Handle the bell, depending if the user has new notification or not.
         *
         * @return {void}
         */
        updateBell: function () {
            if (this.hasUnreadNotifications) {
                this.$refs.toggle_notifications_number.textContent = this.unreadNotificationsCount;
                this.$refs.toggle_icon_notifications.classList.add('animate-ringing');
                //this.$refs.toggle_mark_all_notifications_as_read.classList.remove('d-block');
            } else {
                this.$refs.toggle_notifications_number.textContent = "0";
                this.$refs.toggle_icon_notifications.classList.remove('animate-ringing');
                //this.$refs.toggle_mark_all_notifications_as_read.classList.remove('hidden');
            }
        },

        /**
         * Delete a notification.
         *
         * @param {object} notification The notification to delete.
         *
         * @return {void}
         */
        async deleteNotification (notification) {
            await axios
                .delete(this.routeDeleteNotification + '/' + notification.id)
                .then(function(response) {
                    if (!response.error) {
                        this.removeNotification(notification);
                    }
                }.bind(this))
                .catch(function (error) {
                    console.log('Erreur lors de la suppression de la notification. ' + error);
                });
        },

        /**
         * Remove the `new` badge on the notification.
         *
         * @param {object} notification The notification where the `new` badge must be removed.
         *
         * @return {void}
         */
        removeNotification: function (notification) {
            let notifications = document.getElementsByClassName('notification-' + notification.id);

            Array.from(notifications).forEach((notification) => {
                // Remove notification from the array list.
                let index =notification.getAttribute('data-index');
                this.notifications.splice(index, 1);

                // Remove notification from the HTML Elements
                notification.parentNode.removeChild(notification);
            });

            let hasStillNewNotifications = this.notifications.find(function (notification) {
                return notification.read_at === null;
            });

            if (typeof hasStillNewNotifications == 'undefined') {
                this.hasUnreadNotifications = false;
                this.updateBell();
            } else {
                this.updateNotificationsCounter();
            }
        },

        /**
         * Update the notifications counter.
         *
         * @return {void}
         */
        updateNotificationsCounter: function () {
            this.$refs.toggle_notifications_number.textContent = this.notifications.reduce(function (count, notification) {
                return count + (notification.read_at === null ? 1 : 0);
            }, 0);
        },

        /**
         * Mark a notification as read.
         *
         * @param {object} notification The current notification to mark has read.
         *
         * @return {true|void} When the notification is already read.
         */
        async markNotificationAsRead (notification) {
            // Prevent for sending unnecessary AJAX requests.
            if (notification.read_at !== null) {
                return true;
            }

            await axios
                .post(this.routeMarkNotificationAsRead, { id: notification.id })
                .then(function(response) {
                    if (!response.error) {
                        this.removeNewBadge(notification);

                        let hasStillNewNotifs = this.notifications.find(function (notif) {
                            return notif.read_at === null;
                        });

                        if (typeof hasStillNewNotifs == 'undefined') {
                            this.hasUnreadNotifications = false;
                            this.updateBell();
                        } else {
                            this.updateNotificationsCounter();
                        }
                    }
                }.bind(this))
                .catch(function (error) {
                    console.log('Erreur lors du marquage de la notification comme lue. ' + error);
                })
        },

        /**
         * Remove the `new` badge on the notification.
         *
         * @param {object} notification The notification where the `new` badge must be removed.
         *
         * @return {void}
         */
        removeNewBadge: function (notification) {
            notification.read_at = new Date();
        },

        /**
         * Mark all notifications as read.
         *
         * @return {void}
         */
         async markAllNotificationsAsRead () {
            await axios
                .post(this.routeMarkAllNotificationsAsRead)
                .then(function(response) {
                    if (!response.error) {
                        this.notifications.forEach(function(notification) {
                            if (notification.read_at === null) {
                                this.removeNewBadge(notification);
                            }
                        }.bind(this));
                    }
                }.bind(this))
                .catch(function (error) {
                    console.log('Erreur lors du marquage de toutes les notifications comme lues. ' + error);
                });

            this.hasUnreadNotifications = false;
            this.updateBell();
        },
    }
}
</script>
