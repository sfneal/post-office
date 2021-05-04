<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PostOffice Jobs Queue
    |--------------------------------------------------------------------------
    |
    | Specify a Job queue to use when dispatching PostOffice jobs.  Creating a
    | 'mail' queue can be effective for avoiding bottlenecks.
    |
    | type     : string
    | default  : 'default'
    |
    */
    'queue' => env('POST_OFFICE_QUEUE', 'default'),

    /*
    |--------------------------------------------------------------------------
    | PostOffice Queue Driver
    |--------------------------------------------------------------------------
    |
    | Specify a Queue Driver for dispatching PostOffice jobs.
    |
    */
    'driver' => env('POST_OFFICE_QUEUE_DRIVER', config('queue.default')),

    /*
    |--------------------------------------------------------------------------
    | PostOffice Mailable Mailables
    |--------------------------------------------------------------------------
    |
    */
    'mailables' => [
        /*
        |--------------------------------------------------------------------------
        | PostOffice Mailable view
        |--------------------------------------------------------------------------
        |
        | Declare a default view to be used by `AbstractMailable` extensions.
        |
        | type     : string
        | default  : 'post-office::email'
        |
        */
        'view' => env('POST_OFFICE_MAILABLE_VIEW', 'post-office::email'),

        /*
        |--------------------------------------------------------------------------
        | PostOffice Mailable footer
        |--------------------------------------------------------------------------
        |
        */
        'footer' => [
            /*
            |--------------------------------------------------------------------------
            | Enabled/disabled footer
            |--------------------------------------------------------------------------
            |
            | Enable/disable adding a footer to the default mailable view.
            |
            | type     : bool
            | default  : false
            |
            */
            'enabled' => env('POST_OFFICE_MAILABLE_FOOTER', false),

            /*
            |--------------------------------------------------------------------------
            | Footer address
            |--------------------------------------------------------------------------
            |
            | Specify a physical address to be displayed in the mailable footer.
            |
            | type     : string
            | default  : null
            |
            */
            'address' => null,

            /*
            |--------------------------------------------------------------------------
            | Footer unsubscription route
            |--------------------------------------------------------------------------
            |
            | Specify a route to be used for user's to unsubscribe from notifications.
            |
            | type     : string
            | default  : null
            |
            */
            'unsubscribe_route' => null,
        ],
    ],
];
