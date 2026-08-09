<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use App\Models\SubscriptionPackage;
use App\Models\School;

foreach (SubscriptionPackage::all() as $p) {
    echo $p->id . ' ' . $p->name . ' ' . json_encode($p->permissions) . "\n";
}

echo "---\n";
foreach (School::all() as $s) {
    echo $s->id . ' ' . $s->slug . ' package=' . ($s->subscription_package_id ?? 'null') . ' status=' . $s->status . ' active=' . $s->is_active . "\n";
}
