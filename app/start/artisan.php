<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Console
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::resolve('SendNotificationEmailsCommand');

Artisan::resolve('Icy\LegitProof\Console\LegitProofCrawlerCommand');
Artisan::resolve('Icy\Steam\Console\UpdateVacBansCommand');
Artisan::resolve('Icy\Esea\Console\DownloadBanListCommand');
Artisan::resolve('Icy\Esea\Console\ConvertSteamIdFromTextTo64Command');