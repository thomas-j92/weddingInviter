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
                
                <tabs>
                    <tab title="Tab 1" tab-id="tab1" :selected="true">
                        <p>Tab 1 content</p>
                    </tab>
                    <tab title="Tab 2" tab-id="tab2">
                        <p>Tab 2 content</p>
                    </tab>
                    <tab title="Tab 3" tab-id="tab3">
                        <p>Tab 3 content</p>
                    </tab>
                  {{-- <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                  </li> --}}
                </tabs>

                <person-attending></person-attending>

                <person-awaiting-response></person-awaiting-response>

                <person-not-attending></person-not-attending>

                <modal modal_id="editPersonModal" title="Edit Individual">
                    <div class="row">
                        <div class="col-sm-6">
                            Name:
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Name" name="name">
                        </div>
                    </div>              
                </modal> 
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
