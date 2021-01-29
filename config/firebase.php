<?php

return [
    /**
     * ------------------------------------------------------------------------
     * Credentials / Service Account
     * ------------------------------------------------------------------------
     *
     * In order to access a Firebase project and its related services using a
     * server SDK, requests must be authenticated. For server-to-server
     * communication this is done with a Service Account.
     *
     * If you don't already have generated a Service Account, you can do so by
     * following the instructions from the official documentation pages at
     *
     * https://firebase.google.com/docs/admin/setup#initialize_the_sdk
     *
     * Once you have downloaded the Service Account JSON file, you can use it
     * to configure the package.
     *
     * If you don't provide credentials, the Firebase Admin SDK will try to
     * autodiscover them
     *
     * - by checking the environment variable FIREBASE_CREDENTIALS
     * - by checking the environment variable GOOGLE_APPLICATION_CREDENTIALS
     * - by trying to find Google's well known file
     * - by checking if the application is running on GCE/GCP
     *
     * If no credentials file can be found, an exception will be thrown the
     * first time you try to access a component of the Firebase Admin SDK.
     *
     */
    'project_id' => env('FIREBASE_PROJECT_NAME')
];
