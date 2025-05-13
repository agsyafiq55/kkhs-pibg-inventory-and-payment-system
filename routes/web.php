<?php

use App\Http\Controllers\ClassRooms\ClassRoomController;
use App\Http\Controllers\Items\ItemController;
use App\Http\Controllers\Items\SupplierController;
use App\Http\Controllers\Students\StudentController;
use App\Livewire\Public\PaymentProcessor;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Routes
Route::prefix('public')->name('public.')->group(function () {
    Route::get('/payment/{studentId}/{packageId}', function ($studentId, $packageId) {
        return view('public.payment', compact('studentId', 'packageId'));
    })->name('payment');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        // Student Routes
        Route::prefix('students')->name('students.')->group(function () {
            Route::get('/', [StudentController::class, 'index'])->name('index');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::get('/{student}', [StudentController::class, 'show'])->name('show');
            Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        });
        
        // ClassRoom Routes
        Route::prefix('classrooms')->name('classrooms.')->group(function () {
            Route::get('/', [ClassRoomController::class, 'index'])->name('index');
            Route::get('/create', [ClassRoomController::class, 'create'])->name('create');
            Route::get('/{classroom}', [ClassRoomController::class, 'show'])->name('show');
            Route::get('/{classroom}/edit', [ClassRoomController::class, 'edit'])->name('edit');
        });
        
        // Item Routes
        Route::prefix('items')->name('items.')->group(function () {
            Route::get('/', [ItemController::class, 'index'])->name('index');
            Route::get('/create', [ItemController::class, 'create'])->name('create');
            Route::get('/{item}', [ItemController::class, 'show'])->name('show');
            Route::get('/{item}/edit', [ItemController::class, 'edit'])->name('edit');
            
            // Variant Routes (nested under items)
            Route::name('variants.')->group(function () {
                Route::get('/{item}/variants/create', function ($item) {
                    return view('admin.items.variant-form', ['item' => App\Models\Item::findOrFail($item)]);
                })->name('create');
                
                Route::get('/{item}/variants/{variant}/edit', function ($item, $variant) {
                    return view('admin.items.variant-form', [
                        'item' => App\Models\Item::findOrFail($item),
                        'variant' => App\Models\ItemVariant::findOrFail($variant)
                    ]);
                })->name('edit');
            });
        });
        
        // Supplier Routes
        Route::prefix('suppliers')->name('suppliers.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('/create', [SupplierController::class, 'create'])->name('create');
            Route::get('/{supplier}', [SupplierController::class, 'show'])->name('show');
            Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
        });

        // Package Routes
        Route::prefix('packages')->name('packages.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PackageController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\PackageController::class, 'create'])->name('create');
            Route::get('/{package}', [App\Http\Controllers\Admin\PackageController::class, 'show'])->name('show');
            Route::get('/{package}/edit', [App\Http\Controllers\Admin\PackageController::class, 'edit'])->name('edit');
            
            // Package Items Routes
            Route::get('/{package}/items/create', function (App\Models\Package $package) {
                return view('admin.packages.items.create', compact('package'));
            })->name('items.create');
            
            Route::get('/{package}/items/{item}/edit', function (App\Models\Package $package, App\Models\PackageItem $item) {
                return view('admin.packages.items.edit', compact('package', 'item'));
            })->name('items.edit');
        });
        
        // Payment Routes
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\PaymentController::class, 'create'])->name('create');
            Route::get('/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('show');
            Route::get('/{payment}/edit', [App\Http\Controllers\Admin\PaymentController::class, 'edit'])->name('edit');
        });
    });
});

require __DIR__.'/auth.php';
