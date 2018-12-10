<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WeddingInviter</title>

        <link href="{{ asset("css/app.css") }}" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="{{ asset("js/app.js") }}"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div id="root">
                <h1>All users</h1>
                <ul v-bind:class="{'red' : isLoading}">
                    <li v-for="(user, index) in users">
                        @{{user.name}}
                        <div v-if="! user.attending">
                            <a v-on:click="markAsAttending(index)">Mark as attending</a>
                        </div>
                    </li>
                </ul>

                <h1>Attending users</h1>
                <ul v-bind:class="{'red' : isLoading}">
                    <li v-for="(user, index) in attending" v-text="user.name"></li>
                </ul>

                <h1>Add New Attendee</h1>
                <input type="text" name="add_user" id="add_user_input" v-model="user_name">
                <button v-on:click="addNames" id="add_user_btn">Add</button>
            </div>
        </div>

        <script>
            var root = new Vue({
                el: '#root',
                data: {
                    user_name: '',
                    users: [
                        {name: "Tommy", rsvp: true, attending: true},
                        {name: "Jessie", rsvp: true, attending: true},
                        {name: "Aaron", rsvp: false, attending: false},
                        {name: "Yasmin", rsvp: false, attending: false},
                    ],
                    className: "red",
                    isLoading: false
                },
                methods: {
                    addNames: function() {
                        this.users.push({
                            name: this.user_name,
                            rsvp: false,
                            attending: false
                        });

                        this.user_name = '';
                    },
                    markAsAttending: function(index) {
                        this.users[index].attending = true;
                    }
                },
                computed: {
                    reversedMessage: function() {
                        return this.title.split("").reverse().join('');
                    },
                    attending: function() {
                        return this.users.filter(user => user.attending);
                    }
                },
                mounted() {
                    // document.querySelector('#add_user_btn').addEventListener('click', () => {
                    //     var input = document.querySelector('#add_user_input');

                    //     root.users.push(input.value);

                    //     input.value = '';
                    // })
                }
            })
        </script>
    </body>
</html>
