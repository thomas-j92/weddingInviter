<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WeddingInviter</title>

        <link href="{{ asset("css/app.css") }}" rel="stylesheet" type="text/css">
        <link href="{{ asset("css/open-iconic/css/open-iconic-bootstrap.min.css") }}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div id="root">
                <person-attending></person-attending>

                <person-awaiting-response></person-awaiting-response>

                <person-not-attending></person-not-attending>

                <modal modal_id="editPersonModal" title="Edit Individual"></modal> 
                {{-- <ul v-bind:class="{'red' : isLoading}">
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
                <button v-on:click="addNames" id="add_user_btn">Add</button> --}}
            </div>
        </div>

        <script type="text/javascript" src="{{ asset("js/app.js") }}"></script>
        <script>
            
        </script>
    </body>
</html>
