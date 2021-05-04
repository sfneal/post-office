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
    ],
];
