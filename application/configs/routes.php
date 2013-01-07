<?php
$config = array(
    Route::create('/', 'HomeResource'),
    Route::create('/c/:short_url', 'CampaignResource'),
    Route::create('/iembed/:short_url', 'ImageEmbedResource'),
    Route::create('/comment/:donation_id', 'CommentResource'),
    Route::create('/sd/:donation_id/:short_url', 'SpawnDonationResource'),
    Route::create('/ipn', 'IPNResource'),
    Route::create('/login', 'LoginResource'),
    Route::create('/logout', 'LogoutResource'),
    Route::create('/verification', 'VerificationResource'),
    Route::create('/account/preferences', 'ManageAccountPrefResource'),
    Route::create('/account/update-password', 'UpdatePasswordResource'),
    Route::create('/account/update-email', 'UpdateEmailResource'),
    Route::create('/account/resend-verification', 'ResendVerificationResource'),
    Route::create('/account/setup', 'AccountSetupResource'),
    Route::create('/account', 'ManageAccountResource')
);