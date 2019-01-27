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
                    <tab title="Attending" tab-id="tab_attending" :selected="true">
                        <person-attending></person-attending>
                    </tab>
                    <tab title="Not Attending" tab-id="tab_not_attending">
                        <person-not-attending></person-not-attending>
                    </tab>
                    <tab title="Awaiting Response" tab-id="tab_awaiting_response">
                        <person-awaiting-response></person-awaiting-response>
                    </tab>
                </tabs>

                <modal modal_id="editPersonModal" title="Edit Individual">
                    <div class="row">
                        <div class="col-sm-6">
                            First name:
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="mdl_first_name" v-model="userMdlFirstName" placeholder="Name" name="name">
                        </div>
                    </div>              
                </modal> 
            </div>
        </div>

        <script type="text/javascript" src="{{ asset("js/app.js") }}"></script>
    </body>
</html>
