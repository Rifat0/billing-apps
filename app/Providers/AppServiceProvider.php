<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Mail\UserVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        User::created(function($user){
            retry(5, function() use ($user){
                Mail::to($user)->send(new UserVerify($user));
            }, 100);
        });

        User::updated(function($user){
            if($user->isDirty('email')){
                retry(5, function() use ($user){
                    Mail::to($user)->send(new UserVerify($user));
                }, 100);
            }
        });

        Product::updated(function($product){
            if($product->quantity == 0 && $product->isAvailable()){
                $product->status = Product::UNAVIALABLE_PRODUCT;
                $product->save();
            }
        });
    }
}
